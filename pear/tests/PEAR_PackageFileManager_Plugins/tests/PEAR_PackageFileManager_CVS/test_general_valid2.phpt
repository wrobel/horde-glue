--TEST--
PEAR_PackageFileManager_Cvs, valid test 1
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['addhiddenfiles'] = false;
$packagexml->_options['ignore'] =
$packagexml->_options['include'] = false;
$packagexml->_options['packagefile'] = 'package.xml';


$z = fopen($file . 'CVS' . DIRECTORY_SEPARATOR . 'Entries', 'a');
fwrite($z, "\n/unused/1.16/dummy timestamp//");
fclose($z);

touch($file . 'CVS' . DIRECTORY_SEPARATOR . 'unused');

$res = $packagexml->dirList(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp');
$phpunit->assertEquals(
    array(
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/test1.txt',
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/test2.txt',
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp/.test',
    ),
    $res,
    'incorrect dir structure');

unlink($file . 'CVS' . DIRECTORY_SEPARATOR . 'unused');

echo 'tests done';
?>
--CLEAN--
<?php
require_once dirname(__FILE__) . '/teardown.php.inc';
?>
--EXPECT--
tests done