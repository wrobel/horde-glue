--TEST--
PEAR_PackageFileManager->addReplacement, invalid
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->setOptions(array('state' => 'alpha', 'version' => '1.0',
    'packagedirectory' => dirname(dirname(__FILE__)), 'baseinstalldir' => 'Foo',
    'packagefile' => 'test1_package.xml',
    'filelistgenerator' => 'File'));
$phpunit->assertNoErrors('setup');
$packagexml->addReplacement('peeber.php', 'ribbit', 'tadpole', 'frog');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Replacement Type must be one of "' .
    implode(PEAR_Common::getReplacementTypes(), ', ') .
    '", was passed "ribbit"')),
    'invalid role test'
);
$phpunit->assertTrue(empty($packagexml->_options['replacements']),
    'replacements was set, should not be');
echo 'tests done';
?>
--EXPECT--
tests done
