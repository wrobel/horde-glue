<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The PHP Group                                     |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Bertrand Mansion <bmansion@mamasam.com>                      |
// +----------------------------------------------------------------------+
//
// $Id: test.php,v 1.3 2005/05/17 08:47:52 wenz Exp $

/**
 * Unit tests for Console_Getargs package.
 */

require_once 'Console/Getargs.php';
require_once 'PHPUnit.php';
require_once './Console_TestListener.php';

$testFiles = array(
    'Getargs_basic_testcase.php' => 'Getargs_Basic_testCase',
    'Getargs_getValues_testcase.php' => 'Getargs_getValues_testCase'
);

$suite =& new PHPUnit_TestSuite();
foreach ($testFiles as $file => $testsuite) {
    require_once $file;
    $tmp = new PHPUnit_TestSuite($testsuite);
    $suite->addTest($tmp);
}

$result =& new PHPUnit_TestResult();
$result->addListener(new Console_TestListener);

$suite->run($result);
?>