--TEST--
PEAR_PackageFileManager_XMLOutput
--SKIPIF--
--FILE--
<?php
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'setup.php.inc';
require_once 'PEAR/PackageFileManager/XMLOutput.php';
$packagexml = new PEAR_PackageFileManager_XMLOutput;
$arr = 
array(
    '/' =>
    array(
        'baseinstalldir' => 'frunk',
        '##files' =>
            array(
                'tired' => array('role' => 'script'),
                'first' =>
                    array(
                        '##files' =>
                            array(
                                'first.php' =>
                                    array(
                                        'role' => 'php',
                                        'install-as' => 'flop',
                                        'platform' => 'windows',
                                        'md5sum' => '25',
                                        'replacements' =>
                                            array(
                                                array(
                                                    'from' => 'blah',
                                                    'to' => 'version',
                                                    'type' => 'package-info'
                                                )
                                            ),
                                    ),
                                'second.dat' =>
                                    array(
                                        'role' => 'data',
                                    ),
                                'another' =>
                                    array(
                                        '##files' =>
                                            array(
                                                'third' =>
                                                    array(
                                                        'role' => 'test'
                                                    )
                                            )
                                    )
                            ),
                    ),
                'second' =>
                    array(
                        '##files' =>
                            array(
                            'nested' =>
                                array(
                                    '##files' =>
                                        array(
                                            'another' => array(
                                            'baseinstalldir' => '/')
                                        )
                                )
                            )
                    ),
                // directory named files
                'files' =>
                    array(
                        '##files' =>
                            array(
                                'wow' => array('role' => 'doc')
                            )
                    ),
            )
    )
);
$phpunit->assertEquals(array(str_replace("\r", '', '      <dir baseinstalldir="frunk" name="/">
       <file role="script" name="tired"/>
       <dir name="first">
        <file role="php" md5sum="25" platform="windows" install-as="flop" name="first.php">
          <replace from="blah" to="version" type="package-info"/>
        </file>
        <file role="data" name="second.dat"/>
        <dir name="another">
         <file role="test" name="third"/>
        </dir> <!-- first/another -->
       </dir> <!-- first -->
       <dir name="second">
        <dir name="nested">
         <file baseinstalldir="/" name="another"/>
        </dir> <!-- second/nested -->
       </dir> <!-- second -->
       <dir name="files">
        <file role="doc" name="wow"/>
       </dir> <!-- files -->
      </dir> <!-- / -->
')), array($packagexml->_doFileList('', $arr, '/')), 'test');
echo 'tests done';
?>
--EXPECT--
tests done
