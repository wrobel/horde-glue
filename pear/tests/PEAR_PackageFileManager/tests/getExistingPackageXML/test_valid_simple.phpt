--TEST--
PEAR_PackageFileManager->_getExistingPackageXML, valid test
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['pearcommonclass'] = 'PEAR_Common';
$res = $packagexml->_getExistingPackageXML(dirname(dirname(__FILE__)) . '/', 'test1_package.xml');
$phpunit->assertFalse(is_object($res), 'returned error');

$info = dirname(dirname(__FILE__)) . '/test1_package.xml';
$packagefile = &new PEAR_PackageFile(PEAR_Config::singleton());
$pf = &$packagefile->fromAnyFile($info, PEAR_VALIDATE_NORMAL);
$contents = $pf->toArray();

$phpunit->assertEquals($contents['release_deps'], $packagexml->_packageXml['release_deps'], 'wrong deps');
$phpunit->assertEquals($contents['maintainers'], $packagexml->_packageXml['maintainers'], 'wrong maintainers');
$phpunit->assertEquals($packagexml->_packageXml['release_deps'],
    $packagexml->_options['deps'], 'wrong deps');
$phpunit->assertEquals($packagexml->_packageXml['maintainers'],
    $packagexml->_options['maintainers'], 'wrong maintainers');
echo 'tests done';
?>
--EXPECT--
tests done
