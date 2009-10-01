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
require_once dirname(__FILE__) . '/../Log/Dummy/Logger.php';

require_once 'PHP/Depend/TextUI/Runner.php';

/**
 * Test case for the text ui runner.
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
class PHP_Depend_TextUI_RunnerTest extends PHP_Depend_AbstractTest
{
    /**
     * Tests that the runner exits with an exception for an invalud source
     * directory.
     *
     * @return void
     */
    public function testRunnerThrowsRuntimeExceptionForInvalidSourceDirectory()
    {
        $runner = new PHP_Depend_TextUI_Runner();
        $runner->setSourceArguments(array('foo/bar'));

        $this->setExpectedException(
            'RuntimeException',
            "Invalid directory 'foo/bar' added.",
            PHP_Depend_TextUI_Runner::EXCEPTION_EXIT
        );

        $runner->run();
    }

    /**
     * Tests that the runner stops processing if no logger is specified.
     *
     * @return void
     */
    public function testRunnerThrowsRuntimeExceptionIfNoLoggerIsSpecified()
    {
        $runner = new PHP_Depend_TextUI_Runner();
        $runner->setSourceArguments(array(dirname(__FILE__). '/../_code/code-without-comments'));

        $this->setExpectedException(
            'RuntimeException',
            'No output specified',
            PHP_Depend_TextUI_Runner::EXCEPTION_EXIT
        );

        $runner->run();
    }

    public function testRunnerUsesCorrectFileFilter()
    {
        $fileName = self::createRunResourceURI('pdepend.dummy');
        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $runner = new PHP_Depend_TextUI_Runner();
        $runner->setSourceArguments(array(dirname(__FILE__). '/../_code'));
        $runner->setFileExtensions(array('inc'));
        $runner->addLogger('dummy-logger', $fileName);

        ob_start();
        $runner->run();
        ob_end_clean();

        $this->assertFileExists($fileName);

        $data = unserialize(file_get_contents($fileName));

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
        $this->assertEquals(1, $function->getExceptionClasses()->count());
        $this->assertEquals('MyException', $function->getExceptionClasses()->current()->getName());

        $code->next();

        $package = $code->current();
        $this->assertType('PHP_Depend_Code_Package', $package);
        $this->assertEquals('pdepend.test2', $package->getName());

        $sourceFile = realpath(dirname(__FILE__). '/../_code/function.inc');
        $this->assertEquals($sourceFile, $function->getSourceFile()->getName());

        unlink($fileName);
    }

    /**
     * Tests that the runner handles the <b>--without-annotations</b> option
     * correct.
     *
     * @return void
     */
    public function testRunnerHandlesWithoutAnnotationsOptionCorrect()
    {
        $fileName = self::createRunResourceURI('pdepend.dummy');
        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $runner = new PHP_Depend_TextUI_Runner();
        $runner->setSourceArguments(array(dirname(__FILE__). '/../_code'));
        $runner->setFileExtensions(array('inc'));
        $runner->addLogger('dummy-logger', $fileName);
        $runner->setWithoutAnnotations();

        ob_start();
        $runner->run();
        ob_end_clean();

        $this->assertFileExists($fileName);

        $data = unserialize(file_get_contents($fileName));

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

        unlink($fileName);
    }

    public function testSupportBadDocumentation()
    {
        $fileName = self::createRunResourceURI('pdepend.dummy');
        if (file_exists($fileName)) {
            unlink($fileName);
        }

        $runner = new PHP_Depend_TextUI_Runner();
        $runner->setSourceArguments(array(dirname(__FILE__). '/../_code/code-without-comments'));
        $runner->setSupportBadDocumentation();
        $runner->addLogger('dummy-logger', $fileName);

        ob_start();
        $runner->run();
        ob_end_clean();

        $this->assertFileExists($fileName);

        $data = unserialize(file_get_contents($fileName));

        $code = $data['code'];
        $this->assertType('PHP_Depend_Code_NodeIterator', $code);
        $this->assertEquals(1, $code->count());

        $code->rewind();

        $package = $code->current();
        $this->assertType('PHP_Depend_Code_Package', $package);
        $this->assertEquals(PHP_Depend_BuilderI::DEFAULT_PACKAGE, $package->getName());

        $this->assertEquals(7, $package->getClasses()->count());
        $this->assertEquals(3, $package->getInterfaces()->count());

        unlink($fileName);
    }
}