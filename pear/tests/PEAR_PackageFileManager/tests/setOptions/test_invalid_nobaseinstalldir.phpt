--TEST--
PEAR_PackageFileManager->setOptions, invalid, no baseinstalldir
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__))));
$phpunit->assertErrors(array(
    array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Package install base directory (option \'baseinstalldir\') must be ' .
    'specified in PEAR_PackageFileManager setOptions'
    )
), 'test');
echo 'tests done';
?>
--EXPECT--
tests done
