--TEST--
PEAR_PackageFileManager_File->getRegExpableSearchString, file pattern
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$res = $packagexml->_getRegExpableSearchString('frog?-*.php');
$phpunit->assertEquals('frog.\-.*\.php', $res, 'wrong regexp');
$phpunit->assertNotFalse(preg_match("/^$res$/", 'frog1-hairy.php'), 'did not match frog1-hairy.php');
$phpunit->assertNotFalse(preg_match("/^$res$/", 'frog1-hairy/thingo.php'), 'did not match frog1-hairy/thingo.php');
$phpunit->assertNotFalse(preg_match("/^$res$/", 'frog1-hairy\\thingo.php'), 'did not match frog1-hairy\\thingo.php');
$phpunit->assertNotTrue(preg_match("/^$res$/", 'frog11-hairy.php'), 'matched frog11-hairy.php');
echo 'tests done';
?>
--EXPECT--
tests done