--TEST--
PEAR_PackageFileManager->addReplacement, valid
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'File'));
$phpunit->assertNoErrors('setup');
$packagexml->addReplacement('peeber.php', 'package-info', '@version@', 'version');
$phpunit->assertEquals(array(array('type' => 'package-info', 'from' => '@version@', 'to' => 'version')),
    $packagexml->_options['replacements']['peeber.php'],
    'extension was not set, should be');
echo 'tests done';
?>
--EXPECT--
tests done
