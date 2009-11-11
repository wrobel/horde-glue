<?php
/**
 * A complex example
 *
 * @category   PEAR
 * @package    PEAR_PackageFileManager
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  2003-2006 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    CVS: $Id: createPhpDocumentor_package.xml.php,v 1.3 2006/05/21 17:13:08 farell Exp $
 * @link       http://pear.php.net/package/PEAR_PackageFileManager
 * @since      File available since Release 0.12
 * @ignore
 */

require_once 'PEAR/PackageFileManager.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);

$test = new PEAR_PackageFileManager();

// directory that phpDocumentor 1.2.2 CVS is located in
$packagedir = 'C:/Web Pages/chiara/phpdoc';

$test->setOptions(array(
    'summary' => 'phpDocumentor package provides automatic documenting of php api directly from the source',
    'description' => 'phpDocumentor tool is a standalone auto-documentor similar to JavaDoc written in PHP',
    'baseinstalldir' => 'PhpDocumentor',
    'version' => '1.2.2',
    'packagedirectory' => $packagedir,
    'state' => 'stable',
    'filelistgenerator' => 'cvs',
    'notes' => 'Bugfix release

- DocBook/peardoc2 converter outputs valid DocBook
- fixed Page-Level DocBlock issues, now a page-level
  docblock is the first docblock in a file if it contains
  a @package tag, UNLESS the next element is a class.  Warnings
  raised are much more informative
- removed erroneous warning of duplicate @package tag in certain cases
- fixed these bugs:
 [ 765455 ] phpdoc can\'t find php if it is in /usr/local/bin
 [ 767251 ] broken links when no files in default package
 [ 768947 ] Multiple vars not recognised
 [ 772441 ] nested arrays fail parser
',
    'package' => 'PhpDocumentor',
    'dir_roles' => array('Documentation' => 'doc', 'Documentation/tests' => 'test'),
    'exceptions' => array(
        'index.html' => 'php',
        'docbuilder/index.html' => 'php',
        'docbuilder/blank.html' => 'php',
        'README' => 'doc',
        'ChangeLog' => 'doc',
        'PHPLICENSE.txt' => 'doc',
        'poweredbyphpdoc.gif' => 'data',
        'INSTALL' => 'doc',
        'FAQ' => 'doc',
        'Authors' => 'doc',
        'Release-1.2.0beta1' => 'doc',
        'Release-1.2.0beta2' => 'doc',
        'Release-1.2.0beta3' => 'doc',
        'Release-1.2.0rc1' => 'doc',
        'Release-1.2.0rc2' => 'doc',
        'Release-1.2.0' => 'doc',
        'Release-1.2.1' => 'doc',
        'Release-1.2.2' => 'doc',
        'pear-phpdoc' => 'script',
        'pear-phpdoc.bat' => 'script',
        ),
    'ignore' => array('package.xml', "$packagedir/phpdoc", 'phpdoc.bat', 'LICENSE'),
    'installas' => array('pear-phpdoc' => 'phpdoc', 'pear-phpdoc.bat' => 'phpdoc.bat'),
    'installexceptions' => array('pear-phpdoc' => '/', 'pear-phpdoc.bat' => '/', 'scripts/makedoc.sh' => '/'),
    ));
$test->addMaintainer('cellog', 'lead', 'Gregory Beaver', 'cellog@php.net');

$test->addPlatformException('pear-phpdoc', '(*ix|*ux)');
$test->addPlatformException('pear-phpdoc.bat', 'windows');
$test->addDependency('php', '4.1.0', 'ge', 'php');
// replace @PHP-BIN@ in this file with the path to php executable!  pretty neat
$test->addReplacement('pear-phpdoc', 'pear-config', '@PHP-BIN@', 'php_bin');
$test->addReplacement('pear-phpdoc.bat', 'pear-config', '@PHP-BIN@', 'php_bin');
// hack until they get their shit in line with docroot role
$test->addRole('tpl', 'php');
$test->addRole('png', 'php');
$test->addRole('gif', 'php');
$test->addRole('jpg', 'php');
$test->addRole('css', 'php');
$test->addRole('js', 'php');
$test->addRole('ini', 'php');
$test->addRole('inc', 'php');
$test->addRole('afm', 'php');
$test->addRole('pkg', 'doc');
$test->addRole('cls', 'doc');
$test->addRole('proc', 'doc');
$test->addRole('sh', 'script');
if (isset($_GET['make'])) {
    $test->writePackageFile();
} else {
    $test->debugPackageFile();
}
if (!isset($_GET['make'])) {
    echo '<a href="' . $_SERVER['PHP_SELF'] . '?make=1">Make this file</a>';
}
?>