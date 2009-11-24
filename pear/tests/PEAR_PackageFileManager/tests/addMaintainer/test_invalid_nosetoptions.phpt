--TEST--
PEAR_PackageFileManager->addMaintainer, update existing maintainer
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
$packagexml->addMaintainer('peeber.php', 'ribbit', 'tadpole', 'frog');
$phpunit->assertErrors(array(array('package' => 'PEAR_Error', 'message' =>
    'PEAR_PackageFileManager Error: Run $managerclass->setOptions() before any other methods')),
    'no setOptions() test'
);
echo 'tests done';
?>
--EXPECT--
tests done
