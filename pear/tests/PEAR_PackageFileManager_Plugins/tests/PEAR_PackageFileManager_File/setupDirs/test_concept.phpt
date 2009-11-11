--TEST--
PEAR_PackageFileManager_File->_setupDirs, proof-of-concept
--SKIPIF--
<?php
if (@file_exists(dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'CVS')) {
    echo 'skip cannot run in CVS';
}
?>
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['addhiddenfiles'] = false;
$packagexml->_options['ignore'] =
$packagexml->_options['include'] = false;
$packagexml->_setupIgnore(false, 0);
$packagexml->_setupIgnore(false, 1);
$list = $packagexml->dirList($package_directory =
    dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest');
$struc = array();
foreach($list as $file) {
	$path = substr(dirname($file), strlen(str_replace(DIRECTORY_SEPARATOR, 
                                                      '/',
                                                      realpath($package_directory))) + 1);
	if (!$path) {
        $path = '/';
    }
	$ext = array_pop(explode('.', $file));
	if (strlen($ext) == strlen($file)) {
        $ext = '';
    }
	$struc[$path][] = array('file' => basename($file),
                            'ext' => $ext,
                            'path' => (($path == '/') ? basename($file) : $path . '/' . basename($file)),
                            'fullpath' => $file);
}
$phpunit->assertEquals(
    array(
    'blarfoo' =>
      array(
        array('file' => 'blartest.txt',
              'ext' => 'txt',
              'path' => 'blarfoo/blartest.txt',
              'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/blarfoo/blartest.txt')
           ),
    'subfoo/subsubfoo' =>
      array(
        array('file' => 'boo.txt',
              'ext' => 'txt',
              'path' => 'subfoo/subsubfoo/boo.txt',
              'fullpath' =>dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/subfoo/subsubfoo/boo.txt')
           ),
    'subfoo' =>
      array(
        array('file' => 'test11.txt',
              'ext' => 'txt',
              'path' => 'subfoo/test11.txt',
              'fullpath' =>dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/subfoo/test11.txt'),
        array('file' => 'test12.txt',
              'ext' => 'txt',
              'path' => 'subfoo/test12.txt',
              'fullpath' =>dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/subfoo/test12.txt'),
           ),
    '/' =>
      array(
        array('file' => 'test1.txt',
              'ext' => 'txt',
              'path' => 'test1.txt',
              'fullpath' =>dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/test1.txt'),
        array('file' => 'test2.txt',
              'ext' => 'txt',
              'path' => 'test2.txt',
              'fullpath' =>dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/test2.txt'),
           ),
    'testCVS' =>
        array(
            0 =>
                array(
                    'file' => 'testEntries',
                    'ext' => '',
                    'path' => 'testCVS/testEntries',
                    'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/testCVS/testEntries',
                ),
                array(
                    'file' => 'testEntries.Extra',
                    'ext' => 'Extra',
                    'path' => 'testCVS/testEntries.Extra',
                    'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/testCVS/testEntries.Extra',
                ),
            ),
              ), $struc, 'wrong basic structure');
uksort($struc,'strnatcasecmp');
foreach($struc as $key => $ind) {
	usort($ind, array($packagexml, 'sortfiles'));
	$struc[$key] = $ind;
}
$phpunit->assertEquals(
array (
  '/' => 
  array (
    0 => 
    array (
      'file' => 'test1.txt',
      'ext' => 'txt',
      'path' => 'test1.txt',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/test1.txt',
    ),
    1 => 
    array (
      'file' => 'test2.txt',
      'ext' => 'txt',
      'path' => 'test2.txt',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/test2.txt',
    ),
  ),
  'blarfoo' => 
  array (
    0 => 
    array (
      'file' => 'blartest.txt',
      'ext' => 'txt',
      'path' => 'blarfoo/blartest.txt',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/blarfoo/blartest.txt',
    ),
  ),
  'subfoo' => 
  array (
    0 => 
    array (
      'file' => 'test11.txt',
      'ext' => 'txt',
      'path' => 'subfoo/test11.txt',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/subfoo/test11.txt',
    ),
    1 => 
    array (
      'file' => 'test12.txt',
      'ext' => 'txt',
      'path' => 'subfoo/test12.txt',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/subfoo/test12.txt',
    ),
  ),
  'subfoo/subsubfoo' => 
  array (
    0 => 
    array (
      'file' => 'boo.txt',
      'ext' => 'txt',
      'path' => 'subfoo/subsubfoo/boo.txt',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/subfoo/subsubfoo/boo.txt',
    ),
  ),
  'testCVS' => 
  array (
    0 => 
    array (
      'file' => 'testEntries',
      'ext' => '',
      'path' => 'testCVS/testEntries',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/testCVS/testEntries',
    ),
    1 => 
    array (
      'file' => 'testEntries.Extra',
      'ext' => 'Extra',
      'path' => 'testCVS/testEntries.Extra',
      'fullpath' => dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'footest/testCVS/testEntries.Extra',
    ),
  ),
), $struc, 'wrong sorted structure');
echo 'tests done';
?>
--EXPECT--
tests done