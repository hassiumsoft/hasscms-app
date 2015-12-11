<?php
/**
 *
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
namespace hass\composer;

use Composer\Package\PackageInterface;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class Installer extends \Composer\Installers\Installer
{

    /**
     * Package types to installer class map
     *
     * @var array
     */
    private $supportedTypes = array(
        'hass' => 'HassInstaller',
    );

    /**
     *
     * {@inheritDoc}
     *
     */
    public function getInstallPath(PackageInterface $package)
    {
        $type = $package->getType();
        $frameworkType = $this->findFrameworkType($type);
        if ($frameworkType === false) {
            throw new \InvalidArgumentException('Sorry the package type of this package is not yet supported.');
        }
        $class = 'hass\\composer\\' . $this->supportedTypes[$frameworkType];
        $installer = new $class($package, $this->composer, $this->getIO());
        return dirname(dirname(dirname(__DIR__)))."\\".$installer->getInstallPath($package, $frameworkType);
    }

    /**
     * Finds a supported framework type if it exists and returns it
     *
     * @param  string $type
     * @return string
     */
    protected function findFrameworkType($type)
    {
        $frameworkType = false;

        krsort($this->supportedTypes);

        foreach ($this->supportedTypes as $key => $val) {
            if ($key === substr($type, 0, strlen($key))) {
                $frameworkType = substr($type, 0, strlen($key));
                break;
            }
        }

        return $frameworkType;
    }


    /**
     * Get the second part of the regular expression to check for support of a
     * package type
     *
     * @param string $frameworkType
     * @return string
     */
    protected function getLocationPattern($frameworkType)
    {
        $pattern = false;
        if (! empty($this->supportedTypes[$frameworkType])) {
            $frameworkClass = 'hass\\composer\\' . $this->supportedTypes[$frameworkType];
            /** @var BaseInstaller $framework */
            $framework = new $frameworkClass(null, $this->composer, $this->getIO());
            $locations = array_keys($framework->getLocations());
            $pattern = $locations ? '(' . implode('|', $locations) . ')' : false;
        }
        return $pattern ?  : '(\w+)';
    }

    /**
     * Get I/O object
     *
     * @return IOInterface
     */
    private function getIO()
    {
        return $this->io;
    }
}

