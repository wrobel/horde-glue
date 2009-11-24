<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The PHP Group                                     |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Scott Mattocks <scottmattocks@php.net>                       |
// +----------------------------------------------------------------------+
//
// $Id: example2.php,v 1.4 2006/11/07 13:53:37 scottmattocks Exp $
/**
 * Example usage script for Console_Getargs.
 *
 * Console_Getargs is a class to help define and parse commandline
 * options. The goal is to easily identify arguments a user may pass
 * to an application run from the commandline. By specifying option
 * names and rules, the applicatioin programmer can be sure that a 
 * user has given the application the needed information before any
 * processing begins. 
 *
 * This file attempts to give the reader an understanding of the
 * usage and power of Console_Getargs through an example. At the
 * bottom of this file you will see several commented commands 
 * for running this script. While this script aims at being as
 * thorough as possible, it is by no means a complete set of the
 * possible combinations that could be used with Console_Getargs.
 *
 * @author    Bertrand Mansion <bmansion@mamasam.com>
 * @author    Scott Mattocks   <scottmattocks@php.net>
 * @copyright 2004
 * @license   http://www.php.net/license/3_0.txt PHP License 3.0
 * @version   @VER@
 * @package   Console_Getargs
 */
error_reporting(E_ALL);
/**
 * Dummy class for example. 
 * 
 * This class returns the number of lines in a given file. It can
 * optionally give you the first X lines, plus "highlight" certain
 * words by surrounding them in '*'. When told to, this class can
 * get very chatty. 
 *
 * Please note that this class is not intended to be overly useful
 * or efficient. It is meant simply to demonstrate the capabilities
 * of Console_Getargs. It may be neccessary to change some paths
 * depending on how you have installed Console_Getargs and the setup
 * of your system.
 *
 * Run the following commands to see how to use Console_Getargs:
 *
 *  $ php -q example2.php -h
 *  $ php -q example2.php
 *  $ php -q example2.php -v 1
 *  $ php -q example2.php -v 
 *  $ php -q example2.php -dv
 *  $ php -q example2.php -dvs 10
 *  $ php -q example2.php -vs 10 -f if
 *  $ php -q example2.php -vs 10 -hi if
 *  $ php -q example2.php -vs 10 -f if file
 *  $ php -q example2.php -s 10 ../Getargs.php 
 *  $ php -q example2.php -s 10 -f if file --parameters=../Getargs.php 
 *
 * Also try creating your own array of arguments and passing it to the
 * example instance on construction. You array should be numerically
 * indexed. Here are a few examples:
 *  array('-d', '-vs', '10')
 *  array('--debug', '--verbose', '../Getargs.php');
 */
class Example {
    
    /**
     * Show debug output.
     * @var boolean
     */
    var $debug;
    /**
     * The complete path to the file to count lines in.
     * @var string
     */
    var $file;
    /**
     * How many lines to show.
     * @var integer
     */
    var $showLines;
    /**
     * The level of chattyness.
     * @var integer
     */
    var $verbose;
    /**
     * The words to find and highlight.
     * @var array
     */
    var $findWords = array();
    
    /**
     * Constructor.
     * 
     * This will create an instance of the example object. If
     * you pass an array of arguments on construction, that 
     * array will be used instead of the default agument list.
     * 
     * @access public
     * @param  array  $argArray The optional argument list.
     * @return void
     */  
    function Example($argArray = NULL)
    {
        // Get the config array
        require_once 'Console/Getargs.php';
        $config = $this->getConfigArray();
        
        // Get the arguments.
        if (is_array($argArray)) {
            // Use given arg list not $_SERVER['argv'].
            $args =& Console_Getargs::factory($config, $argArray);
        } else {
            // Use $_SERVER['argv'].
            $args =& Console_Getargs::factory($config);
        }
        
        // Check for errors.
        if (PEAR::isError($args)) {
            if ($args->getCode() === CONSOLE_GETARGS_ERROR_USER) {
                // User put illegal values on the command line.
                echo Console_Getargs::getHelp($config, NULL, $args->getMessage(), 78, 4)."\n";
            } else if ($args->getCode() === CONSOLE_GETARGS_HELP) {
                // User needs help.
                echo Console_Getargs::getHelp($config, NULL, NULL, 78, 4)."\n";
            }
            exit;
        } else {
            // Assign the member vars.
            $this->debug     = $args->getValue('debug');
            $this->file      = $args->getValue(CONSOLE_GETARGS_PARAMS);
            $this->showLines = $args->getValue('showlines');
            $this->verbose   = $args->getValue('verbose');
            $this->findWords = $args->getValue('find');
            
            // Make sure the file is readable.
            if (!@is_readable($this->file)) {
                $msg = $this->file . ' is not readable.';
                echo Console_Getargs::getHelp($config, NULL, $msg) . "\n";
                exit;
            }
        }
    }
    
    /**
     * Return the config array.
     *
     * The config array is the set of rules for command line
     * arguments. For more details please read the comments
     * in Getargs.php
     *
     * @static
     * @access public
     * @param  none
     * @return &array
     */
    function &getConfigArray()
    {
        $configArray = array();
        
        // Allow the user to show debug output.
        $configArray['debug'] = array('short' => 'db',
                                      'max'   => 0,
                                      'desc'  => 'Show debug output.'
                                      );
        // Make the program chatty.
        $configArray['verbose'] = array('short'   => 'v',
                                        'min'     => 0,
                                        'max'     => 1,
                                        'desc'    => 'Set the verbose level.',
                                        'default' => 2
                                        );
        // How many lines should be shown.
        $configArray['showlines'] = array('short'   => 's',
                                          'min'     => 1,
                                          'max'     => 1,
                                          'desc'    => 'How many lines of the file should be shown.',
                                          );
        // What file should be used.
        $configArray[CONSOLE_GETARGS_PARAMS] = array('min'     => 1,
                                                     'max'     => 1,
                                                     'desc'    => 'The file to count lines from.',
                                                     'default' => basename(__FILE__)
                                                     );
        // Show the help message. 
        // (Not really needed unless you want help to show up in the 
        //  list of options in the help menu.)
        $configArray['help'] = array('short' => 'h',
                                     'max'   => 0,
                                     'desc'  => 'Show this help.'
                                     );
        // Search for and highlight a word.
        $configArray['find|highlight'] = array('short' => 'f|hi',
                                               'max'   => -1,
                                               'min'   => 0,
                                               'desc'  => 'Find words within the lines displayed. Words found will be changed from "word" to "*word*".'
                                               );
        return $configArray;
    }
    
    /**
     * The method for displaying the results.
     *
     * This will output atleast the number of lines. Depending on the
     * options passed on the command line, more info may be shown.
     *
     * @access public
     * @param  none
     * @return void
     */
    function display()
    {
        // How chatty should the program be.
        if ($this->verbose > 1) {
            echo "Welcome to the Console_Getargs example2 script!\n";
        } 
        
        if ($this->verbose > 0) {
            echo basename($this->file) . ' has ';
        }
        
        // Spit out the number of lines.
        echo $this->countLines();
        
        if ($this->verbose > 0) {
            echo ' lines.';
        }
        
        echo "\n";
        
        // If the user wants to highlight ceratin words do it.
        if (count($this->findWords)) {
            // Chattyness.
            if ($this->verbose) {
                echo "Searching for:\t";
                settype($this->findWords, 'array');
                foreach ($this->findWords as $word) {
                    echo $word . ', ';
                }
                echo "\n";
            }
            
            // Spit out the requested number of lines.
            echo $this->find($this->getFirstXLines());
        } else {
            // Just output the lines.
            echo $this->getFirstXLines();
        }
    }
    
    /**
     * Return the number of lines in the file.
     *
     * @access public
     * @param  none
     * @return integer
     */
    function countLines()
    {
        return count(file($this->file));
    }
    
    /**
     * Return the requested number of lines.
     *
     * Depending on the arguments passed on the command line, some
     * words may be surrounded with '*'.
     *
     * @access public
     * @param  none
     * @return string
     */
    function getFirstXLines()
    {
        // Show debug output if requested.
        if ($this->debug) {
            echo "Getting all lines from file\t";
        }
        
        // Get the lines from the file.
        $lines = file($this->file);
        
        if ($this->debug) {
            echo "OK\n";
        }
        
        $retString = '';
        
        // Collect the lines.
        if (count($lines) && !empty($this->showLines)) {
            for ($i = 0; $i < $this->showLines; ++$i) {
                if ($this->debug) {
                    echo $i . "\t" . $lines[$i] . "\n";
                }
                
                $retString.= $lines[$i];
            }
        }
        
        return $retString;
    }
    
    /**
     * Highlight the requested words.
     *
     * If the user wants some words highlighted, surround them in
     * '*'.
     *
     * @access public
     * @param  string $text The text to find words in.
     * @return string
     */
    function find($text) 
    {
        $highlighted = $text;
        
        settype($this->findWords, 'array');
        
        // Replace each word.
        foreach ($this->findWords as $word) {
            $highlighted = str_replace($word, '*' . $word . '*', $highlighted);
        }
        
        return $highlighted;
    }
}

// Create a new instance of the Example.
$ex = new Example();

// Show the results.
$ex->display();
/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */
?>
