<?php
/**
 * This file is part of PHP_PMD.
 *
 * PHP Version 5
 *
 * Copyright (c) 2009, Manuel Pichler <mapi@pdepend.org>.
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
 * @package    PHP_PMD
 * @subpackage Node
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/pmd
 */

require_once 'PHP/PMD/Node/AbstractMethodOrFunction.php';

/**
 * Wrapper around a PHP_Depend method node.
 *
 * @category   PHP
 * @package    PHP_PMD
 * @subpackage Node
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: @package_version@
 * @link       http://www.pdepend.org/pmd
 */
class PHP_PMD_Node_Method extends PHP_PMD_Node_AbstractMethodOrFunction
{
    /**
     * The wrapped method instance.
     *
     * @var PHP_Depend_Code_Method $_method
     */
    private $_method = null;

    /**
     * Constructs a new method wrapper.
     *
     * @param PHP_Depend_Code_Method $node The wrapped method object.
     */
    public function __construct(PHP_Depend_Code_Method $node)
    {
        parent::__construct($node);

        $this->_method = $node;
    }

    /**
     * Returns the name of the parent package.
     *
     * @return string
     */
    public function getPackageName()
    {
        return $this->_method->getParent()->getPackage()->getName();
    }

    /**
     * Returns the name of the parent type or <b>null</b> when this node has no
     * parent type.
     *
     * @return string
     */
    public function getParentName()
    {
        return $this->_method->getParent()->getName();
    }
}
?>
