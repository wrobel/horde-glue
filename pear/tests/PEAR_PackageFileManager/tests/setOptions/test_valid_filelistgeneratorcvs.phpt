--TEST--
PEAR_PackageFileManager->setOptions, valid, cvs filelist generator
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'CVS'));
$phpunit->assertNoErrors('test');
echo 'tests done';
?>
--EXPECT--
tests done
