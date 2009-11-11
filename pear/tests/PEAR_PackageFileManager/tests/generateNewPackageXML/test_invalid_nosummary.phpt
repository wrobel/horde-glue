--TEST--
PEAR_PackageFileManager->_generateNewPackageXML, invalid test, no summary
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['package'] = 'test';
$packagexml->_generateNewPackageXML();
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Package Summary (option ' .
    '\'summary\') must by specified in PEAR_PackageFileManager '.
    'setOptions to create a new package.xml')), 'invalid nosummary');
echo 'tests done';
?>
--EXPECT--
tests done