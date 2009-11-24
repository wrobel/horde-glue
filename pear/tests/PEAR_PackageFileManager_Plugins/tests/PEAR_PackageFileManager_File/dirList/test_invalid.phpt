--TEST--
PEAR_PackageFileManager_File->dirList, source base directory doesn't exist
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$res = $packagexml->dirList('fargusblurbe[]--#/"');
$phpunit->assertErrors(
    array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager_Plugins Error: Package source base directory ' .
    '"fargusblurbe[]--#/"" doesn\'t exist or isn\'t a directory')
, 'error'
);
$phpunit->assertIsa('PEAR_Error', $res, 'no error');
echo 'tests done';
?>
--EXPECT--
tests done