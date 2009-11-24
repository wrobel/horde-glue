--TEST--
PEAR_PackageFileManager_Cvs->dirList, valid test
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['addhiddenfiles'] = false;
$packagexml->_options['ignore'] = $packagexml->_options['include'] = false;
$packagexml->_options['packagefile'] = 'package.xml';


$res = $packagexml->dirList(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp');
$phpunit->assertNoErrors('after dirlist');
$phpunit->assertEquals(
    array(
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/test1.txt',
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/test2.txt',
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/.test',
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
