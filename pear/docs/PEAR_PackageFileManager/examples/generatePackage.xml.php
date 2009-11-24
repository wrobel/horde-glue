<?php
/**
 * A simple example
 *
 * @category   PEAR
 * @package    PEAR_PackageFileManager
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  2003-2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: generatePackage.xml.php,v 1.5 2006/05/21 17:13:08 farell Exp $
 * @link       http://pear.php.net/package/PEAR_PackageFileManager
 * @since      File available since Release 0.1
 * @ignore
 */

require_once 'PEAR/PackageFileManager.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$test = new PEAR_PackageFileManager();
$test->setOptions(array(
    'package' => 'PEAR_PackageFileManager',
    'summary' => 'PFM builds package.xml file version 1.0',
    'description' => 'PFM takes an existing package.xml file and updates it with a new filelist and changelog',
    'baseinstalldir' => 'PEAR',
    'version' => '0.1',
    'packagedirectory' => 'C:/cvsstuff/pear/pear_packagefilemanager',
    'state' => 'alpha',
    'filelistgenerator' => 'file',
    'notes' => 'First release of PEAR_PackageFileManager',
    'ignore' => array('package.xml')
    ));
$test->addDependency('PEAR', '1.1');
$test->addMaintainer('cellog', 'lead', 'Gregory Beaver', 'cellog@php.net');
$test->writePackageFile();
?>