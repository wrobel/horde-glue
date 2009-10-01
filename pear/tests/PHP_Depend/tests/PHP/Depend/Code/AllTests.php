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
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@pdepend.org>
 * @copyright 2008-2009 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   SVN: $Id$
 * @link      http://pdepend.org/
 */

if (defined('PHPUnit_MAIN_METHOD') === false) {
    define('PHPUnit_MAIN_METHOD', 'PHP_Depend_Code_AllTests::main');
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once dirname(__FILE__) . '/ASTAllocationExpressionTest.php';
require_once dirname(__FILE__) . '/ASTArgumentsTest.php';
require_once dirname(__FILE__) . '/ASTClassOrInterfaceReferenceTest.php';
require_once dirname(__FILE__) . '/ASTCompoundVariableTest.php';
require_once dirname(__FILE__) . '/ASTConstantDefinitionTest.php';
require_once dirname(__FILE__) . '/ASTConstantPostfixTest.php';
require_once dirname(__FILE__) . '/ASTConstantTest.php';
require_once dirname(__FILE__) . '/ASTFieldDeclarationTest.php';
require_once dirname(__FILE__) . '/ASTFunctionPostfixTest.php';
require_once dirname(__FILE__) . '/ASTMethodPostfixTest.php';
require_once dirname(__FILE__) . '/ASTLiteralTest.php';
require_once dirname(__FILE__) . '/ASTInstanceOfExpressionTest.php';
require_once dirname(__FILE__) . '/ASTPropertyPostfixTest.php';
require_once dirname(__FILE__) . '/ASTStaticReferenceTest.php';
require_once dirname(__FILE__) . '/ASTStaticVariableDeclarationTest.php';
require_once dirname(__FILE__) . '/ASTVariableDeclaratorTest.php';

require_once dirname(__FILE__) . '/ClassTest.php';
require_once dirname(__FILE__) . '/FileTest.php';
require_once dirname(__FILE__) . '/FunctionTest.php';
require_once dirname(__FILE__) . '/InterfaceTest.php';
require_once dirname(__FILE__) . '/MethodTest.php';
require_once dirname(__FILE__) . '/NodeIteratorTest.php';
require_once dirname(__FILE__) . '/PackageTest.php';
require_once dirname(__FILE__) . '/ParameterTest.php';
require_once dirname(__FILE__) . '/PropertyTest.php';

require_once dirname(__FILE__) . '/ReflectionClassTest.php';
require_once dirname(__FILE__) . '/ReflectionParameterTest.php';
require_once dirname(__FILE__) . '/ReflectionPropertyTest.php';

require_once dirname(__FILE__) . '/Filter/AllTests.php';

/**
 * Main test suite for the PHP_Depend_Code package.
 *
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@pdepend.org>
 * @copyright 2008-2009 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.7
 * @link      http://pdepend.org/
 */
class PHP_Depend_Code_AllTests
{
    /**
     * Test suite main method.
     *
     * @return void
     */
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    /**
     * Creates the phpunit test suite for this package.
     *
     * @return PHPUnit_Framework_TestSuite
     */
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PHP_Depend_Code - AllTests');
        
        $suite->addTest(PHP_Depend_Code_Filter_AllTests::suite());

        $suite->addTestSuite('PHP_Depend_Code_ClassTest');
        $suite->addTestSuite('PHP_Depend_Code_FileTest');
        $suite->addTestSuite('PHP_Depend_Code_FunctionTest');
        $suite->addTestSuite('PHP_Depend_Code_InterfaceTest');
        $suite->addTestSuite('PHP_Depend_Code_MethodTest');
        $suite->addTestSuite('PHP_Depend_Code_NodeIteratorTest');
        $suite->addTestSuite('PHP_Depend_Code_PackageTest');
        $suite->addTestSuite('PHP_Depend_Code_PropertyTest');
        $suite->addTestSuite('PHP_Depend_Code_ParameterTest');

        $suite->addTestSuite('PHP_Depend_Code_ASTAllocationExpressionTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTArgumentsTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTClassOrInterfaceReferenceTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTCompoundVariableTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTConstantDefinitionTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTConstantPostfixTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTConstantTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTFieldDeclarationTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTFunctionPostfixTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTLiteralTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTInstanceOfExpressionTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTMethodPostfixTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTPropertyPostfixTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTStaticReferenceTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTStaticVariableDeclarationTest');
        $suite->addTestSuite('PHP_Depend_Code_ASTVariableDeclaratorTest');

        $suite->addTestSuite('PHP_Depend_Code_ReflectionClassTest');
        $suite->addTestSuite('PHP_Depend_Code_ReflectionParameterTest');
        $suite->addTestSuite('PHP_Depend_Code_ReflectionPropertyTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD === 'PHP_Depend_Code_AllTests::main') {
    PHP_Depend_Code_AllTests::main();
}