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

require_once 'PHP/Depend/Code/ASTAllocationExpression.php';

/**
 * Test case for the {@link PHP_Depend_Code_ASTAllocationExpression} class.
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
class PHP_Depend_Code_ASTAllocationExpressionTest extends PHP_Depend_Code_ASTNodeTest
{
    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForSimpleIdentifier()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $allocation = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $reference = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassReference::CLAZZ, $reference);
        $this->assertSame('Foo', $reference->getType()->getName());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForSelfKeyword()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $method = $packages->current()
            ->getClasses()
            ->current()
            ->getMethods()
            ->current();

        $allocation = $method->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $self = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTSelfReference::CLAZZ, $self);
        $this->assertSame(__FUNCTION__, $self->getType()->getName());
    }


    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForParentKeyword()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $method = $packages->current()
            ->getClasses()
            ->current()
            ->getMethods()
            ->current();

        $allocation = $method->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $parent = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTParentReference::CLAZZ, $parent);
        $this->assertSame(__FUNCTION__ . 'Parent', $parent->getType()->getName());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForLocalNamespaceIdentifier()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $allocation = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $reference = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassReference::CLAZZ, $reference);
        $this->assertSame('Bar', $reference->getType()->getName());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForAbsoluteNamespaceIdentifier()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $allocation = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $reference = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassReference::CLAZZ, $reference);
        $this->assertSame('Bar', $reference->getType()->getName());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForAbsoluteNamespacedNamespaceIdentifier()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $allocation = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $reference = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassReference::CLAZZ, $reference);
        $this->assertSame('Foo', $reference->getType()->getName());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForVariableIdentifier()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $allocation = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $variable = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTVariable::CLAZZ, $variable);
        $this->assertSame('$foo', $variable->getImage());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForVariableVariableIdentifier()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $function = $packages->current()
            ->getFunctions()
            ->current();

        $allocation = $function->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $vvariable = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTVariableVariable::CLAZZ, $vvariable);
        $this->assertSame('$', $vvariable->getImage());

        $variable = $vvariable->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTVariable::CLAZZ, $variable);
        $this->assertSame('$foo', $variable->getImage());
    }

    /**
     * Tests that the allocation object graph contains the expected objects
     *
     * @return void
     * @group ast
     */
    public function testAllocationExpressionGraphForStaticReference()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $method   = $packages->current()
            ->getClasses()
            ->current()
            ->getMethods()
            ->current();

        $allocation = $method->getFirstChildOfType(
            PHP_Depend_Code_ASTAllocationExpression::CLAZZ
        );

        $reference = $allocation->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTStaticReference::CLAZZ, $reference);
        $this->assertSame(__FUNCTION__, $reference->getType()->getName());
    }

    /**
     * Tests that invalid allocation expression results in the expected 
     * exception.
     * 
     * @return void
     * @group ast
     */
    public function testInvalidAllocationExpressionResultsInExpectedException()
    {
        $this->setExpectedException(
            'PHP_Depend_Parser_UnexpectedTokenException',
            'Unexpected token: ;, line: 4, col: 9, file: '
        );
        self::parseTestCaseSource(__METHOD__);
    }

    /**
     * Creates a arguments node.
     *
     * @return PHP_Depend_Code_ASTAllocationExpression
     */
    protected function createNodeInstance()
    {
        return new PHP_Depend_Code_ASTAllocationExpression();
    }
}