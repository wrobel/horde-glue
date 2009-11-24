--TEST--
PEAR_PackageFileManager->addConfigureOption, add test 1
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'File'));
$packagexml->addConfigureOption('frog', 'Sound a frog makes', 'ribbit');
$phpunit->assertEquals(
    array('name' => 'frog', 'prompt' => 'Sound a frog makes', 'default' => 'ribbit'),
    $packagexml->_packageXml['configure_options'][0],
    'configure_options value wrong');
echo 'tests done';
?>
--EXPECT--
tests done
