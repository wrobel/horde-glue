--TEST--
PEAR_PackageFileManager_File->getRegExpableSearchString, test of special characters
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';

$y = '\/';
if (DIRECTORY_SEPARATOR == '\\') {
    $y = '\\\\';
}

$res1 = $packagexml->_getRegExpableSearchString('frog?.a*\\/[]-');
if (DIRECTORY_SEPARATOR == '\\') {
    $str = "frog.\.a.*\\\\\\\\\\[\\]\\-";
} else {
    $str = "frog.\.a.*\\\\\\/\[\\]\\-";
}

$phpunit->assertEquals($str, $res1, 'wrong regexp 1');

$res = $packagexml->_getRegExpableSearchString('frog?.a*\\/[]-' . DIRECTORY_SEPARATOR);

$res1 .= $y;
$phpunit->assertEquals("(?:.*$y$res1?.*|$res1.*)", $res, 'wrong regexp 2');
echo 'tests done';
?>
--EXPECT--
tests done