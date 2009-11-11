--TEST--
PEAR_PackageFileManager->_getExistingPackageXML, invalid test, doesn't exist, package name not specified
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_getExistingPackageXML(dirname(__FILE__), 'blah.xml');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Package Name (option \'package\') ' .
    'must by specified in PEAR_PackageFileManager '.
    'setOptions to create a new package.xml')), 'invalid nopackage');
echo 'tests done';
?>
--EXPECT--
tests done
