--TEST--
PEAR_PackageFileManager2->setOptions, existing package.xml, unknown channel
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$a = $packagexml->setOptions(array('packagedirectory' => dirname(__FILE__) .
    DIRECTORY_SEPARATOR . 'existingpackagexml', 'packagefile' => 'package_nochangelog.xml',
    'baseinstalldir' => '/'));
$phpunit->assertErrors(
array(
    array('package' => 'PEAR_Error', 'message' => 'Unknown channel: pear.chiaraquartet.net'),
    array('package' => 'PEAR_PackageFile_v2', 'message' => 'Unknown channel "pear.chiaraquartet.net"'),
    array('package' => 'PEAR_Error', 'message' => 'PEAR_PackageFileManager2 Error: Package validation failed:
Error: Unknown channel "pear.chiaraquartet.net"'),
)
,'existing packagexml');
$phpunit->assertIsa('PEAR_Error', $a, 'return');
echo 'tests done';
?>
--EXPECT--
tests done
