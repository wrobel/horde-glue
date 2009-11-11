--TEST--
PEAR_PackageFileManager->setOptions, invalid custom filelist generator
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'Bad_file',
    'usergeneratordir' => dirname(dirname(__FILE__))
    ));
$phpunit->assertErrors(array(
    array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Base class "PEAR_PackageFileManager_Bad_file" can\'t be located in default or user-specified directories'
    )
), 'test');
echo 'tests done';
?>
--EXPECT--
tests done
