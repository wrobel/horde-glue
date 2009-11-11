--TEST--
PEAR_PackageFileManager->setOptions, invalid, no state
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('version' => '1.0'));
$phpunit->assertErrors(array(
    array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Release State (option \'state\') ' .
    'must by specified in PEAR_PackageFileManager setOptions (snapshot|devel|' .
    'alpha|beta|stable)'
    )
), 'test');
echo 'tests done';
?>
--EXPECT--
tests done