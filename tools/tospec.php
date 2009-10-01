<?php

require_once 'Horde/Autoloader.php';


$parser = new Horde_Argv_Parser();
list($opts, $xml) = $parser->parseArgs();
if (count($xml) != 1) {
    throw new InvalidArgumentException('List a single package.xml to handle.');
}

if (!file_exists($xml[0])) {
    throw new InvalidArgumentException(sprintf('Given file "%s" does not exist!', $xml[0]));
}

$package_xml = $xml[0];

$config = &PEAR_Config::singleton();
$a = new PEAR_PackageFile($config);
$pkgobj = $a->fromPackageFile($package_xml, PEAR_VALIDATE_NORMAL);

$path_elements = explode('/', $package_xml);

if (is_a($pkgobj, 'PEAR_Error')) {
    print $pkgobj->getMessage();
    exit(1);
}

$pear_package = $pkgobj->getName();
$package      = 'Horde_' . preg_replace('/Horde_/', '', $pear_package);
$pear_pkgdir  = $path_elements[count($path_elements) - 2];
$version      = $pkgobj->getVersion();
$summary      = $pkgobj->getSummary();
$description  = $pkgobj->getDescription();
$license      = $pkgobj->getLicense();

$description  = str_replace('  ', ' ', str_replace("\n", ' ', $description));
$description  = " \\\n" . Horde_String::wordwrap($description, 75, " \\\n") . ' \\';

$deps = $pkgobj->getDependencies();

$dependencies = '';
if (isset($deps['required']['package'])) {
    $dependencies = array();
    if (isset($deps['required']['package']['name'])) {
        $deps = array($deps['required']['package']);
    } else {
        $deps = $deps['required']['package'];
    }
    foreach ($deps as $dep) {
        $pkg = $dep['name'];
        if (isset($dep['channel'])) {
            if ($dep['channel'] == 'pear.horde.org') {
                $pname = 'Horde_' . preg_replace('/Horde_/', '', $pkg);
            } else if ($dep['channel'] == 'pear.php.net') {
                $pname = 'PEAR-' . $pkg;
            } else {
                print sprintf('Unkown channel %s!', $dep['channel']);
                exit(1);
            }
        } else {
            $pname = 'PEAR-' . $pkg;
        }
        if (isset($dep['min'])) {
            $line = 'PreReq:       ' . $pname . ' >= ' . $dep['min'];
        } else {
            $line = 'PreReq:       ' . $pname;
        }
        $line .= str_repeat(' ', 42 - strlen($line)) . ' \\';
        $dependencies[] = $line;
    }
    $dependencies = join("\n", $dependencies) . "\n";
}


switch ($path_elements[0]) {
case 'horde-fw3':
    $info = <<<EOI
# The name of the source package
pear_package='$pear_package'

# The name of the RPM package
package='$package'

# Where to find information about the package
package_url='http://pear.horde.org/index.php?package='

# How should the source be retrieved?
#
# WGET:   Download via wget
# VC-CVS: Checkout from the Horde CVS repository
# VC-GIT: Checkout from the Horde git repository
package_origin='VC-CVS'

# The name of the package in the source repository
pear_pkgdir='$pear_pkgdir'

# Commit tag or date to use
repo_commit='HORDE_3_3_4'

# What release number should the source snapshot get (usually a date)?
repo_release='20090501'

# Version number
version='${version}dev20090501'

# Package release number
release='20090713'

# Source URL to download from
sourceurl='http://files.kolab.org/incoming/wrobel/'

# In which PHP library location should the library get installed
php_lib_loc='php'

# Build prerequisites
buildprereq='                              \
BuildPreReq:  OpenPKG, openpkg >= 20070603 \
BuildPreReq:  php, php::with_pear = yes    \
BuildPreReq:  PEAR-Horde-Channel           \
'

# Installation prerequisites
prereq='                                   \
PreReq:       OpenPKG, openpkg >= 20070603 \
PreReq:       php, php::with_pear = yes    \
PreReq:       PEAR-Horde-Channel           \
$dependencies'

# Package summary description
summary='$summary'

# Long package description
description='$description
'

# Source code license
license='$license'

EOI;
    break;
default:
    die();
}

$dir = 'kolab-cvs/server/pear/' . $package;
if (!file_exists($dir)) {
    mkdir($dir);
}
file_put_contents($dir . '/package.info', $info);

$cvsignore = <<<EOI
*.src.rpm
*.tgz
*.spec
package.patch
tmp

EOI;

file_put_contents($dir . '/.cvsignore', $cvsignore);

$makefile = <<<EOI
include ../Pear.mk

EOI;

file_put_contents($dir . '/Makefile', $makefile);

if (file_exists($dir . '/ChangeLog')) {
    $changes = file_get_contents($dir . '/ChangeLog');
    if (!strpos($changes, 'HORDE_3_3_4')
        && !strpos($changes, 'snapshot')
        && !strpos($changes, 'package.info')) {
        $entry = <<<EOI
2009-07-21  Gunnar Wrobel  <p@rdus.de>

	* package.info: Converted to new packaging style. Updated to tag
	                HORDE_3_3_4.


EOI;
        $changes = $entry . $changes ;
        file_put_contents($dir . '/ChangeLog', $changes);
    }
} else {
    $changes = <<<EOI
2009-07-21  Gunnar Wrobel  <p@rdus.de>

	* package.info: Added package to Kolab CVS.
EOI;
    file_put_contents($dir . '/ChangeLog', $changes);
}
