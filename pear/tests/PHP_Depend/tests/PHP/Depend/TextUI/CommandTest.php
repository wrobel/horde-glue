<?php
/**
 * This file is part of PHP_Depend.
 *
 * PHP Version 5
 *
 * Copyright (c) 2008-2009, Manuel Pichler <mapi@pdepend.org>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Manuel Pichler nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage TextUI
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

require_once dirname(__FILE__) . '/../AbstractTest.php';

require_once 'PHP/Depend/TextUI/Command.php';
require_once 'PHP/Depend/Util/ConfigurationInstance.php';

/**
 * Test case for the text ui command.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage TextUI
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.7
 * @link       http://pdepend.org/
 */
class PHP_Depend_TextUI_CommandTest extends PHP_Depend_AbstractTest
{
    /**
     * Expected output of the --version option.
     *
     * @var string $_versionOutput
     */
    private $_versionOutput = "PHP_Depend 0.9.7 by Manuel Pichler\n\n";

    /**
     * Expected output of the --usage option.
     *
     * @var string $_usageOutput
     */
    private $_usageOutput = "Usage: pdepend [options] [logger] <dir[,dir[,...]]>\n\n";

    /**
     * Tests the result of the print version option.
     *
     * @return void
     */
    public function testPrintVersion()
    {
        list($exitCode, $actual) = $this->_executeCommand(array('--version'));

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode);
        $this->assertEquals($this->_versionOutput, $actual);
    }

    /**
     * Tests the result of the print usage option.
     *
     * @return void
     */
    public function testPrintUsage()
    {
        list($exitCode, $actual) = $this->_executeCommand(array('--usage'));

        $expected = $this->_versionOutput . $this->_usageOutput;

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode);
        $this->assertEquals($expected, $actual);
    }

    /**
     * Tests the output of the print help option.
     *
     * @return void
     */
    public function testPrintHelp()
    {
        list($exitCode, $actual) = $this->_executeCommand(array('--help'));

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode);

        $this->assertHelpOutput($actual);
    }

    /**
     * Tests that the command exits with an cli error if no $argv array exists.
     *
     * @return void
     */
    public function testCommandExitsWithCliErrorIfNotArgvArrayExists()
    {
        list($exitCode, $actual) = $this->_executeCommand();

        $this->assertEquals(PHP_Depend_TextUI_Command::CLI_ERROR, $exitCode);

        $startsWith = 'Unknown error, no $argv array available.' . PHP_EOL . PHP_EOL;
        $this->assertHelpOutput($actual, $startsWith);
    }

    /**
     * Tests that the command exits with a cli error for an empty option list.
     *
     * @return void
     */
    public function testCommandExitsWithCliErrorForEmptyOptionList()
    {
        list($exitCode, $actual) = $this->_executeCommand(array());

        $this->assertEquals(PHP_Depend_TextUI_Command::CLI_ERROR, $exitCode);

        $this->assertHelpOutput($actual);
    }

    /**
     * Tests that the command starts the text ui runner.
     *
     * @return void
     */
    public function testCommandStartsProcessWithDummyLogger()
    {
        $logFile = self::createRunResourceURI('pdepend.dummy');
        $source  = realpath(dirname(__FILE__) . '/../_code');

        set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));

        $argv = array(
            '--suffix=inc',
            '--ignore=code-5.2.x',
            '--exclude=pdepend.test2',
            '--dummy-logger=' . $logFile,
            $source
        );

        if (file_exists($logFile)) {
            unlink($logFile);
        }

        list($exitCode, $actual) = $this->_executeCommand($argv);

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode);
        $this->assertFileExists($logFile);

        unlink($logFile);
    }

    /**
     * Tests that the command exits with a cli error for an unknown option.
     *
     * @return void
     */
    public function testCommandExitsWithCliErrorForUnknownOption()
    {
        list($exitCode, $actual) = $this->_executeCommand(array('--unknown'));

        $this->assertEquals(PHP_Depend_TextUI_Command::CLI_ERROR, $exitCode);
    }

    /**
     * Tests that the command handles the <b>--without-annotations</b> option
     * correct.
     *
     * @return void
     */
    public function testCommandHandlesWithoutAnnotationsOptionCorrect()
    {
        $logFile = self::createRunResourceURI('pdepend.dummy');
        $source  = realpath(dirname(__FILE__) . '/../_code');

        $argv = array(
            '--suffix=inc',
            '--without-annotations',
            '--coderank-mode=property',
            '--dummy-logger=' . $logFile,
            $source
        );

        if (file_exists($logFile)) {
            unlink($logFile);
        }

        list($exitCode, $actual) = $this->_executeCommand($argv);

        $this->assertFileExists($logFile);

        $data = unserialize(file_get_contents($logFile));

        $code = $data['code'];
        $this->assertType('PHP_Depend_Code_NodeIterator', $code);
        $this->assertEquals(2, $code->count());

        $code->rewind();

        $package = $code->current();

        $this->assertType('PHP_Depend_Code_Package', $package);
        $this->assertEquals('pdepend.test', $package->getName());

        $this->assertEquals(1, $package->getFunctions()->count());
        $this->assertEquals(1, $package->getClasses()->count());

        $function = $package->getFunctions()->current();
        $this->assertType('PHP_Depend_Code_Function', $function);
        $this->assertEquals('foo', $function->getName());
        $this->assertEquals(0, $function->getExceptionClasses()->count());

        $code->next();

        $package = $code->current();
        $this->assertType('PHP_Depend_Code_Package', $package);
        $this->assertEquals('pdepend.test2', $package->getName());

        unlink($logFile);
    }

    /**
     * Tests that the command handles the <b>--bad-documentation</b> option
     * correct.
     *
     * @return void
     */
    public function testCommandHandlesBadDocumentationOptionCorrect()
    {
        $logFile = self::createRunResourceURI('pdepend.dummy');
        $source  = realpath(dirname(__FILE__) . '/../_code/code-without-comments');

        $argv = array(
            '--bad-documentation',
            '--dummy-logger=' . $logFile,
            $source
        );

        if (file_exists($logFile)) {
            unlink($logFile);
        }

        list($exitCode, $actual) = $this->_executeCommand($argv);

        $this->assertFileExists($logFile);

        $data = unserialize(file_get_contents($logFile));

        $code = $data['code'];
        $this->assertType('PHP_Depend_Code_NodeIterator', $code);
        $this->assertEquals(1, $code->count());

        $code->rewind();

        $package = $code->current();
        $this->assertType('PHP_Depend_Code_Package', $package);
        $this->assertEquals(PHP_Depend_BuilderI::DEFAULT_PACKAGE, $package->getName());

        $this->assertEquals(7, $package->getClasses()->count());
        $this->assertEquals(3, $package->getInterfaces()->count());

        unlink($logFile);
    }

    /**
     * Tests that the command interpretes a "-d key" as "on".
     *
     * @return void
     */
    public function testCommandHandlesIniOptionWithoutValueToON()
    {
        // Get backup
        if (($backup = ini_set('html_errors', 'off')) === false) {
            $this->markTestSkipped('Cannot alter ini setting "html_errors".');
        }

        $argv = array(
            '-d',
            'html_errors',
            '--dummy-logger=' . self::createRunResourceURI('pdepend.dummy'),
            dirname(__FILE__)
        );

        list($exitCode, $actual) = $this->_executeCommand($argv);

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode, $actual);
        $this->assertEquals('on', ini_get('html_errors'));

        ini_set('html_errors', $backup);
    }

    /**
     * Tests that the text ui command handles an ini option "-d key=value" correct.
     *
     * @return void
     */
    public function testCommandHandlesIniOptionWithValue()
    {
        // Get backup
        if (($backup = ini_set('html_errors', 'on')) === false) {
            $this->markTestSkipped('Cannot alter ini setting "html_errors".');
        }

        $argv = array(
            '-d',
            'html_errors=off',
            '--dummy-logger=' . self::createRunResourceURI('pdepend.dummy'),
            dirname(__FILE__)
        );

        list($exitCode, $actual) = $this->_executeCommand($argv);

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode);
        $this->assertEquals('off', ini_get('html_errors'));

        ini_set('html_errors', $backup);
    }

    /**
     * Tests that the command sets a configuration instance for a specified
     * config file.
     *
     * @return void
     */
    public function testCommandHandlesConfigurationFileCorrect()
    {
        // Sample config file
        $configFile = self::createRunResourceURI('config.xml');
        // Write a dummy config file.
        file_put_contents(
            $configFile,
            '<?xml version="1.0"?>
             <configuration>
               <test />
             </configuration>'
        );

        $argv = array(
            '--configuration=' . $configFile,
            '--dummy-logger=' . self::createRunResourceURI('pdepend.dummy'),
            dirname(__FILE__)
        );

        // Result previous instance
        PHP_Depend_Util_ConfigurationInstance::set(null);

        list($exitCode, $actual) = $this->_executeCommand($argv);

        // Remove temp config file
        unlink($configFile);

        $this->assertEquals(PHP_Depend_TextUI_Runner::SUCCESS_EXIT, $exitCode);
        $this->assertNotNull(PHP_Depend_Util_ConfigurationInstance::get());

        $test = isset(PHP_Depend_Util_ConfigurationInstance::get()->test);
        $this->assertTrue($test);
    }

    /**
     * Tests that the command fails for an invalid config file.
     *
     * @return void
     */
    public function testCommandFailsIfAnInvalidConfigFileWasSpecified()
    {
        $configFile = self::createRunResourceURI('config.xml');
        if (file_exists($configFile) === true) {
            unlink($configFile);
        }

        $argv = array(
            '--configuration=' . $configFile,
            dirname(__FILE__)
        );

        list($exitCode, $actual) = $this->_executeCommand($argv);

        $this->assertSame(PHP_Depend_TextUI_Command::CLI_ERROR, $exitCode);
        $this->assertContains(
            sprintf('The configuration file "%s" doesn\'t exist.', $configFile),
            $actual
        );
    }

    /**
     * Tests the help output with an optional prolog text.
     *
     * @param string $actual     The cli output.
     * @param string $prologText Optional prolog text.
     *
     * @return void
     */
    protected function assertHelpOutput($actual, $prologText = '')
    {
        $startsWith = $prologText . $this->_versionOutput . $this->_usageOutput;
        $startsWith = '/^' . preg_quote($startsWith) . '/';
        $this->assertRegExp($startsWith, $actual);

        $this->assertRegExp('(  --configuration=<file>[ ]+Optional\s+PHP_Depend\s+configuration\s+file\.)', $actual);
        $this->assertRegExp('(  --suffix=<ext\[,\.{3}\]>[ ]+List\s+of\s+valid\s+PHP\s+file\s+extensions\.)', $actual);
        $this->assertRegExp('(  --ignore=<dir\[,\.{3}\]>[ ]+List\s+of\s+exclude\s+directories\.)', $actual);
        $this->assertRegExp('(  --exclude=<pkg\[,\.{3}\]>[ ]+List\s+of\s+exclude\s+packages\.)', $actual);
        $this->assertRegExp('(  --without-annotations[ ]+Do\s+not\s+parse\s+doc\s+comment\s+annotations\.)', $actual);
        $this->assertRegExp('(  --bad-documentation[ ]+Fallback\s+for\s+projects\s+with\s+bad\s+doc\s+comments\.)', $actual);
        $this->assertRegExp('(  --optimization=<mode>[ ]+Runtime\s+switch\s+to\s+influence\s+the\s+internal\s+processing\.)', $actual);
        $this->assertRegExp('(  [ ]+"best"[ ]+Provides\s+lowest\s+memory\s+usage\s+with\s+best\s+possible\s+performance\.)', $actual);
        $this->assertRegExp('(  [ ]+"none"[ ]+Highest\s+memory\s+usage\s+without\s+any\s+caching\.)', $actual);
        $this->assertRegExp('(  --help[ ]+Print\s+this\s+help\s+text\.)', $actual);
        $this->assertRegExp('(  --version[ ]+Print\s+the\s+current\s+version\.)', $actual);
        $this->assertRegExp('(  -d key\[=value\][ ]+Sets\s+a\s+php.ini\s+value\.)', $actual);
    }

    /**
     * Executes the text ui command and returns the exit code and the output as
     * an array <b>array($exitCode, $output)</b>.
     *
     * @param array $argv The cli parameters.
     *
     * @return array(mixed)
     */
    private function _executeCommand(array $argv = null)
    {
        $this->_prepareArgv($argv);

        ob_start();
        $exitCode = PHP_Depend_TextUI_Command::main();
        $output   = ob_get_contents();
        ob_end_clean();

        return array($exitCode, $output);
    }

    /**
     * Prepares a fake <b>$argv</b>.
     *
     * @param array $argv The cli parameters.
     *
     * @return void
     */
    private function _prepareArgv(array $argv = null)
    {
        unset($_SERVER['argv']);

        if ($argv !== null) {
            // Add dummy file
            array_unshift($argv, __FILE__);

            // Replace global $argv
            $_SERVER['argv'] = $argv;
        }
    }
}