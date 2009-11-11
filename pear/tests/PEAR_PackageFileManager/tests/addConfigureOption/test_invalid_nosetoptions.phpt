--TEST--
PEAR_PackageFileManager->addConfigureOption, invalid
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->addConfigureOption('frog', 'Sound a frog makes', 'ribbit');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Run $managerclass->setOptions() before any other methods')),
    'no setOptions() test'
);
echo 'tests done';
?>
--EXPECT--
tests done
