--TEST--
PEAR_PackageFileManager_File->_setupIgnore, non-array
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_setupIgnore(false, 1);
$phpunit->assertFalse($packagexml->ignore[1], 'should be false if not an array');
echo 'tests done';
?>
--EXPECT--
tests done