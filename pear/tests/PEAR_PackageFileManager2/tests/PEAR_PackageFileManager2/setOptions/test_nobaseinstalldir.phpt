--TEST--
PEAR_PackageFileManager2->setOptions, no baseinstalldir option
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$a = $packagexml->setOptions(array('packagedirectory' => '.'));
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager2 Error: Package install base directory (option \'baseinstalldir\') must be specified in PEAR_PackageFileManager2 setOptions')),
    'no setOptions() test'
);
$phpunit->assertIsa('PEAR_Error', $a, 'return');
echo 'tests done';
?>
--EXPECT--
tests done
