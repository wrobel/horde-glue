--TEST--
PEAR_PackageFileManager_Cvs->dirList, invalid test
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';

$packagexml->_options['ignore'] = array();
$packagexml->_options['include'] = false;
$packagexml->_options['packagefile'] = 'package.xml';

$res = $packagexml->dirList('fargusblurbe[]--#/"');

$phpunit->assertErrors(array(
    array('package' => 'PEAR_Error',
    'message' => 'PEAR_PackageFileManager_Plugins Error: Directory "fargusblurbe[]--#/"" is ' .
    'not a CVS directory (it must have the CVS/Entries file)'),
    array('package' => 'PEAR_Error',
    'message' => 'PEAR_PackageFileManager_Plugins Error: Package source base directory ' .
    '"fargusblurbe[]--#/"" doesn\'t exist or isn\'t a directory'),
), 'no cvs entries');
$phpunit->assertIsa('PEAR_Error', $res, 'no error');

echo 'tests done';
?>
--CLEAN--
<?php
require_once dirname(dirname(__FILE__)) . '/teardown.php.inc';
?>
--EXPECT--
tests done