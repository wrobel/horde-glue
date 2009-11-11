--TEST--
PEAR_PackageFileManager->_generateNewPackageXML, valid test, with maintainers
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->_options['package'] = 'test';
$packagexml->_options['summary'] = 'test';
$packagexml->_options['description'] = 'test';
$packagexml->_options['maintainers'] =
    array(
        array('name' => 'Gerg', 'email' => 'foo@example.com',
              'role' => 'lead',
              'handle' => 'cellogerg')
    );
$ret = $packagexml->_generateNewPackageXML();
$phpunit->assertFalse(is_object($ret), 'did not return true');
$phpunit->assertEquals(array (
  'package' => 'test',
  'summary' => 'test',
  'description' => 'test',
  'changelog' => 
  array (
  ),
  'release_deps' => 
  array (
  ),
  'maintainers' => 
  array (
    0 => 
    array (
      'name' => 'Gerg',
      'email' => 'foo@example.com',
      'role' => 'lead',
      'handle' => 'cellogerg',
    ),
  ),
),
    $packagexml->_packageXml,
    'incorrect package');
echo 'tests done';
?>
--EXPECT--
tests done