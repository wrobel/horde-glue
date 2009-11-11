--TEST--
PEAR_PackageFileManager->addDependency, invalid, php dep as pkg
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'File'));
$packagexml->addDependency('php', '4.3.0');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: addDependency had PHP as a package, use type="php"')),
    'invalid php as pkg test'
);
echo 'tests done';
?>
--EXPECT--
tests done
