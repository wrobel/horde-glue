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

require_once 'PHP/Depend/Code/ASTFieldDeclaration.php';
require_once 'PHP/Depend/ConstantsI.php';

/**
 * Test case for the {@link PHP_Depend_Code_ASTFieldDeclaration} class.
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
class PHP_Depend_Code_ASTFieldDeclarationTest extends PHP_Depend_Code_ASTNodeTest
{
    /**
     * Tests that a field declaration contains the expected class reference.
     * 
     * @return void
     */
    public function testFieldDeclarationContainsClassReferenceWithAnnotationsEnabled()
    {
        $packages = self::parseTestCaseSource(__METHOD__, false);

        $class = $packages->current()
            ->getClasses()
            ->current();

        $declaration = $class->getFirstChildOfType(
            PHP_Depend_Code_ASTFieldDeclaration::CLAZZ
        );

        $reference = $declaration->getChild(0);
        $this->assertType(PHP_Depend_Code_ASTClassOrInterfaceReference::CLAZZ, $reference);
        $this->assertSame(__FUNCTION__, $reference->getType()->getName());
    }

    /**
     * Tests that a field declaration does not contain a class reference.
     *
     * @return void
     */
    public function testFieldDeclarationNotContainsClassReferenceWithAnnotationsDisabled()
    {
        $packages = self::parseTestCaseSource(__METHOD__, true);

        $class = $packages->current()
            ->getClasses()
            ->current();

        $declaration = $class->getFirstChildOfType(
            PHP_Depend_Code_ASTFieldDeclaration::CLAZZ
        );
        $reference = $declaration->getFirstChildOfType(
            PHP_Depend_Code_ASTClassOrInterfaceReference::CLAZZ
        );
        $this->assertNull($reference);
    }

    /**
     * Tests that the field declaration <b>setModifiers()</b> method accepts all
     * valid combinations of modifiers.
     *
     * @param integer $modifiers Combinations of valid modifiers.
     *
     * @return void
     * @dataProvider dataProviderSetModifiersAcceptsExpectedModifierCombinations
     */
    public function testSetModifiersAcceptsExpectedModifierCombinations($modifiers)
    {
        $declaration = new PHP_Depend_Code_ASTFieldDeclaration();
        $declaration->setModifiers($modifiers);
        $this->assertSame($modifiers, $declaration->getModifiers());
    }

    /**
     * Tests that the <b>setModifiers()</b> method throws an exception when an
     * invalid modifier or modifier combination was set.
     *
     * @param integer $modifiers Combinations of invalid modifiers.
     *
     * @return void
     * @dataProvider dataProviderSetModifiersThrowsExpectedExceptionForInvalidModifiers
     */
    public function testSetModifiersThrowsExpectedExceptionForInvalidModifiers($modifiers)
    {
        $declaration = new PHP_Depend_Code_ASTFieldDeclaration();

        $this->setExpectedException(
            'InvalidArgumentException',
            'Invalid field modifiers given, allowed modifiers are ' .
            'IS_PUBLIC, IS_PROTECTED, IS_PRIVATE and IS_STATIC.'
        );

        $declaration->setModifiers($modifiers);
    }

    /**
     * Creates a field declaration node.
     *
     * @return PHP_Depend_Code_ASTFieldDeclaration
     */
    protected function createNodeInstance()
    {
        return new PHP_Depend_Code_ASTFieldDeclaration();
    }

    /**
     * Returns valid field declation modifiers.
     *
     * @return array
     */
    public static function dataProviderSetModifiersAcceptsExpectedModifierCombinations()
    {
        return array(
            array(PHP_Depend_ConstantsI::IS_PRIVATE),
            array(PHP_Depend_ConstantsI::IS_PROTECTED),
            array(PHP_Depend_ConstantsI::IS_PUBLIC),
            array(
                PHP_Depend_ConstantsI::IS_PRIVATE |
                PHP_Depend_ConstantsI::IS_STATIC
            ),
            array(
                PHP_Depend_ConstantsI::IS_PROTECTED |
                PHP_Depend_ConstantsI::IS_STATIC
            ),
            array(
                PHP_Depend_ConstantsI::IS_PUBLIC |
                PHP_Depend_ConstantsI::IS_STATIC
            ),
        );
    }

    /**
     * Returns invalid field declation modifiers.
     *
     * @return array
     */
    public static function dataProviderSetModifiersThrowsExpectedExceptionForInvalidModifiers()
    {
        return array(
            array(PHP_Depend_ConstantsI::IS_ABSTRACT),
            array(PHP_Depend_ConstantsI::IS_FINAL),
            array(
                PHP_Depend_ConstantsI::IS_PRIVATE |
                PHP_Depend_ConstantsI::IS_ABSTRACT
            ),
            array(
                PHP_Depend_ConstantsI::IS_PROTECTED |
                PHP_Depend_ConstantsI::IS_ABSTRACT
            ),
            array(
                PHP_Depend_ConstantsI::IS_PUBLIC |
                PHP_Depend_ConstantsI::IS_FINAL
            ),
            array(
                PHP_Depend_ConstantsI::IS_PUBLIC |
                PHP_Depend_ConstantsI::IS_STATIC |
                PHP_Depend_ConstantsI::IS_FINAL
            ),
        );
    }
}
?>
