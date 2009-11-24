--TEST--
PEAR_PackageFileManager_File->dirList, request #10945 test
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['packagedirectory'] = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'test_request10945/';
$packagexml->_options['addhiddenfiles'] = false;
$ignore = array(
    'CVS/', 'upload/file.php',
);

$packagexml->_setupIgnore(false, 0);
$packagexml->_setupIgnore($ignore, 1);
$res = $packagexml->dirList(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'test_request10945');
$phpunit->assertEquals(
    array(
        dirname(__FILE__) . DIRECTORY_SEPARATOR . 'test_request10945/dir/file.php',
    ),
    $res,
    'incorrect dir structure');
echo 'tests done';
?>
--EXPECT--
tests done