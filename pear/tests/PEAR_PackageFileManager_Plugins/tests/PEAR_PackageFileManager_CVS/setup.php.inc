<?php
error_reporting(E_ALL);
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'phpt_test.php.inc';
require_once 'PEAR/PackageFileManager/Cvs.php';
$options    = array('lang' => 'en');
$packagexml = new PEAR_PackageFileManager_Cvs($options);
$phpunit    = new PEAR_PHPTest(true);

$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
if (!file_exists($file)) {
    mkdir($file);
}

touch($file . 'test1.txt');
touch($file . 'test2.txt');
touch($file . '.test');

if (!file_exists($file . 'blarfoo')) {
    mkdir($file . 'blarfoo');
}

touch($file . 'blarfoo/blartest.txt');

if (!file_exists($file . 'subfoo')) {
    mkdir($file . 'subfoo');
}

touch($file . 'subfoo/test11.txt');
touch($file . 'subfoo/test12.txt');

if (!file_exists($file . 'subfoo/subsubfoo')) {
    mkdir($file . 'subfoo/subsubfoo');
}

touch($file . 'subfoo/subsubfoo/boo.txt');

if (!file_exists($file . 'testCVS')) {
    mkdir($file . 'testCVS');
}

touch($file . 'testCVS/testEntries');
touch($file . 'testCVS/testEntries.Extra');

$z = fopen($file . 'testCVS' . DIRECTORY_SEPARATOR . 'testEntries', 'w');
$string = "D/blarfoo///
D/subfoo///
/test1.txt///
/test2.txt///
/.test///";
fwrite($z, $string);
fclose($z);

$z = fopen($file . 'testCVS' . DIRECTORY_SEPARATOR . 'testEntries.Extra', 'w');
$string = "D/blarfoo////
D/subfoo////
/test1.txt/1.1/Sat Oct 18 21:59:39 2003//
/test2.txt/1.1/Sat Oct 18 21:59:50 2003//
/.test/1.1/Sat Feb  7 05:04:12 2004//";
fwrite($z, $string);
fclose($z);

if (!file_exists($file . 'CVS')) {
    mkdir($file . 'CVS');
}

copy($file . 'testCVS' . DIRECTORY_SEPARATOR . 'testEntries',       $file . 'CVS' . DIRECTORY_SEPARATOR . 'Entries');
copy($file . 'testCVS' . DIRECTORY_SEPARATOR . 'testEntries.Extra', $file . 'CVS' . DIRECTORY_SEPARATOR . 'Entries.Extra');
