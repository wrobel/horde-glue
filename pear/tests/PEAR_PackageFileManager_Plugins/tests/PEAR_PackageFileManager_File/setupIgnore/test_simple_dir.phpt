--TEST--
PEAR_PackageFileManager_File->_setupIgnore, simple test
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$y = '\/';
if (DIRECTORY_SEPARATOR == '\\') {
    $y = '\\\\';
}

$packagexml->_setupIgnore(array('frog*/'), 1);
$x = 'frog.*\\' . DIRECTORY_SEPARATOR;
$phpunit->assertEquals(array("(?:.*$y$x?.*|$x.*)"),  $packagexml->ignore[1], 'incorrect setup');

$packagexml->_setupIgnore(array('frog*\\'), 1);
$x = 'frog.*\\' . DIRECTORY_SEPARATOR;
$phpunit->assertEquals(array("(?:.*$y$x?.*|$x.*)"), $packagexml->ignore[1], 'incorrect setup');
echo 'tests done';
?>
--EXPECT--
tests done