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
//  $Id: Error.php,v 1.8.2.3 2009/03/12 17:19:52 dufuz Exp $
require_once 'PEAR.php';

/**
 * Errors constants definitions
 */
define('TREE_ERROR_NOT_IMPLEMENTED',    -1);
define('TREE_ERROR_ELEMENT_NOT_FOUND',  -2);
define('TREE_ERROR_INVALID_NODE_NAME',  -3);
define('TREE_ERROR_MOVE_TO_CHILDREN',   -4);
define('TREE_ERROR_PARENT_ID_MISSED',   -5);
define('TREE_ERROR_INVALID_PARENT',     -6);
define('TREE_ERROR_EMPTY_PATH',         -7);
define('TREE_ERROR_INVALID_PATH',       -8);
define('TREE_ERROR_DB_ERROR',           -9);
define('TREE_ERROR_PATH_SEPARATOR_EMPTY',-10);
define('TREE_ERROR_CANNOT_CREATE_FOLDER',-11);
define('TREE_ERROR_UNKNOW_ERROR',       -99);

/**
 *
 *
 *   @author     Wolfram Kriesing <wolfram@kriesing.de>
 *   @package    Tree
 */
class Tree_Error extends PEAR_Error
{
    /**
     * @var  string    prefix for error messages.
     */
    var $error_message_prefix = "Tree Error: ";

    // {{{ Tree_Error()

    /**
     * @access     public
     * @version    2002/03/03
     * @author     Wolfram Kriesing <wolfram@kriesing.de>
     */
    function Tree_Error($msg, $line, $file,
                        $mode = null, $userinfo = 'no userinfo')
    {
        $this->PEAR_Error(sprintf("%s <br/>in %s [%d].", $msg, $file, $line),
                          null , $mode , null, $userinfo );
    }

    // }}}
    // {{{ getMessage()

    function getMessage($id)
    {
        $messages = array(
            TREE_ERROR_NOT_IMPLEMENTED    => '',
            TREE_ERROR_INVALID_PATH       => '',
            TREE_ERROR_DB_ERROR           => '',
            TREE_ERROR_PARENT_ID_MISSED   => '',
            TREE_ERROR_MOVE_TO_CHILDREN   => '',
            TREE_ERROR_ELEMENT_NOT_FOUND  => '',
            TREE_ERROR_PATH_SEPARATOR_EMPTY => '',
            TREE_ERROR_INVALID_NODE_NAME  => '',
            TREE_ERROR_UNKNOW_ERROR       => ''
            );
        return isset($messages[$id])?$messages[$id]:
                    $messages[TREE_ERROR_UNKNOW_ERROR];
    }

    // }}}
}