<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Wolfram Kriesing <wolfram@kriesing.de>                      |
// +----------------------------------------------------------------------+
//
//  $Id: Common.php,v 1.35.2.2 2009/03/12 17:19:52 dufuz Exp $

require_once 'Tree/Tree.php';
require_once 'Tree/Error.php';

/**
 * common tree class, implements common functionality
 *
 *
 * @access     public
 * @author     Wolfram Kriesing <wolfram@kriesing.de>
 * @version    2001/06/27
 * @package    Tree
 */
class Tree_Common
{
     /**
     * @var array   you need to overwrite this array and give the keys/
     *              that are allowed
     */
    var $_forceSetOption = false;

    /**
     * put proper value-keys are given in each class, depending
     * on the implementation only some options are needed or allowed,
     * see the classes which extend this one
     *
     * @access public
     * @var    array   saves the options passed to the constructor
     */
    var $options =  array();


    // {{{ getChildId()

    /**
     * @version    2002/01/18
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getChildId($id)
    {
        $child = $this->getChild($id);
        return $child['id'];
    }

    // }}}
    // {{{ getChildrenIds()

    /**
     * get the ids of the children of the given element
     *
     * @version 2002/02/06
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   integer ID of the element that the children shall be
     *                  retreived for
     * @param   integer how many levels deep into the tree
     * @return  mixed   an array of all the ids of the children of the element
     *                  with id=$id, or false if there are no children
     */
    function getChildrenIds($id, $levels = 1)
    {
        // returns false if no children exist
        if (!($children = $this->getChildren($id, $levels))) {
            return array();
        }
        // return an empty array, if you want to know
        // if there are children, use hasChildren
        if ($children && sizeof($children)) {
            foreach ($children as $aChild) {
                $childrenIds[] = $aChild['id'];
            }
        }

        return $childrenIds;
    }

    // }}}
    // {{{ getAllChildren()

    /**
     * gets all the children and grand children etc.
     *
     * @version 2002/09/30
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   integer ID of the element that the children shall be
     *                  retreived for
     *
     * @return  mixed   an array of all the children of the element with
     *                  id=$id, or false if there are no children
     */
     // FIXXXME remove this method and replace it by getChildren($id,0)
    function getAllChildren($id)
    {
        $retChildren = false;
        if ($children = $this->hasChildren($id)) {
            $retChildren = $this->_getAllChildren($id);
        }
        return $retChildren;
    }

    // }}}
    // {{{ _getAllChildren()

    /**
     * this method gets all the children recursively
     *
     * @see getAllChildren()
     * @version 2002/09/30
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   integer ID of the element that the children shall be
     *                  retreived for
     *
     * @return  mixed   an array of all the ids of the children of the element
     *                  with id=$id, or false if there are no children
     */
    function &_getAllChildren($id)
    {
        $retChildren = array();
        if ($children = $this->getChildren($id)) {
            foreach ($children as $key => $aChild) {
                $retChildren[] = &$children[$key];
                $retChildren = array_merge($retChildren,
                        $this->_getAllChildren($aChild['id']));
            }
        }
        return $retChildren;
    }

    // }}}
    // {{{ getAllChildrenIds()

    /**
     * gets all the children-ids and grand children-ids
     *
     * @version 2002/09/30
     * @access  public
     * @author  Kriesing <wolfram@kriesing.de>
     * @param   integer ID of the element that the children shall
     *          be retreived for
     *
     * @return  mixed   an array of all the ids of the children of the element
     *                  with id=$id,
     *                  or false if there are no children
     */
    function getAllChildrenIds($id)
    {
        $childrenIds = array();
        if ($allChildren = $this->getAllChildren($id)) {
            $childrenIds = array();
            foreach ($allChildren as $aNode) {
                $childrenIds[] = $aNode['id'];
            }
        }
        return $childrenIds;
    }

    // }}}
    // {{{ getParentId()

    /**
     * get the id of the parent for the given element
     *
     * @version 2002/01/18
     * @access  public
     * @param   integer the id of the element for which the parentId
     *                  shall be retreived
     * @author Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getParentId($id)
    {
        $parent = $this->getParent($id);
        return $parent['id'];
    }

    // }}}
    // {{{ getParents()

    /**
     * this gets all the preceeding nodes, the parent and it's parent and so on
     *
     * @version 2002/08/19
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   integer the id of the element for which the parentId shall
     *                  be retreived
     * @return  array   of the parent nodes including the node with id $id
     */
    function getParents($id)
    {
        $path = $this->getPath($id);
        $parents = array();
        if (sizeof($path)) {
            foreach($path as $aNode) {
                $parents[] = $aNode;
            }
        }
        return $parents;
    }

    // }}}
    // {{{ getParentsIds()

    /**
     * get the ids of the parents and all it's parents and so on
     * it simply returns the ids of the elements returned by getParents()
     *
     * @see getParents()
     * @version 2002/08/19
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   integer $id the id of the element for which the parentId
     *          shall be retreived
     *
     * @return     array   of the ids
     */
    function getParentsIds($id)
    {
        $parents = $this->getParents($id);
        $parentsIds = array();
        if (sizeof($parents)) {
            foreach($parents as $aNode) {
                $parentsIds[] = $aNode['id'];
            }
        }
        return $parentsIds;
    }

    // }}}
    // {{{ getNextId()

    /**
     * @version    2002/01/18
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getNextId($id)
    {
        $next = $this->getNext($id);
        return $next['id'];
    }

    // }}}
    // {{{ getPreviousId()

    /**
     * @version    2002/01/18
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getPreviousId($id)
    {
        $previous = $this->getPrevious($id);
        return $previous['id'];
    }

    // }}}
    // {{{ getLeftId()

    /**
     * @version    2002/01/18
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getLeftId($id)
    {
        $left = $this->getLeft($id);
        return $left['id'];
    }

    // }}}
    // {{{ getRightId()

    /**
     * @version    2002/01/18
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getRightId($id)
    {
        $right = $this->getRight($id);
        return $right['id'];
    }

    // }}}
    // {{{ getFirstRootId()

    /**
     * @version    2002/04/16
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getFirstRootId()
    {
        $firstRoot = $this->getFirstRoot();
        return $firstRoot['id'];
    }

    // }}}
    // {{{ getRootId()

    /**
     * @version    2002/04/16
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function getRootId()
    {
        $firstRoot = $this->getRoot();
        return $firstRoot['id'];
    }

    // }}}
    // {{{ getPathAsString()

    /**
     * returns the path as a string
     *
     * @access  public
     * @version 2002/03/28
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   mixed   $id     the id of the node to get the path for
     * @param   integer If offset is positive, the sequence will
     *                  start at that offset in the array .  If
     *                  offset is negative, the sequence will start that far
     *                  from the end of the array.
     * @param   integer If length is given and is positive, then
     *                  the sequence will have that many elements in it. If
     *                  length is given and is negative then the
     *                  sequence will stop that many elements from the end of
     *                  the array. If it is omitted, then the sequence will
     *                  have everything from offset up until the end
     *                  of the array.
     * @param   string  you can tell the key the path shall be used to be
     *                  constructed with i.e. giving 'name' (=default) would
     *                  use the value of the $element['name'] for the node-name
     *                  (thanks to Michael Johnson).
     *
     * @return  array   this array contains all elements from the root
     *                  to the element given by the id
     */
    function getPathAsString($id, $seperator = '/',
                                $offset = 0, $length = 0, $key = 'name')
    {
        $path = $this->getPath($id);
        foreach ($path as $aNode) {
            $pathArray[] = $aNode[$key];
        }

        if ($offset) {
            if ($length) {
                $pathArray = array_slice($pathArray, $offset, $length);
            } else {
                $pathArray = array_slice($pathArray, $offset);
            }
        }

        $pathString = '';
        if (sizeof($pathArray)) {
            $pathString = implode($seperator, $pathArray);
        }
        return $pathString;
    }

    // }}}


    //
    //  abstract methods, those should be overwritten by the implementing class
    //

    // {{{ getPath()

    /**
     * gets the path to the element given by its id
     *
     * @abstract
     * @version 2001/10/10
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   mixed   $id     the id of the node to get the path for
     * @return  array   this array contains all elements from the root
     *                  to the element given by the id
     */
    function getPath($id)
    {
        return $this->_raiseError(TREE_ERROR_NOT_IMPLEMENTED,
                __FUNCTION__, __LINE__);
    }

    // }}}
    // {{{ _preparePath()

    /**
     * gets the path to the element given by its id
     *
     * @version 2003/05/11
     * @access  private
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   mixed   $id     the id of the node to get the path for
     * @return  array   this array contains the path elements and the sublevels
     *                  to substract if no $cwd has been given.
     */
    function _preparePath($path, $cwd = '/', $separator = '/'){
        $elems = explode($separator, $path);
        $cntElems = sizeof($elems);
        // beginning with a slash
        if (empty($elems[0])) {
            $beginSlash = true;
            array_shift($elems);
            $cntElems--;
        }
        // ending with a slash
        if (empty($elems[$cntElems-1])) {
            $endSlash = true;
            array_pop($elems);
            $cntElems--;
        }
        // Get the real path, and the levels
        // to substract if required
        $down = 0;
        while ($elems[0] == '..') {
            array_shift($elems);
            $down++;
        }
        if ($down >= 0 && $cwd == '/') {
            $down = 0;
            $_elems = array();
            $sublevel = 0;
            $_elems = array();
        } else {
            list($_elems, $sublevel) = $this->_preparePath($cwd);
        }
        $i = 0;
        foreach($elems as $val){
            if (trim($val) == '') {
                return $this->_raiseError(TREE_ERROR_INVALID_PATH,
                            __FUNCTION__, __LINE__);
            }
            if ($val == '..') {
                 if ($i == 0) {
                    $down++;
                 } else {
                    $i--;
                 }
            } else {
                $_elems[$i++] = $val;
            }
        }
        if (sizeof($_elems) < 1){
            return $this->_raiseError(TREE_ERROR_EMPTY_PATH,
                        __FUNCTION__, __LINE__);
        }
        return array($_elems, $sublevel);
    }

    // }}}
    // {{{ getLevel()

    /**
     * get the level, which is how far below the root the element
     * with the given id is
     *
     * @abstract
     * @version    2001/11/25
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @param      mixed   $id     the id of the node to get the level for
     *
     */
    function getLevel($id)
    {
        return $this->_raiseError(TREE_ERROR_NOT_IMPLEMENTED,
                        __FUNCTION__, __LINE__);
    }

    // }}}
    // {{{ isChildOf()

    /**
     * returns if $childId is a child of $id
     *
     * @abstract
     * @version    2002/04/29
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @param      int     id of the element
     * @param      int     id of the element to check if it is a child
     * @param      boolean if this is true the entire tree below is checked
     * @return     boolean true if it is a child
     */
    function isChildOf($id, $childId, $checkAll = true)
    {
        return $this->_raiseError(TREE_ERROR_NOT_IMPLEMENTED,
                    __FUNCTION__, __LINE__);
    }

    // }}}
    // {{{ getIdByPath()

    /**
     *
     *
     */
    function getIdByPath($path, $startId = 0,
                        $nodeName = 'name', $seperator = '/')
    {
        return $this->_raiseError(TREE_ERROR_NOT_IMPLEMENTED,
                    __FUNCTION__, __LINE__);
    }

    // }}}
    // {{{ getDepth()

    /**
     * return the maximum depth of the tree
     *
     * @version    2003/02/25
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @return     int     the depth of the tree
     */
    function getDepth()
    {
        return $this->_treeDepth;
    }

    // }}}

    //
    //  PRIVATE METHODS
    //

    // {{{ _prepareResults()

    /**
     * prepare multiple results
     *
     * @see        _prepareResult()
     * @access     private
     * @version    2002/03/03
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @param      array   the data to prepare
     * @return     array   prepared results
     */
    function &_prepareResults($results)
    {
        $newResults = array();
        foreach ($results as $key => $aResult) {
            $newResults[$key] = $this->_prepareResult($aResult);
        }
        return $newResults;
    }

    // }}}
    // {{{ _prepareResult()

    /**
      * map back the index names to get what is expected
      *
      * @access     private
      * @version    2002/03/03
      * @author     Wolfram Kriesing <wolfram@kriesing.de>
      * @param      array   a result
      * @return     array   the prepared result
      */
    function _prepareResult($result)
    {
        $map = $this->getOption('columnNameMaps');
        if ($map) {
            foreach ($map as $key => $columnName) {
                if (isset($result[$columnName])) {
                    $temp = $result[$columnName];   // remember the value from the old name
                    unset($result[$columnName]);    // remove the old one
                    $result[$key] = $temp;          // save it in the mapped col-name
                }
            }
        }
        return $result;
    }

    // }}}
    // {{{ _getColName()

    /**
     * this method retrieves the real column name, as used in the DB
     * since the internal names are fixed, to be portable between different
     * DB-column namings, we map the internal name to the real column name here
     *
     * @access     private
     * @version    2002/03/02
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @param      string  the internal name used
     * @return     string  the real name of the column
     */
    function _getColName($internalName)
    {
        if ($map = $this->getOption('columnNameMaps')) {
            if (isset($map[$internalName])) {
                return $map[$internalName];
            }
        }
        return $internalName;
    }

    // }}}
    // {{{ _raiseError()

    /**
     *
     *
     * @access     private
     * @version    2002/03/02
     * @author     Pierre-Alain Joye <paj@pearfr.org>
     * @param      string  the error message
     * @param      int     the line in which the error occured
     * @param      mixed   the error mode
     * @return     object  a Tree_Error
     */
    function _raiseError($errorCode, $msg = '', $line = 0)
    {
        include_once 'Tree/Error.php';
        return new Tree_Error(
            $msg, $line, __FILE__, $mode, $this->dbh->last_query);
    }

    // }}}
    // {{{ _throwError()

    /**
     *
     *
     * @access     private
     * @version    2002/03/02
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @param      string  the error message
     * @param      int     the line in which the error occured
     * @param      mixed   the error mode
     * @return     object  a Tree_Error
     */
    function _throwError($msg, $line, $mode = null)
    {
        include_once 'Tree/Error.php';
        if ($mode === null && $this->debug > 0) {
            $mode = PEAR_ERROR_PRINT;
        }
        return new Tree_Error(
            $msg, $line, __FILE__, $mode, $this->dbh->last_query);
    }

    // }}}


    /*******************************************************************************/
    /************************ METHODS FROM Tree_Memory *****************************/
    /*******************************************************************************/

    /**
     * returns if the given element has any children
     *
     * @version 2001/12/17
     * @access  public
     * @author  Wolfram Kriesing <wolfram@kriesing.de>
     * @param   integer $id the id of the node to check for children
     * @return  boolean true if the node has children
     */
    function hasChildren($id = 0)
    {
        if (isset($this->data[$id]['children']) &&
            sizeof($this->data[$id]['children']) > 0) {
            return true;
        }
        return false;
    }





    /*******************************************************************************/
    /************************ METHODS FROM Tree_Options ****************************/
    /*******************************************************************************/



    // {{{ Tree_Options()

    /**
     * this constructor sets the options, since i normally need this and
     * in case the constructor doesnt need to do anymore i already have
     * it done :-)
     *
     * @version    02/01/08
     * @access public
     * @author Wolfram Kriesing <wolfram@kriesing.de>
     * @param  array   the key-value pairs of the options that shall be set
     * @param  boolean if set to true options are also set
     *                 even if no key(s) was/were found in the options property
     */
    function Tree_Options($options=array(), $force=false)
    {
        $this->_forceSetOption = $force;
        if (is_array($options) && sizeof($options)) {
            foreach ($options as $key=>$value) {
                $this->setOption($key, $value);
            }
        }
    }

    // }}}
    // {{{ setOption()

    /**
     *
     * @access public
     * @author Stig S. Baaken
     * @param  string  the option name
     * @param  mixed   the value for this option
     * @param  boolean if set to true options are also set
     *                 even if no key(s) was/were found in the options property
     */
    function setOption($option, $value, $force = false)
    {
        // if the value is an array extract the keys
        // and apply only each value that is set
        if (is_array($value)) {
            // so we dont override existing options inside an array
            // if an option is an array
            foreach ($value as $key=>$aValue) {
                $this->setOption(array($option,$key),$aValue);
            }
            return true;
        }

        if (is_array($option)) {
            $mainOption = $option[0];
            $options = "['".implode("']['",$option)."']";
            $evalCode = "\$this->options".$options." = \$value;";
        } else {
            $evalCode = "\$this->options[\$option] = \$value;";
            $mainOption = $option;
        }

        if ($this->_forceSetOption == true ||
            $force == true || isset($this->options[$mainOption])) {
            eval($evalCode);
            return true;
        }
        return false;
    }

    // }}}
    // {{{ setOptions()

    /**
     * set a number of options which are simply given in an array
     *
     * @access public
     * @param  array   the values to set
     * @param  boolean if set to true options are also set even if no key(s)
     *                 was/were found in the options property
     */
    function setOptions($options, $force = false)
    {
        if (is_array($options) && sizeof($options)) {
            foreach ($options as $key => $value) {
                $this->setOption($key, $value, $force);
            }
        }
    }

    // }}}
    // {{{ getOption()

    /**
     *
     * @access     public
     * @author     copied from PEAR: DB/commmon.php
     * @param      boolean true on success
     */
    function getOption($option)
    {
        if (func_num_args() > 1 &&
            is_array($this->options[$option])) {
            $args = func_get_args();
            $evalCode = "\$ret = \$this->options['".
                        implode("']['", $args) . "'];";
            eval($evalCode);
            return $ret;
        }

        if (isset($this->options[$option])) {
            return $this->options[$option];
        }
        return false;
    }

    // }}}
    // {{{ getOptions()

    /**
     * returns all the options
     *
     * @version    02/05/20
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @return     string      all options as an array
     */
    function getOptions()
    {
        return $this->options;
    }

    // }}}
}

/*
 * Local Variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */