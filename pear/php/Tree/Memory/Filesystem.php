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
//  $Id: Filesystem.php,v 1.9.2.2 2009/03/12 17:19:48 dufuz Exp $

require_once 'Tree/Error.php';

/**
 * the Filesystem interface to the tree class
 * this is a bit different, as id we use the entire path, since we know
 * this is unique in a filesystem and an integer id could only be created
 * virtually, it doesnt have a tight connection to the actual directory
 * i.e. using 'add' with ids could fail since we dont know if we get the same
 * id when we call 'add' with a parentId to create a new folder under since
 * our id would be made up. So we use the complete path as id, which takes up
 * a lot of memory, i know but since php is typeless its possible and it makes
 * life easier when we want to create another dir, since we get the dir
 * as parentId passed to the 'add' method, which makes it easy to create
 * a new dir there :-)
 * I also thought about hashing the path name but then the add method is
 * not that easy to implement ... may be one day :-)
 *
 * @access     public
 * @author     Wolfram Kriesing <wolfram@kriesing.de>
 * @version    2001/06/27
 * @package    Tree
 */
 class Tree_Memory_Filesystem
 {

    /**
     * @access public
     * @var    array   saves the options passed to the constructor
     */
    var $options =  array(
                        'order'     => '',
                        'columnNameMaps' => array(),
                    );

    // {{{ Tree_Memory_Filesystem()

    /**
     * set up this object
     *
     * @version    2002/08/23
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @param      string  $dsn    the path on the filesystem
     * @param      array   $options  additional options you can set
     */
    function Tree_Memory_Filesystem ($path, $options = array())
    {
        $this->_path = $path;
        // not in use currently
        $this->_options = $options;
    }

    // }}}
    // {{{ setup()

    /**
     * retreive all the navigation data from the db and call build to build
     * the tree in the array data and structure
     *
     * @version    2001/11/20
     * @access     public
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     * @return     boolean     true on success
     */
    function setup()
    {
        // unset the data to be sure to get the real data again, no old data
        unset($this->data);
        if (is_dir($this->_path)) {
            $this->data[$this->_path] = array(
                                          'id'       => $this->_path,
                                          'name'     => $this->_path,
                                          'parentId' => 0
                                        );
            $this->_setup($this->_path, $this->_path);
        }
        return $this->data;
    }

    // }}}
    // {{{ _setup()

    function _setup($path, $parentId = 0)
    {
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..'
                    && is_dir("$path/$file")) {
                    $this->data[] = array(
                                        'id'       => "$path/$file",
                                        'name'     => $file,
                                        'parentId' => $parentId
                                    );
                    $this->_setup("$path/$file", "$path/$file");
                }
            }
            closedir($handle);
        }
    }

    // }}}
    // {{{ add()

    /**
     * this is tricky on a filesystem, since we are working with id's
     * as identifiers and we need to be sure, the parentId to create
     * a node under is the same as when the tree was last read.
     * but this might be tricky.
     */
    function add($newValues, $parent = 0, $prevId = 0)
    {
        if (!$parent) {
            $parent = $this->path;
        }
        # FIXXME do the mapping
        if (!@mkdir("$parent/{$newValues['name']}", 0700)) {
            return $this->_raiseError(TREE_ERROR_CANNOT_CREATE_FOLDER,
                                      $newValues['name'].' under '.$parent,
                                      __LINE__
                                     );
        }
        return "$parent/{$newValues['name']}";
    }

    // }}}
    // {{{ remove()

    function remove($id)
    {
        if (!@rmdir($id)) {
            return $this->_throwError('couldnt remove dir '.$id, __LINE__);
        }
        return true;
    }

    // }}}
    // {{{ copy()

    function copy($srcId, $destId)
    {
        # if(!@copy($srcId, $destId)) this would only be for files :-)
        # FIXXME loop through the directory to copy the children too !!!
        $dest = $destId.'/'.preg_replace('/^.*\//','',$srcId);
        if (is_dir($dest)) {
            return $this->_throwError(
                    "couldnt copy, $destId already exists in $srcId ", __LINE__
                );
        }
        if (!@mkdir($dest, 0700)) {
            return $this->_throwError(
                    "couldnt copy dir from $srcId to $destId ", __LINE__
                );
        }
        return true;
    }

    // }}}
    // {{{ _prepareResults()

    /**
     * prepare multiple results
     *
     * @see        _prepareResult()
     * @access     private
     * @version    2002/03/03
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function _prepareResults($results)
    {
        $newResults = array();
        foreach ($results as $aResult) {
            $newResults[] = $this->_prepareResult($aResult);
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
     */
    function _prepareResult($result)
    {
        $map = $this->getOption('columnNameMaps');
        if ($map) {
            foreach ($map as $key => $columnName) {
                $result[$key] = $result[$columnName];
                unset($result[$columnName]);
            }
        }
        return $result;
    }

    // }}}
}