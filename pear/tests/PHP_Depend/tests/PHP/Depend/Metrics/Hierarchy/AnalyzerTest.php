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

require_once dirname(__FILE__) . '/../../AbstractTest.php';

require_once 'PHP/Depend/Code/Class.php';
require_once 'PHP/Depend/Code/Package.php';
require_once 'PHP/Depend/Code/NodeIterator.php';
require_once 'PHP/Depend/Metrics/Hierarchy/Analyzer.php';
require_once 'PHP/Depend/Util/UUID.php';

/**
 * Test case for the hierarchy analyzer.
 *
 * @category  QualityAssurance
 * @package   PHP_Depend
 * @author    Manuel Pichler <mapi@pdepend.org>
 * @copyright 2008-2009 Manuel Pichler. All rights reserved.
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 0.9.7
 * @link      http://pdepend.org/
 */
class PHP_Depend_Metrics_Hierarchy_AnalyzerTest extends PHP_Depend_AbstractTest
{
    /**
     * Tests that the {@link PHP_Depend_Metrics_Hierarchy_Analyzer::analyze()}
     * method creates the expected hierarchy metrics.
     *
     * @return void.
     */
    public function testAnalyzeProjectMetrics()
    {
        $packages = self::parseTestCaseSource(__METHOD__);

        $analyzer = new PHP_Depend_Metrics_Hierarchy_Analyzer();
        $analyzer->analyze($packages);

        $project = $analyzer->getProjectMetrics();

        $this->assertEquals(1, $project['clsa']);
        $this->assertEquals(2, $project['clsc']);
        $this->assertEquals(1, $project['roots']);
        $this->assertEquals(2, $project['leafs']);
        $this->assertEquals(1, $project['maxDIT']);
    }

    /**
     * Tests that {@link PHP_Depend_Metrics_Hierarchy_Analyzer::analyze()} calculates
     * the expected DIT values.
     *
     * @return void
     */
    public function testGetNodeMetrics()
    {
        $packages = self::parseTestCaseSource(__METHOD__);
        $package  = $packages->current();

        $analyzer = new PHP_Depend_Metrics_Hierarchy_Analyzer();
        $analyzer->analyze($packages);

        $expected = array(
            'A' => array('dit'  =>  0),
            'B' => array('dit'  =>  1),
            'C' => array('dit'  =>  1),
            'D' => array('dit'  =>  2),
            'E' => array('dit'  =>  3),
        );

        $this->assertSame(count($expected), $package->getClasses()->count());
        foreach ($package->getClasses() as $class) {
            $this->assertArrayHasKey($class->getName(), $expected);
            $this->assertSame(
                $expected[$class->getName()],
                $analyzer->getNodeMetrics($class)
            );
        }
    }

    /**
     * Tests that {@link PHP_Depend_Metrics_Hierarchy_Analyzer::getNodeMetrics()}
     * returns an empty <b>array</b> for an unknown node uuid.
     *
     * @return void
     */
    public function testGetNodeMetricsForUnknownUUID()
    {
        $class    = new PHP_Depend_Code_Class('PDepend');
        $analyzer = new PHP_Depend_Metrics_Hierarchy_Analyzer();
        $metrics  = $analyzer->getNodeMetrics($class);

        $this->assertType('array', $metrics);
        $this->assertEquals(0, count($metrics));

    }
}