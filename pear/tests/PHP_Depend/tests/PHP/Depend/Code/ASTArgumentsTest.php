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
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 */

require_once dirname(__FILE__) . '/ASTNodeTest.php';

require_once 'PHP/Depend/Code/ASTArguments.php';

/**
 * Test case for the {@link PHP_Depend_Code_ASTArguments} class.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.7
 * @link       http://www.pdepend.org/
 */
class PHP_Depend_Code_ASTArgumentsTest extends PHP_Depend_Code_ASTNodeTest
{
    /**
     * Tests that the parser adds the expected childs to an argument instance.
     * 
     * @return void
     */
    public function testArgumentsContainsStaticMethodPostfixExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $prefix = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTMemberPrimaryPrefix::CLAZZ, $prefix);

        $reference = $prefix->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassOrInterfaceReference::CLAZZ, $reference);

        $postfix = $prefix->getChild(1);
        $this->assertType(PHP_Depend_Code_ASTMethodPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsContainsMethodPostfixExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $prefix = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTMemberPrimaryPrefix::CLAZZ, $prefix);

        $variable = $prefix->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTVariable::CLAZZ, $variable);

        $postfix = $prefix->getChild(1);
        $this->assertType(PHP_Depend_Code_ASTMethodPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsContainsConstantsPostfixExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $prefix = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTMemberPrimaryPrefix::CLAZZ, $prefix);

        $reference = $prefix->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassOrInterfaceReference::CLAZZ, $reference);

        $postfix = $prefix->getChild(1);
        $this->assertType(PHP_Depend_Code_ASTConstantPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsContainsPropertyPostfixExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $prefix = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTMemberPrimaryPrefix::CLAZZ, $prefix);

        $reference = $prefix->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassOrInterfaceReference::CLAZZ, $reference);

        $postfix = $prefix->getChild(1);
        $this->assertType(PHP_Depend_Code_ASTPropertyPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsContainsSelfPropertyPostfixExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $method   = $packages->current()
            ->getClasses()
            ->current()
            ->getMethods()
            ->current();

        $arguments = $method->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $prefix = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTMemberPrimaryPrefix::CLAZZ, $prefix);

        $reference = $prefix->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTSelfReference::CLAZZ, $reference);

        $postfix = $prefix->getChild(1);
        $this->assertType(PHP_Depend_Code_ASTPropertyPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsContainsParentMethodPostfixExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $method   = $packages->current()
            ->getClasses()
            ->current()
            ->getMethods()
            ->current();

        $arguments = $method->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $prefix = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTMemberPrimaryPrefix::CLAZZ, $prefix);

        $reference = $prefix->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTParentReference::CLAZZ, $reference);

        $postfix = $prefix->getChild(1);
        $this->assertType(PHP_Depend_Code_ASTMethodPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsContainsAllocationExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $allocation = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTAllocationExpression::CLAZZ, $allocation);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsWithSeveralParameters()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $postfix = $arguments->getFirstChildOfType(
            PHP_Depend_Code_ASTFunctionPostfix::CLAZZ
        );
        $this->assertType(PHP_Depend_Code_ASTFunctionPostfix::CLAZZ, $postfix);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsWithInlineComments()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $child = $arguments->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTVariable::CLAZZ, $child);
    }

    /**
     * Tests that the parser adds the expected childs to an argument instance.
     *
     * @return void
     */
    public function testArgumentsWithInlineConcatExpression()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $arguments = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTArguments::CLAZZ
        );

        $postfixes = $arguments->findChildrenOfType(
            PHP_Depend_Code_ASTMethodPostfix::CLAZZ
        );
        $this->assertSame(1, count($postfixes));
    }

    /**
     * Tests that an invalid arguments expression results in the expected
     * exception.
     *
     * @return void
     */
    public function testUnclosedArgumentsExpressionThrowsExpectedException()
    {
        $this->setExpectedException('PHP_Depend_Parser_TokenStreamEndException');

        self::parseTestCaseSource(__METHOD__);
    }

    /**
     * Creates a arguments node.
     *
     * @return PHP_Depend_Code_ASTArguments
     */
    protected function createNodeInstance()
    {
        return new PHP_Depend_Code_ASTArguments();
    }
}
