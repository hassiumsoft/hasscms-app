<?php
/**
 *
* HassCMS (http://www.hassium.org/)
*
* @link http://github.com/hasscms for the canonical source repository
* @copyright Copyright (c) 2016-2099 Hassium Software LLC.
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace hass\attachment\actions;
use yii\web\HttpException;

/**
*
* @package hass\package_name
* @author zhepama <zhepama@gmail.com>
* @since 0.1.0
 */
class ViewAction extends BaseAction
{
    /**
     * @var string path request param
     */
    public $pathParam = 'path';
    /**
     * @var boolean, whether the browser should open the file within the browser window. Defaults to false,
     * meaning a download dialog will pop up.
     */
    public $inline;

    /**
     * @return static
     * @throws HttpException
     * @throws \HttpException
     */
    public function run()
    {
        $path = \Yii::$app->request->get($this->pathParam);
        $filesystem = $this->getFileStorage()->getFilesystem();
        if ($filesystem->has($path) === false) {
            throw new HttpException(404);
        }
        return \Yii::$app->response->sendStreamAsFile(
            $filesystem->readStream($path),
            pathinfo($path, PATHINFO_BASENAME),
            [
                'mimeType' => $filesystem->getMimetype($path),
                'inline' => $this->inline
            ]
        );
    }
}
