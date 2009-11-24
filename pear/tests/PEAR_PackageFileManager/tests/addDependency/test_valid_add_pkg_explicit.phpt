--TEST--
PEAR_PackageFileManager->addDependency, valid, add pkg dep, implicit
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'File'));
$packagexml->_packageXml['release_deps'] = array();
$packagexml->addDependency('frog', '4.3.0', 'has', 'pkg', true);
$phpunit->assertEquals(
    array('name' => 'frog', 'type' => 'pkg',
          'rel' => 'has', 'optional' => 'yes'),
    $packagexml->_packageXml['release_deps'][0],
    'release_deps value wrong');
echo 'tests done';
?>
--EXPECT--
tests done
