--TEST--
PEAR_PackageFileManager->addMaintainer, update existing maintainer
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'File'));
$packagexml->addMaintainer('peeber.php', 'ribbit', 'tadpole', 'frog');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Maintainer role must be one of "' .
    implode(PEAR_Common::getUserRoles(), ', ') .
    '", was "ribbit"')),
    'invalid role test'
);
echo 'tests done';
?>
--EXPECT--
tests done
