--TEST--
PEAR_PackageFileManager_File->_setDir, proof-of-concept
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$test = array('my' => array('butt' => array('first')));
$arr = array('my' => array('other' => array('test')));
$assert = $packagexml->_setDir($arr, $test);
$phpunit->assertEquals(array('my' => array('other' => array('test'), 'butt' => array('first'))),
    $assert,
    'Wrong contents');
echo 'tests done';
?>
--EXPECT--
tests done