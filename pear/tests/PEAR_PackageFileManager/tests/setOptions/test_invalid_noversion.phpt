--TEST--
PEAR_PackageFileManager->setOptions, invalid, no version
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha'));
$phpunit->assertErrors(array(
    array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Release Version (option \'version\') ' .
    'must be specified in PEAR_PackageFileManager setOptions'
    )
), 'test');
echo 'tests done';
?>
--EXPECT--
tests done
