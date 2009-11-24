--TEST--
PEAR_PackageFileManager_File->checkIgnore, empty array
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_setupIgnore(array(), 1);
$res = $packagexml->_checkIgnore(basename('anything\\goes'),
    'anything\\goes', 1);
$phpunit->assertFalse($res, 'wrongo');
echo 'tests done';
?>
--EXPECT--
tests done