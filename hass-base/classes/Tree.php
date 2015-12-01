<?php
/**
 * HassCMS (http://www.hassium.org/)
 *
 * @link http://github.com/hasscms for the canonical source repository
 * @copyright Copyright (c) 2016-2099 Hassium Software LLC.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace hass\base\classes;
use yii\base\InvalidParamException;
/**
 *
 * @package hass\package_name
 * @author zhepama <zhepama@gmail.com>
 * @since 0.1.0
 */
class Tree
{

    /**
     * @var array
     */
    protected $nodes = array();
    /**
     * @var array
     */
    protected $options = array();
    /**
     * Constructor.
     *
     * @param array $data    The data for the tree (array of associative arrays)
     * @param array $options [optional] Currently, the only supported key is "rootId"
     *                       (ID of the root node)
     */
    public function __construct(array $data, array $options = array())
    {
        $this->options = $options;
        if (!isset($this->options['rootid'])) {
            $this->options['rootid'] = 0;
        }
        $this->build($data, $options);
    }
    /**
     * Returns a flat, sorted array of all node objects in the tree.
     * 单层级的..排序数组
     * @return Node[] Nodes, sorted as if the tree was hierarchical,
     *                i.e.: the first level 1 item, then the children of
     *                the first level 1 item (and their children), then
     *                the second level 1 item and so on.
     */
    public function getNodes()
    {
        $nodes = array();
        foreach ($this->nodes[$this->options['rootid']]->getDescendants() as $subnode) {
            $nodes[] = $subnode;
        }
        return $nodes;
    }
    /**
     * Returns a single node from the tree, identified by its ID.
     *
     * @param int $id Node ID
     *
     * @throws \InvalidArgumentException
     *
     * @return Node
     */
    public function getNodeById($id)
    {
        if (empty($this->nodes[$id])) {
            throw new InvalidParamException("Invalid node primary key $id");
        }
        return $this->nodes[$id];
    }
    /**
     * Returns an array of all nodes in the root level
     * 多层级父子关系的排序数组
     * @return Node[] Nodes in the correct order
     */
    public function getRootNodes()
    {
        return $this->nodes[$this->options['rootid']]->getChildren();
    }
    /**
     * Returns the first node for which a specific property's values of all ancestors
     * and the node are equal to the values in the given argument.
     *
     * Example: If nodes have property "name", and on the root level there is a node with
     * name "A" which has a child with name "B" which has a child which has node "C", you
     * would get the latter one by invoking getNodeByValuePath('name', ['A', 'B', 'C']).
     * Comparison is case-sensitive and type-safe.
     *
     * @param string $name
     * @param array  $search
     *
     * @return Node|null
     */
    public function getNodeByValuePath($name, array $search)
    {
        $findNested = function (array $nodes, array $tokens) use ($name, &$findNested) {
            $token = array_shift($tokens);
            foreach ($nodes as $node) {
                $nodeName = $node->get($name);
                if ($nodeName === $token) {
                    // Match
                    if (count($tokens)) {
                        // Search next level
                        return $findNested($node->getChildren(), $tokens);
                    } else {
                        // We found the node we were looking for
                        return $node;
                    }
                }
            }
            return null;
        };
        return $findNested($this->getRootNodes(), $search);
    }
    /**
     * Core method for creating the tree
     *
     * @param array $data The data from which to generate the tree
     *
     * @throws InvalidParentException
     */
    private function build(array $data)
    {
        $children = array();
        // Create the root node
        $this->nodes[$this->options['rootid']] = $this->createNode(
            array(
                'id'     => $this->options['rootid'],
                'parent' => null,
            )
        );
        foreach ($data as $row) {
            $this->nodes[$row['id']] = $this->createNode($row);
            if (empty($children[$row['parent']])) {
                $children[$row['parent']] = array($row['id']);
            } else {
                $children[$row['parent']][] = $row['id'];
            }
        }
        foreach ($children as $pid => $childids) {
            foreach ($childids as $id) {
                if ($pid == $id) {
                    throw new InvalidParamException(
                        "Node with ID $id references its own ID as parent ID"
                    );
                }
                if (isset($this->nodes[$pid])) {
                    $this->nodes[$pid]->addChild($this->nodes[$id]);
                } else {
                    $pid = 0; //如果父的pid不存在,则父的pid为0
                    $this->nodes[$pid]->addChild($this->nodes[$id]);
                }
            }
        }
    }
    /**
     * Returns a textual representation of the tree
     *
     * @return string
     */
    public function __toString()
    {
        $str = array();
        foreach ($this->getNodes() as $node) {
            $indent1st = str_repeat('  ', $node->getLevel() - 1).'- ';
            $indent    = str_repeat('  ', ($node->getLevel() - 1) + 2);
            $node      = (string) $node;
            $str[]     = "$indent1st" . str_replace("\n", "$indent\n  ", $node);
        }
        return join("\n", $str);
    }
    /**
     * Creates and returns a node with the given properties
     *
     * Can be overridden by subclasses to use a Node subclass for nodes.
     *
     * @param array $properties
     *
     * @return Node
     */
    protected function createNode(array $properties)
    {
        return new Node($properties);
    }
}