--TEST--
PEAR_PackageFileManager_Cvs->dirList, valid test with include
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['addhiddenfiles'] = false;
$packagexml->_options['include'] = array('*1*');
$packagexml->_options['ignore'] = false;
$packagexml->_options['packagefile'] = 'package.xml';

$res = $packagexml->dirList(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp');
$phpunit->assertEquals(
    array(
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/test1.txt',
    ),
    $res,
    'incorrect dir structure');

echo 'tests done';
?>
--CLEAN--
<?php
require_once dirname(__FILE__) . '/teardown.php.inc';
?>
--EXPECT--
tests done