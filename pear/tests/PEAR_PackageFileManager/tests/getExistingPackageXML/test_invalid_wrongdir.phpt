--TEST--
PEAR_PackageFileManager->_getExistingPackageXML, invalid test, wrong output directory
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_getExistingPackageXML(array(), 'package.xml');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: package.xml file path "array" ' .
    'doesn\'t exist or isn\'t a directory')), 'invalid nopackage');
echo 'tests done';
?>
--EXPECT--
tests done
