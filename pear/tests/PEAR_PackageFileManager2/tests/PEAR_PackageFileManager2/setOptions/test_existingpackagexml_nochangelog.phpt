--TEST--
PEAR_PackageFileManager2->setOptions, existing package.xml, no changelog
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$reg = &$config->getRegistry();
require_once 'PEAR/ChannelFile.php';
$chan = new PEAR_ChannelFile;
$chan->setSummary('blah');
$chan->setName('pear.chiaraquartet.net');
$reg->addChannel($chan);
$a = $packagexml->setOptions(array('packagedirectory' => dirname(__FILE__) .
    DIRECTORY_SEPARATOR . 'existingpackagexml', 'packagefile' => 'package_nochangelog.xml',
    'baseinstalldir' => '/'));
$phpunit->assertNoErrors('existing packagexml');
$phpunit->assertNull($a, 'return');
$phpunit->assertIsa('PEAR_PackageFileManager2', $packagexml->_oldPackageFile, 'old packagefile');
$phpunit->assertFalse($packagexml->_oldPackageFile->getChangelog(), 'changelog');
echo 'tests done';
?>
--EXPECT--
tests done
