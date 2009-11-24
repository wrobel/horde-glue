<?php
/**
 * Here is a sample file that demonstrates how to keep up-to-date
 * an existing package xml (2.0 and also 1.0) with only the require-function-calls
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   pear
 * @package    PEAR_PackageFileManager
 * @author     Laurent Laville <pear@laurent-laville.org>
 * @copyright  2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: updatepackage.php,v 1.2 2006/10/06 12:13:40 farell Exp $
 * @link       http://pear.php.net/package/PEAR_PackageFileManager
 * @since      File available since Release 1.6.0
 * @ignore
 */

require_once 'PEAR/PackageFileManager2.php';

PEAR::setErrorHandling(PEAR_ERROR_DIE);

$packagefile = 'c:/php/pear/HTML_Progress2/package2.xml';

$options = array('filelistgenerator' => 'cvs',
    'baseinstalldir' => 'HTML',
    'outputdirectory' => 'c:/php/pear',
    'simpleoutput' => true,
    'clearcontents' => false,  // import also tasks, and roles files exceptions
                               // required PEAR_PackageFileManager 1.6.0b5 or better
    'changelogoldtonew' => false
    );

$p2 = &PEAR_PackageFileManager2::importOptions($packagefile, $options);
$p2->setPackageType('php');
$p2->addRelease();
$p2->generateContents();
$p2->setReleaseVersion('2.2.0');
$p2->setAPIVersion('2.2.0');
$p2->setReleaseStability('alpha');
$p2->setAPIStability('stable');
$p2->setNotes('bugfixe for dupplicates entry in package xml 1.0 export');

// Avoid to define again what is already defined unless you want to give new values
//$p2->setPhpDep('4.2.0');
//$p2->setPearinstallerDep('1.4.3');

if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $p2->writePackageFile();
} else {
    $p2->debugPackageFile();
}
?>