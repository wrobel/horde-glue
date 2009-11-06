<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// i think this class should go somewhere in a common PEAR-place,
// because a lot of classes use options, at least PEAR::DB does
// but since it is not very fancy to crowd the PEAR-namespace
// too much i dont know where to put it yet :-(

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
//  $Id: OptionsMDB2.php,v 1.1.2.4 2009/03/12 17:19:52 dufuz Exp $

require_once 'Tree/Common.php';

/**
*   this class additionally retreives a DB connection and saves it
*   in the property "dbh"
*
*   @package  Tree
*   @access   public
*   @author   Wolfram Kriesing <wolfram@kriesing.de>
*
*/
class Tree_OptionsMDB2 extends Tree_Common
{
    /**
     *   @var    object
     */
    var $dbh;

    // {{{ Tree_OptionsMDB2()

    /**
     *   this constructor sets the options, since i normally need this and
     *   in case the constructor doesnt need to do anymore i already have
     * it done :-)
     *
     *   @version    02/01/08
     *   @access     public
     *   @author     Wolfram Kriesing <wolfram@kriesing.de>
     *   @param      boolean true if loggedIn
     */
    function Tree_OptionsMDB2($dsn, $options = array())
    {
        $res = $this->_connectDB($dsn);
        if (PEAR::isError($res)) {
            return $res;
        }

        $this->dbh->setFetchmode(MDB2_FETCHMODE_ASSOC);
        // do options afterwards since it overrules
        $this->Tree_Options($options);
    }

    // }}}
    // {{{ _connectDB()

    /**
     * Connect to database by using the given DSN string
     *
     * @author  copied from PEAR::Auth, Martin Jansen, slightly modified
     * @access private
     * @param  string DSN string
     * @return mixed  Object on error, otherwise bool
     */
    function _connectDB($dsn)
    {
        // only include the db if one really wants to connect
        require_once 'MDB2.php';

        if (is_string($dsn) || is_array($dsn)) {
            $this->dbh = MDB2::Connect($dsn);
        } else {
            if (MDB2::isConnection($dsn)) {
                $this->dbh = $dsn;
            } else {
                if (is_object($dsn) && MDB2::isError($dsn)) {
                    return new MDB2_Error($dsn->code, PEAR_ERROR_DIE);
                }

                return new PEAR_Error(
                                'The given dsn was not valid in file '.
                                __FILE__ . ' at line ' . __LINE__,
                                41,
                                PEAR_ERROR_RETURN,
                                null,
                                null
                                );

            }
        }

        if (MDB2::isError($this->dbh)) {
            return new MDB2_Error($this->dbh->code, PEAR_ERROR_DIE);
        }

        return true;
    }

    // }}}
}