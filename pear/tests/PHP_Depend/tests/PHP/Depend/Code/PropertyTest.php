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

require_once dirname(__FILE__) . '/../AbstractTest.php';

require_once 'PHP/Depend/Code/Class.php';
require_once 'PHP/Depend/Code/Property.php';

/**
 * Test case for the code property class.
 *
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@pdepend.org>
 * @copyright 2008-2009 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.7
 * @link      http://pdepend.org/
 */
class PHP_Depend_Code_PropertyTest extends PHP_Depend_AbstractTest
{
    /**
     * Tests that the <b>isDefaultValueAvailable()</b> method returns the
     * expected result.
     *
     * @return void
     */
    public function testPropertyIsDefaultValueAvailableReturnsFalseWhenNoValueExists()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertFalse($property->isDefaultValueAvailable());
        $this->assertNull($property->getDefaultValue());
    }

    /**
     * Tests that the <b>isDefaultValueAvailable()</b> method returns the
     * expected result.
     *
     * @return void
     */
    public function testPropertyIsDefaultValueAvailableReturnsTrueWhenValueExists()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertTrue($property->isDefaultValueAvailable());
        $this->assertNull($property->getDefaultValue());
    }

    /**
     * Tests that the property default value matches the expected PHP type.
     *
     * @return void
     */
    public function testPropertyContainsExpectDefaultValueBooleanTrue()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertTrue($property->getDefaultValue());
    }

    /**
     * Tests that the property default value matches the expected PHP type.
     *
     * @return void
     */
    public function testPropertyContainsExpectDefaultValueBooleanFalse()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertFalse($property->getDefaultValue());
    }

    /**
     * Tests that the property default value matches the expected PHP type.
     *
     * @return void
     */
    public function testPropertyContainsExpectDefaultValueArray()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertType('array', $property->getDefaultValue());
    }

    /**
     * Tests that the property default value matches the expected PHP type.
     *
     * @return void
     */
    public function testPropertyContainsExpectedDefaultValueFloat()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertEquals(3.14, $property->getDefaultValue(), '', 0.001);
    }

    /**
     * Tests that the {@link PHP_Depend_Code_Property::isArray()} method returns
     * <b>true</b> for an as array annotated property.
     *
     * @return void
     */
    public function testIsArrayReturnsExpectedValueTrueForVarAnnotationWithArray()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertTrue($property->isArray());
    }

    /**
     * Tests that the {@link PHP_Depend_Code_Property::isArray()} method returns
     * <b>false</b> for an as class/interface annotated property.
     *
     * @return void
     */
    public function testIsArrayReturnsExpectedValueFalseForVarAnnotationWithClassType()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertFalse($property->isArray());
    }

    /**
     * Tests that the {@link PHP_Depend_Code_Property::isArray()} method returns
     * <b>false</b> for an property without var annotation.
     *
     * @return void
     */
    public function testIsArrayReturnsExpectedValueFalseForPropertyWithoutVarAnnotation()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertFalse($property->isArray());
    }

    /**
     * Tests that the {@link PHP_Depend_Code_Property::isPrimitive()} method
     * returns <b>true</b> for an as integer annotated property.
     *
     * @return void
     */
    public function testIsPrimitiveReturnsExpectedValueTrueForVarAnnotationWithIntegerTypeHint()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertTrue($property->isPrimitive());
    }

    /**
     * Tests that the {@link PHP_Depend_Code_Property::isPrimitive()} method
     * returns <b>false</b> for an as class/interface annotated property.
     *
     * @return void
     */
    public function testIsPrimitiveReturnsExpectedValueFalseForVarAnnotationWithClassType()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertFalse($property->isPrimitive());
    }

    /**
     * Tests that the {@link PHP_Depend_Code_Property::isPrimitive()} method
     * returns <b>false</b> for an property without var annotation.
     *
     * @return void
     */
    public function testIsPrimitiveReturnsExpectedValueFalseForPropertyWithoutVarAnnotation()
    {
        $packages = self::parseSource('code/property/' . __FUNCTION__ . '.php');
        $property = $packages->current()
            ->getClasses()
            ->current()
            ->getProperties()
            ->current();

        $this->assertFalse($property->isPrimitive());
    }
}