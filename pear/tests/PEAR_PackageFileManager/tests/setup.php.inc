<?php
error_reporting(E_ALL);
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'phpt_test.php.inc';
require_once 'PEAR/PackageFileManager.php';
$packagexml = new PEAR_PackageFileManager;
$phpunit    = new PEAR_PHPTest(true);