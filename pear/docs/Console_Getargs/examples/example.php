<?php
/**
 * Example for Console_Getargs class
 * 
 * $Id: example.php,v 1.7 2004/10/14 20:44:41 scottmattocks Exp $
 */

require_once 'Console/Getargs.php';

$config = array(
            // Option takes 2 values
            'files|images' => array('short' => 'f|i',
				    'min' => 2,
				    'max' => 2,
				    'desc' => 'Set the source and destination image files.'),
            // Option takes 1 value
            'width' => array('short' => 'w',
			     'min' => 1,
			     'max' => 1,
			     'desc' => 'Set the new width of the image.'),
            // Option is a switch
            'debug' => array('short' => 'd',
			     'max' => 0,
			     'desc' => 'Switch to debug mode.'),
            // Option takes from 1 to 3 values, using the default value(s) if the arg is not present
            'formats' => array('min' => 1,
			       'max' => 3,
			       'desc' => 'Set the image destination format.',
			       'default' => array('jpegbig', 'jpegsmall')),
            // Option takes from 1 to an unlimited number of values
            'filters' => array('short' => 'fi',
			       'min' => 1,
			       'max' => -1,
			       'desc' => 'Set the filters to be applied to the image upon conversion. The filters will be used in the order they are set.'),
            // Option accept 1 value or nothing. If nothing, then the default value is used
            'verbose' => array('short' => 'v',
			       'min' => 0,
			       'max' => 1,
			       'desc' => 'Set the verbose level.',
			       'default' => 3),
            // Parameters. Anything leftover at the end of the command line is added.
            CONSOLE_GETARGS_PARAMS => array('min' => 1,
					    'max' => 2,
					    'desc' =>
					    'Set the application parameters.',
					    'default' => 'DEFAULT')
            );

$args =& Console_Getargs::factory($config);

// Use the following two lines to test passing an array
// other than $_SERVER['argv']
//$test =  array('-dvw', 500, 'foo1', 'foo2');
//$args =& Console_Getargs::factory($config, $test);

if (PEAR::isError($args)) {
    $header = "Console_Getargs Example\n".
              'Usage: '.basename($_SERVER['SCRIPT_NAME'])." [options]\n\n";
    if ($args->getCode() === CONSOLE_GETARGS_ERROR_USER) {
        echo Console_Getargs::getHelp($config, $header, $args->getMessage())."\n";
    } else if ($args->getCode() === CONSOLE_GETARGS_HELP) {
        echo Console_Getargs::getHelp($config, $header)."\n";
        // To see the automatic header uncomment this line
        //echo Console_Getargs::getHelp($config)."\n";
    }
    exit;
}

echo 'Verbose: '.$args->getValue('verbose')."\n";
echo 'Formats: '.(is_array($args->getValue('formats')) ? implode(', ', $args->getValue('formats'))."\n" : $args->getValue('formats')."\n");
echo 'Files: '.($args->isDefined('files') ? implode(', ', $args->getValue('files'))."\n" : "undefined\n");
if ($args->isDefined('fi')) {
    echo 'Filters: '.(is_array($args->getValue('fi')) ? implode(', ', $args->getValue('fi'))."\n" : $args->getValue('fi')."\n");
} else {
    echo "Filters: undefined\n";
}
echo 'Width: '.$args->getValue('w')."\n";
echo 'Debug: '.($args->isDefined('d') ? "YES\n" : "NO\n");
echo 'Parameters: '.($args->isDefined('parameters') ? is_array($args->getValue('parameters')) ? implode(', ', $args->getValue('parameters')) : $args->getValue('parameters') : "undefined") . "\n";

// Test with:
// ----------
// Get the help message
// php -q example.php -h
//
// Pass two files
// php -q example.php -v -f src.tiff dest.tiff
//
// Set verbose level 5, pass two files, and debug
// php -q example.php -v5 -f src.tiff dest.tiff -d
//
// Set verbose level 1, pass two files, debug, and set width to 100
// php -q example.php -v 1 -f src.tiff dest.tiff -d --width=100
//
// Set verbose (defaults to 3), pass two files, and pass two filters
// php -q example.php -v -f src.tiff dest.tiff -fi sharp blur
//
// Set three formats
// php -q example.php --format gif jpeg png
//
// Debug, set verbose to default level and width to 100
// php -q example.php -dvw 100
//
// Pass two application parameters
// php -q example.php foo1 foo2
//
// Debug, set verbose level 5, pass two files, and pass two application parameters
// php -q examples/example.php -dv5 -f src.tiff dest.tiff foo1 foo2 

?>