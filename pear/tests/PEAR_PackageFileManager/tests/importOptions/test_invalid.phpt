--TEST--
PEAR_PackageFileManager->importOptions, invalid test
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['pearcommonclass'] = 'PEAR_Common';
$res = $packagexml->importOptions(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'notthere.xml');
$phpunit->assertErrors(array(
    array('package' => 'PEAR_Error', 'message' =>
    "PEAR_PackageFileManager Error: Package Name (option 'package') must by specified in PEAR_PackageFileManager setOptions to create a new package.xml"
    ),
), 'test');
echo 'tests done';
?>
--EXPECT--
tests done
