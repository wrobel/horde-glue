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
    DIRECTORY_SEPARATOR . 'existingpackagexml', 'packagefile' => 'package_changelog.xml',
    'baseinstalldir' => '/'));
$phpunit->assertNoErrors('existing packagexml');
$phpunit->assertNull($a, 'return');
$phpunit->assertIsa('PEAR_PackageFileManager2', $packagexml->_oldPackageFile, 'old packagefile');
$phpunit->assertEquals(array (
  'release' =>
  array (
    0 =>
    array (
      'version' =>
      array (
        'release' => '0.1.0',
        'api' => '0.1.0',
      ),
      'stability' =>
      array (
        'release' => 'alpha',
        'api' => 'beta',
      ),
      'date' => '2005-10-31',
      'license' => 'BSD license',
      'notes' => 'initial release',
    ),
    1 =>
    array (
      'version' =>
      array (
        'release' => '0.2.0',
        'api' => '0.1.0',
      ),
      'stability' =>
      array (
        'release' => 'alpha',
        'api' => 'beta',
      ),
      'date' => '2005-11-02',
      'license' => 'BSD license',
      'notes' => 'implement new custom role format for PEAR 1.4.3',
    ),
  ),
), $packagexml->_oldPackageFile->getChangelog(), 'changelog');
echo 'tests done';
?>
--EXPECT--
tests done
