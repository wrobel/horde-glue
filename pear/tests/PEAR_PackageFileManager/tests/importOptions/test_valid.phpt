--TEST--
PEAR_PackageFileManager->importOptions, valid test
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$res = $packagexml->importOptions(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'test1_package.xml');
$phpunit->assertTrue($res, 'return');
$phpunit->assertEquals(array (
  'packagefile' => 'package.xml',
  'doctype' => 'http://pear.php.net/dtd/package-1.0',
  'filelistgenerator' => 'File',
  'license' => 'PHP License',
  'changelogoldtonew' => true,
  'roles' =>
  array (
    'h' => 'src',
    'c' => 'src',
    'cpp' => 'src',
    'm4' => 'src',
    'w32' => 'src',
    'dll' => 'ext',
    'php' => 'php',
    'html' => 'doc',
    '*' => 'data',
  ),
  'dir_roles' =>
  array (
    'docs' => 'doc',
    'examples' => 'doc',
    'tests' => 'test',
  ),
  'exceptions' =>
  array (
  ),
  'installexceptions' =>
  array (
  ),
  'installas' =>
  array (
  ),
  'platformexceptions' =>
  array (
  ),
  'scriptphaseexceptions' =>
  array (
  ),
  'ignore' =>
  array (
  ),
  'include' => false,
  'deps' =>
  array (
    1 =>
    array (
      'type' => 'pkg',
      'rel' => 'ge',
      'version' => '1.1',
      'optional' => 'no',
      'name' => 'PEAR',
    ),
  ),
  'maintainers' =>
  array (
    0 =>
    array (
      'handle' => 'cellog',
      'name' => 'Greg Beaver',
      'email' => 'cellog@users.sourceforge.net',
      'role' => 'lead',
    ),
  ),
  'notes' => 'bugfix release

- fixed #8: notices if a package has no dependencies
',
  'changelognotes' => false,
  'outputdirectory' => false,
  'pathtopackagefile' => false,
  'lang' => 'en',
  'configure_options' =>
  array (
  ),
  'replacements' =>
  array (
  ),
  'pearcommonclass' => 'PEAR_PackageFileManager_ComplexGenerator',
  'simpleoutput' => false,
  'addhiddenfiles' => false,
  'cleardependencies' => false,
  'package' => 'PEAR_PackageFileManager',
  'summary' => 'PEAR_PackageFileManager takes an existing package.xml file and updates it with a new filelist and changelog',
  'description' => 'This package revolutionizes the maintenance of PEAR packages.  With a few parameters,
the entire package.xml is automatically updated with a listing of all files in a package.
Features include
 - reads in an existing package.xml file, and only changes the release/changelog
 - a plugin system for retrieving files in a directory.  Currently two plugins
   exist, one for standard recursive directory content listing, and one that
   reads the CVS/Entries files and generates a file listing based on the contents
   of a checked out CVS repository
 - incredibly flexible options for assigning install roles to files/directories
 - ability to ignore any file based on a * ? wildcard-enabled string
 - ability to manage dependencies
 - can output the package.xml in any directory, and read in the package.xml
   file from any directory.
 - can specify a different name for the package.xml file
',
  'date' => '2003-10-14',
  'version' => '1.1.0',
  'state' => 'stable',
), $packagexml->getOptions(), 'options');
echo 'tests done';
?>
--EXPECT--
tests done