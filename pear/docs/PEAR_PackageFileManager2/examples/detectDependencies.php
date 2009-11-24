<?php
/**
 * This example (based on HTML_AJAX 0.5.0) show how to :
 * - convert a package.xml 1.0 to package.xml 2.0
 * - detect dependencies PHP versions and extensions
 *   using PHP_CompatInfo( >= 1.4.0 ) if available
 *
 * Notice that this script required at least minimum data to set
 * (version and release notes)
 * due to usage of PEAR_PackageFileManager2::importOptions().
 *
 * @version    $Id: detectDependencies.php,v 1.3 2006/10/21 09:04:52 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    PEAR_PackageFileManager
 * @ignore
 */
require_once 'PEAR/PackageFileManager2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$version = '0.5.1';
$notes = <<<EOT
    Map PEAR_Error objects so they can be caught on the JavaScript side
EOT;

$optionsUpdate = array(
    'baseinstalldir' => 'HTML',
    'filelistgenerator' => 'file',
    'ignore'            => array(
        'package.php',  //  'package.xml' is auto-exclude since PFM 1.6.0b4
        '*.bak', '*src*', '*.tgz',
        'test.bat', 'build.php', 'DeveloperNotes.txt', '*cssQuery-src*'
        ),
    'simpleoutput' => true,
    'cleardependencies' => false,
    'clearcontents' => false,
    'changelogoldtonew' => false,
    'packagefile' => 'htmlajax.xml'
);

$packagedirectory = 'c:/pear/HTML/HTML_AJAX-0.5.0';
$packagefile  = $packagedirectory . DIRECTORY_SEPARATOR . 'package.xml';

// if you are NOT sure to have a package xml 2.0 in your directory,
// and want to convert from package xml 1.0 first
$package = &PEAR_PackageFileManager2::importFromPackageFile1($packagefile, $optionsUpdate);

// if you are sure to have a package xml 2.0 in your directory
// use instead:  $package = PEAR_PackageFileManager2::importOptions($packagefile, $optionsUpdate);

$package->setReleaseVersion($version);
$package->setNotes($notes);

// to improve detection accuracy of PHP_CompatInfo, because i know my package :-)
$options = array(
    'ignore_functions' => array(
        'set_exception_handler', 'restore_exception_handler',
        'file_get_contents', 'stream_context_create'
        ),
    'ignore_files' => array(
        $packagedirectory . '/examples/support/xml.class.php'
        )
  );

PEAR::pushErrorHandling(PEAR_ERROR_RETURN);
$available = $package->detectDependencies($options);
if (PEAR::isError($available)) {
    // PHP_CompatInfo is not installed on your system, then fix PHP dep with PFM2
    $package->setPhpDep('4.1.0');
}
PEAR::popErrorHandling();

$package->setPearInstallerDep('1.4.3');
// any additional customization depending of your new release
// for example: $package->addPackageDepWithChannel('required', 'PEAR', 'pear.php.net', '1.4.11');

$package->generateContents();

if (isset($_GET['commit']) || isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'commit') {
   $package->writePackageFile();
} else {
   $package->debugPackageFile();
}
?>