<?php
// Cleanup
$file = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'temp' . DIRECTORY_SEPARATOR;
unlink($file . 'blarfoo/blartest.txt');
rmdir($file . 'blarfoo');


unlink($file . 'subfoo/test11.txt');
unlink($file . 'subfoo/test12.txt');
unlink($file . 'subfoo/subsubfoo/boo.txt');

rmdir($file . 'subfoo/subsubfoo');
rmdir($file . 'subfoo');


unlink($file . 'test1.txt');
unlink($file . 'test2.txt');
unlink($file . '.test');

unlink($file . 'CVS' . DIRECTORY_SEPARATOR . 'Entries');
unlink($file . 'CVS' . DIRECTORY_SEPARATOR . 'Entries.Extra');
rmdir($file . 'CVS');

unlink($file . 'testCVS' . DIRECTORY_SEPARATOR . 'testEntries');
unlink($file . 'testCVS' . DIRECTORY_SEPARATOR . 'testEntries.Extra');
rmdir($file . 'testCVS');

rmdir($file);