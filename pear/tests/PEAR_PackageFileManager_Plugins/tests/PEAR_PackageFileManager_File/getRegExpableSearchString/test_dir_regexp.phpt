--TEST--
PEAR_PackageFileManager_File->getRegExpableSearchString, directory pattern
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$res = $packagexml->_getRegExpableSearchString('frog/');
$y = '\/';
if (DIRECTORY_SEPARATOR == '\\') {
    $y = '\\\\';
}
$phpunit->assertEquals('(?:.*' . $y . 'frog\\' . DIRECTORY_SEPARATOR .
    '?.*|frog\\' . DIRECTORY_SEPARATOR . '.*)', $res, 'wrong regexp');
$phpunit->assertNotFalse(preg_match("/^$res$/", 'frog' . DIRECTORY_SEPARATOR .
    '1-hairy.php'), 'did not match frog//1-hairy.php');
$phpunit->assertNotTrue(preg_match("/^$res$/", 'frog1-hairy' . DIRECTORY_SEPARATOR .
    'thingo.php'), 'matched frog1-hairy//thingo.php');
$phpunit->assertNotFalse(preg_match("/^$res$/", 'my' . DIRECTORY_SEPARATOR .
    'frog' . DIRECTORY_SEPARATOR . 'thingo.php'), 'did not match my\\frog\\thingo.php');
echo 'tests done';
?>
--EXPECT--
tests done