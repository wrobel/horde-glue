--TEST--
PEAR_PackageFileManager_File->_setupIgnore, complex test, multiple patterns
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$y = '\/';
if (DIRECTORY_SEPARATOR == '\\') {
    $y = '\\\\';
}
$packagexml->_setupIgnore(array('frog*', 'frog*/test.php'), 1);
$x = 'frog.*\\' . DIRECTORY_SEPARATOR . 'test\.php';
$phpunit->assertEquals(
    array('frog.*', array($x, 'test\.php')),
    $packagexml->ignore[1], 'incorrect setup');

$packagexml->_setupIgnore(array('frog*', 'frog*\\test.php'), 1);
$phpunit->assertEquals(
    array('frog.*', array($x, 'test\.php')),
    $packagexml->ignore[1], 'incorrect setup');
echo 'tests done';
?>
--EXPECT--
tests done