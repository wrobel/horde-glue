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
$packagexml->_packageXml['maintainers'] = array();
$packagexml->addMaintainer('frog', 'lead', 'tadpole meister', 'frog@example.com');
$phpunit->assertEquals(
    array('handle' => 'frog', 'role' => 'lead',
             'name' => 'tadpole meister', 'email' => 'frog@example.com'),
    $packagexml->_packageXml['maintainers'][0],
    'maintainers value wrong');
$packagexml->addMaintainer('frog', 'developer', 'tadpole freak', 'frog@example.com');
$phpunit->assertEquals(
    array(array('handle' => 'frog', 'role' => 'developer',
             'name' => 'tadpole freak', 'email' => 'frog@example.com')),
    $packagexml->_packageXml['maintainers'],
    'maintainers value wrong');
echo 'tests done';
?>
--EXPECT--
tests done
