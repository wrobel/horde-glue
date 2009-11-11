<?php
/**
 * Here is a sample file that demonstrates all of PEAR_PackageFileManager2's features.
 *
 * First, a subpackage is created that is then automatically processed with the parent package
 * Next, the parent package is created.  Finally, a compatible PEAR_PackageFileManager object is
 * automatically created from the parent package in order to maintain two copies of the same file.
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR_PackageFileManager
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  2005 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: makepackage.php,v 1.3 2006/05/21 17:13:08 farell Exp $
 * @link       http://pear.php.net/package/PEAR_PackageFileManager
 * @since      File available since Release 1.6.0
 * @ignore
 */
/**
 * This is the only setup function needed
 */
require_once 'PEAR/PackageFileManager2.php';
// recommended - makes PEAR_Errors act like exceptions (kind of)
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$p2 = new PEAR_PackageFileManager2();
$p2->setOptions(array('filelistgenerator' => 'file',
      'packagedirectory' => dirname(__FILE__),
      'baseinstalldir' => 'PEAR',
      'include' => array('makepackage.php'),
      'simpleoutput' => true));
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setPackage('PEAR_PackageFileManager2_maker');
$p2->setChannel('pear.php.net');
$p2->setReleaseVersion('0.1.0');
$p2->setAPIVersion('0.1.0');
$p2->setReleaseStability('alpha');
$p2->setAPIStability('alpha');
$p2->setSummary('Manager class for package.xml version 2.0');
$p2->setDescription('Creates package.xml version 2.0 and manages content');
$p2->setNotes('Initial release');
$p2->setPhpDep('4.2.0');
$p2->addPackageDepWithChannel('required', 'PEAR_PackageFileManager2', 'pear.php.net', '0.1.0', false, '0.1.0');
$p2->setPearinstallerDep('1.4.0a12');
$p2->addMaintainer('lead', 'cellog', 'Greg Beaver', 'cellog@php.net');
$p2->setLicense('PHP License', 'http://www.php.net/license');
$packagexml = new PEAR_PackageFileManager2();
$packagexml->specifySubpackage($p2, false, true);
$packagexml->setOptions(array('filelistgenerator' => 'file',
      'packagedirectory' => dirname(__FILE__),
      'baseinstalldir' => 'PEAR',
      'simpleoutput' => true));
$packagexml->setPackageType('php');
$packagexml->addRelease();
$packagexml->setPackage('PEAR_PackageFileManager2');
$packagexml->setChannel('pear.php.net');
$packagexml->setReleaseVersion('0.1.0');
$packagexml->setAPIVersion('0.1.0');
$packagexml->setReleaseStability('alpha');
$packagexml->setAPIStability('alpha');
$packagexml->setSummary('Manager class for package.xml version 2.0');
$packagexml->setDescription('Creates package.xml version 2.0 and manages content');
$packagexml->setNotes('Initial release');
$packagexml->setPhpDep('4.2.0');
$packagexml->setPearinstallerDep('1.4.0a12');
$packagexml->addPackageDepWithChannel('required', 'PEAR_PackageFileManager', 'pear.php.net', '1.5.1');
$packagexml->addMaintainer('lead', 'cellog', 'Greg Beaver', 'cellog@php.net');
$packagexml->setLicense('PHP License', 'http://www.php.net/license');
$packagexml->addGlobalReplacement('package-info', '@PEAR-VER@', 'version');
$packagexml->generateContents();
$pkg = &$packagexml->exportCompatiblePackageFile1();
if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $pkg->writePackageFile();
    $packagexml->writePackageFile();
} else {
    $pkg->debugPackageFile();
    $packagexml->debugPackageFile();
}
?>