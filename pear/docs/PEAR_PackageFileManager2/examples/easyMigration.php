<?php
/**
 * This example (based on MDB2 2.2.2) show how to :
 * - convert a package.xml 1.0 to package.xml 2.0
 * - detect dependencies PHP versions and extensions
 *   using PHP_CompatInfo( >= 1.4.0 ) if available
 * - update your package.xml 2.0 and add new release (with all related stuff)
 *
 * @version    $Id: easyMigration.php,v 1.1 2006/10/22 16:46:21 farell Exp $
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @package    PEAR_PackageFileManager
 * @ignore
 */
require_once 'PEAR/PackageFileManager2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

// tell me what you want to do here :
$do_migrate_package_xml_1_to_2 = true;
$do_update_package_xml_2       = true;
$do_autodetect_dependencies    = false;
$do_change_phpdep_version      = true;
$do_change_peardep_version     = true; // recommanded to upgrade to 1.4.3 due to security hole
$do_update_dependencies_list   = true;
$do_overwrite_package_xml      = false;

// your package source directory
$packagedirectory = 'C:\PEAR\Database\MDB2-2.2.2';
// your package file (xml 1.0 or 2.0)
$packagefile  = $packagedirectory . DIRECTORY_SEPARATOR . 'package.xml';
// base installation directory of your package ('/', 'PEAR', 'HTML', ...)
$baseinstalldir = '/';
// file list plugin generator (cvs, svn, file, perforce)
$filelistgenerator = 'file';
// xml generated will be human readable or not
$simpleoutput = true;
// Set to true if ChangeLog should list from oldest entry to newest, false if you would like new entries first
$changelogoldtonew = false;
// directory target for new version of package xml 2.0
$outputdirectory  = $packagedirectory;
// file name of new copy of package xml 2.0, if you don't want to overwrite previous one
$newpackagefile  = 'mdb2.xml';
// Dependencies - PHP version (in case you do not use PHP_CompatInfo auto detect feature)
$phpVersion = array('min' => '4.3.2', 'max' => false);
// Pear Installer version
$pearInstaller = array('min' => '1.4.3', 'max' => false);
// Dependencies - Packages
$packages = array(
    'PEAR' => array(
        'type' => 'required',  // could be also 'optional'
        'channel' => 'pear.php.net',
        'min' => '1.3.6',
        'max' => false,
        'recommanded' => '1.4.3'
        ),
);
// data for new version, if you want to update package xml 2.0
$releasever = '2.2.3';
$releasesta = 'stable';
$apiver     = '2.2.0';
$apista     = 'stable';
$notes = <<<EOT
- release notes for my new version of package MDB2
EOT;
// to improve detection accuracy of PHP_CompatInfo, because i know my package :-)
$optionsPCI = array();


// DO NOT TOUCH ANYTHING ELSE AFTER THIS LINE ----------------------------------
if ($do_overwrite_package_xml === true) {
    $packagefile = 'package.xml';
    $outputdirectory = false;
}

$optionsUpdate = array(
    'baseinstalldir' => $baseinstalldir,
    'filelistgenerator' => $filelistgenerator,
    'simpleoutput' => $simpleoutput,
    'cleardependencies' => $do_update_dependencies_list,
    'clearcontents' => false,
    'changelogoldtonew' => $changelogoldtonew,
    'packagefile' => $newpackagefile,
    'outputdirectory' => $outputdirectory
);

if ($do_migrate_package_xml_1_to_2 === true) {
    // import all data/options of your package xml 1.0
    $package = &PEAR_PackageFileManager2::importFromPackageFile1($packagefile, $optionsUpdate);
} else {
    $package = &PEAR_PackageFileManager2::importOptions($packagefile, $optionsUpdate);
}


if ($do_update_package_xml_2 === false && $do_migrate_package_xml_1_to_2 === false) {
    // in case you only want to apply a package xml 1.0 to 2.0 convert process
    die('DO NOTHING');
}

// After this line, we will apply changes on your fresh package xml 2.0 version

if ($do_update_package_xml_2 === true) {

    $package->addRelease();
    $package->setReleaseVersion($releasever);
    $package->setAPIVersion($apiver);
    $package->setReleaseStability($releasesta);
    $package->setAPIStability($apista);
    $package->setNotes($notes);

    // Try to detect PHP version and PHP extension required
    if ($do_autodetect_dependencies === true) {
        PEAR::pushErrorHandling(PEAR_ERROR_RETURN);
        $available = $package->detectDependencies($optionsPCI);
        if (PEAR::isError($available)) {
            if ($do_change_phpdep_version === true) {
                // PHP_CompatInfo is not installed on your system, then fix PHP dep with PFM2
                $package->setPhpDep($phpVersion['min'], $phpVersion['max']);
            }
        }
        PEAR::popErrorHandling();
    } else {
        if ($do_change_phpdep_version === true) {
            $package->setPhpDep($phpVersion['min'], $phpVersion['max']);
        }
    }

    if ($do_change_peardep_version === true) {
        $package->setPearInstallerDep($pearInstaller['min'], $pearInstaller['max']);
    }

    if ($do_update_dependencies_list === true) {
        foreach ($packages as $name => $raw) {
            $package->addPackageDepWithChannel($raw['type'], $name, $raw['channel'],
                $raw['min'], $raw['max'], $raw['recommanded']);
        }
    }
}

$package->generateContents();

if (isset($_GET['commit']) || isset($_SERVER['argv'][1]) && $_SERVER['argv'][1] == 'commit') {
   $package->writePackageFile();
} else {
   $package->debugPackageFile();
}
?>