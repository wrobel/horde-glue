--TEST--
PEAR_PackageFileManager2->setOptions, non-existent packagedirectory option
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$a = $packagexml->setOptions(array('packagedirectory' =>
    dirname(__FILE__) . DIRECTORY_SEPARATOR . 'notexistingdir', 'baseinstalldir' => '.'));
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager2 Error: Package source base directory (option \'packagedirectory\') must be an existing directory (was "' . dirname(__FILE__) . DIRECTORY_SEPARATOR . 'notexistingdir")')),
    'no setOptions() test'
);
$phpunit->assertIsa('PEAR_Error', $a, 'return');
echo 'tests done';
?>
--EXPECT--
tests done
