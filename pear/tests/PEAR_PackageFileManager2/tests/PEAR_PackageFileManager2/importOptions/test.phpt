--TEST--
PEAR_PackageFileManager2->setOptions, existing package.xml, no changelog
--SKIPIF--
--FILE--
<?php
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml = PEAR_PackageFileManager2::importFromPackageFile1(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'packagefiles' .
    DIRECTORY_SEPARATOR . 'package_foo.xml', array('packagedirectory' => '.', 'baseinstalldir' => '/'));

$phpunit->assertNoErrors('existing packagexml');
$phpunit->assertIsa('PEAR_PackageFileManager2', $packagexml, 'packagefile');

$changelog = $packagexml->getChangelog();
$phpunit->assertEquals(array (
  'release' =>
  array (
    0 =>
    array (
      'version' =>
      array (
        'release' => '1.4.0',
        'api' => '1.4.0',
      ),
      'stability' =>
      array (
        'release' => 'stable',
        'api' => 'stable',
      ),
      'date' => '2005-09-18',
      'license' =>
      array (
        'attribs' =>
        array (
          'uri' => 'http://www.php.net/license/3_0.txt',
        ),
        '_content' => 'PHP License',
      ),
      'notes' => 'This is a major milestone release for PEAR.  In addition to several killer features,
every single element of PEAR has a regression test, and so stability is much higher
than any previous PEAR release.
New features in a nutshell:
* full support for channels
* pre-download dependency validation
* new package.xml 2.0 format allows tremendous flexibility while maintaining BC
* support for optional dependency groups and limited support for sub-packaging
* robust dependency support
* full dependency validation on uninstall
* remote install for hosts with only ftp access - no more problems with
  restricted host installation [through PEAR_RemoteInstaller package]
* full support for mirroring
* support for bundling several packages into a single tarball
* support for static dependencies on a uri-based package
* support for custom file roles and installation tasks
NOTE: users of PEAR_Frontend_Web/PEAR_Frontend_Gtk must upgrade their installations
to the latest version, or PEAR will not upgrade properly',
    ),
    1 =>
    array (
      'version' =>
      array (
        'release' => '1.4.1',
        'api' => '1.4.0',
      ),
      'stability' =>
      array (
        'release' => 'stable',
        'api' => 'stable',
      ),
      'date' => '2005-09-25',
      'license' =>
      array (
        'attribs' =>
        array (
          'uri' => 'http://www.php.net/license/3_0.txt',
        ),
        '_content' => 'PHP License',
      ),
      'notes' => 'Major bugfix release.  This is a recommended download for ALL PEAR users

UPGRADING FROM 1.4.0 WILL CAUSE A SERIES OF NOTICES.  IGNORE THEM.
THIS IS CAUSED BY A BUG IN 1.4.0 THAT IS FIXED IN 1.4.1
* fix prompt processing in post-install scripts
* make dual package.xml equivalency stricter when using package.xml/package2.xml
* fix critical error in validating bogus php dependencies of package.xml 1.0
  This error has existed for every PEAR version, and allows dependencies like:
  <dep type="php" rel="has">4.3.0</dep> to
  slip through unnoticed
* re-enable php-const replacements
* PEAR_PackageFile_v2::getConfigureOptions() was missing!!
* fix cvsdiff command
* fix xml encoding issues finally
* clean up package.xml 1.0 dir/file parsing
* fix invalid PEAR_Config generation
* change the user agent from PHP/phpversion to PEAR/pearversion/PHP/phpversion
* don\'t use a bogus uri for licenses on running convert command
* add "pickle" command for PECL packaging
* add validation warning if the release date in package.xml is not today when packaging
* implement progress bar for list-all/remote-list
* fix Bug #5323: pear search returns odd version numbers
* fix Bug #5428: pear cvstag package2.xml does not include the package.xml
* fix Bug #5449: pear makerpm completely broken for package.xml 2.0
* fix Bug #5462: raiseError method does not return by ref anymore
* fix Bug #5465: pear install --offline fails to display error
* fix Bug #5477: Bug in Downloader.php and Dependency2.php
* fix Bug #5481: "pear install PECLextension" should display warning to use pecl command
* fix Bug #5482: installation of PECL packages should say add extensions to php.ini
* fix Bug #5483: pecl uninstall crack fatal error
* fix Bug #5487: PECL: compiled files are not uninstalled via the uninstall command
* fix Bug #5488: pecl uninstall package fails if package has a package.xml 1.0
* fix Bug #5501: the commands list mentions XML-RPC
* fix Bug #5509: addDependecyGroup does not validate group name
* fix Bug #5513: PEAR 1.4 does not install non-pear.php.net packages',
    ),
    2 =>
    array (
      'version' =>
      array (
        'release' => '1.4.2',
        'api' => '1.4.0',
      ),
      'stability' =>
      array (
        'release' => 'stable',
        'api' => 'stable',
      ),
      'date' => '2005-10-08',
      'license' =>
      array (
        'attribs' =>
        array (
          'uri' => 'http://www.php.net/license/3_0.txt',
        ),
        '_content' => 'PHP License',
      ),
      'notes' => 'Minor bugfix release
* fix issues with API for adding tasks to package2.xml
* fix Bug #5520: pecl pickle fails on pecl pickle fails on extension/package deps
* fix Bug #5523: pecl pickle misses to put configureoptions into package.xml v1
* fix Bug #5527: No need for cpp
* fix Bug #5529: configure options in package.xml 2.0 will be ignored
* fix Bug #5530: PEAR_PackageFile_v2->getConfigureOptions() API incompatible with v1
* fix Bug #5531: adding of installconditions/binarypackage/configure options
                 to extsrc may fail
* fix Bug #5550: PHP notices/warnings/errors are 1 file off in trace
* fix Bug #5580: pear makerpm XML_sql2xml-0.3.2.tgz error
* fix Bug #5619: pear makerpm produces invalid .spec dependancy code
* fix Bug #5629: pear install http_download dies with bad error message',
    ),
    3 =>
    array (
      'version' =>
      array (
        'release' => '1.4.3',
        'api' => '1.4.1',
      ),
      'stability' =>
      array (
        'release' => 'stable',
        'api' => 'stable',
      ),
      'date' => '2005-11-03',
      'license' =>
      array (
        'attribs' =>
        array (
          'uri' => 'http://www.php.net/license/3_0.txt',
        ),
        '_content' => 'PHP License',
      ),
      'notes' => 'MINOR SECURITY FIX release

A security vulnerability has been discovered in all
PEAR versions (1.0 to 1.4.2).  This vulnerability has been fixed,
and this is a recommended upgrade for all users.

Run "pear channel-update" after upgrading for exponentially
faster list-all/remote-list!!

* fix installation of files named like ".test"
* fix base class for writeable unixeol/windowseol classes
* fix running of post-install scripts with empty or no paramgroup
  in CLI frontend
* fix validation of <postinstallscript>
* fix writeable PEAR_Task_Postinstallscript_rw class
* fix error in REST-based search command if searching through description
  as well
* silence warning on list-upgrades/upgrade-all if no releases exist at a channel
* add checks for updated channel.xml in all remote commands
* fix pecl script if safe_mode is enabled by default
* implement SERIOUS improvement in list-all/remote-list speed.  From 6 minutes
  down to about 16-30 seconds
* implement --loose option to avoid recommended version validation
* implement Request #5527: alternative approach to determining glibc version
* fix Bug #5717: analyzeSourceCode() fails to process certain
  quote situations properly
* fix Bug #5736: if registry can\'t lock registry or open filemap,
  checkFileMap(), no error
* fix Bug #5676: pear config-create broken
* fix Bug #5683: Deadlock with (almost) circular dependency
* fix Bug #5725: PHP5 warnings need improvement
* fix Bug #5789: small typo
* fix Bug #5810: internet should not be contacted on install if dependencies are installed',
    ),
  ),
), $changelog, 'changelog');

echo 'tests done';
?>
--EXPECT--
tests done
