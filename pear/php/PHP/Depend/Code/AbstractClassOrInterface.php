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
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://pdepend.org/
 */

require_once 'PHP/Depend/Code/AbstractType.php';
require_once 'PHP/Depend/Util/UUID.php';

/**
 * Represents an interface or a class type.
 *
 * @category   QualityAssurance
 * @package    PHP_Depend
 * @subpackage Code
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.7
 * @link       http://pdepend.org/
 */
abstract class PHP_Depend_Code_AbstractClassOrInterface
    extends PHP_Depend_Code_AbstractType
{
    /**
     * List of {@link PHP_Depend_Code_AbstractClassOrInterface} objects this
     * type depends on.
     *
     * @var array(PHP_Depend_Code_AbstractClassOrInterface) $_dependencies
     */
    private $_dependencies = array();

    /**
     * The parent for this class node.
     *
     * @var PHP_Depend_Code_ASTClassReference $_parentClassReference
     * @since 0.9.5
     */
    private $_parentClassReference = null;

    /**
     * List of all interfaces implemented/extended by the this type.
     *
     * @var array(PHP_Depend_Code_ASTInterfaceReference) $_interfaceReferences
     */
    private $_interfaceReferences = array();

    /**
     * The parent package for this class.
     *
     * @var PHP_Depend_Code_Package $_package
     */
    private $_package = null;

    /**
     * List of {@link PHP_Depend_Code_Method} objects in this class.
     *
     * @var array(PHP_Depend_Code_Method) $_methods
     */
    private $_methods = array();

    /**
     * An <b>array</b> with all constants defined in this class or interface.
     *
     * @var array(string=>mixed) $_constants
     */
    private $_constants = null;

    /**
     * This property will indicate that the class or interface is user defined.
     * The parser marks all classes and interfaces as user defined that have a
     * source file and were part of parsing process.
     *
     * @var boolean $_userDefined
     * @since 0.9.5
     */
    private $_userDefined = false;

    /**
     * List of all parsed child nodes.
     *
     * @var array(PHP_Depend_Code_ASTNodeI) $_nodes
     * @since 0.9.6
     */
    private $_nodes = array();

    /**
     * Adds a parsed child node to this node.
     *
     * @param PHP_Depend_Code_ASTNodeI $node A parsed child node instance.
     *
     * @return void
     * @access private
     * @since 0.9.6
     */
    public function addChild(PHP_Depend_Code_ASTNodeI $node)
    {
        $this->_nodes[] = $node;
    }

    /**
     * This method will search recursive for the first child node that is an
     * instance of the given <b>$targetType</b>. The returned value will be
     * <b>null</b> if no child exists for that.
     *
     * @param string $targetType Searched class or interface type.
     *
     * @return PHP_Depend_Code_ASTNodeI
     * @access private
     * @since 0.9.6
     */
    public function getFirstChildOfType($targetType)
    {
        foreach ($this->_nodes as $node) {
            if ($node instanceof $targetType) {
                return $node;
            }
            if (($child = $node->getFirstChildOfType($targetType)) !== null) {
                return $child;
            }
        }
        return null;
    }

    /**
     * Will find all children for the given type.
     *
     * @param string $targetType The target class or interface type.
     * @param array  &$results   The found children.
     *
     * @return array(PHP_Depend_Code_ASTNodeI)
     * @access private
     * @since 0.9.6
     */
    public function findChildrenOfType($targetType, array &$results = array())
    {
        foreach ($this->_nodes as $node) {
            if ($node instanceof $targetType) {
                $results[] = $node;
            }
            $node->findChildrenOfType($targetType, $results);
        }
        return $results;
    }

    /**
     * This method will return <b>true</b> when this type has a declaration in
     * the analyzed source files.
     *
     * @return boolean
     * @since 0.9.5
     */
    public function isUserDefined()
    {
        return $this->_userDefined;
    }

    /**
     * This method can be used to mark a type as user defined. User defined
     * means that the type has a valid declaration in the analyzed source files.
     *
     * @return void
     * @since 0.9.5
     */
    public function setUserDefined()
    {
        $this->_userDefined = true;
    }

    /**
     * Returns the parent class or <b>null</b> if this class has no parent.
     *
     * @return PHP_Depend_Code_Class
     */
    public function getParentClass()
    {
        // No parent? Stop here!
        if ($this->_parentClassReference === null) {
            return null;
        }

        $parentClass = $this->_parentClassReference->getType();

        // Check parent against global filter
        $collection = PHP_Depend_Code_Filter_Collection::getInstance();
        if ($collection->accept($parentClass) === false) {
            return null;
        }

        // Parent is valid, so return
        return $parentClass;
    }

    /**
     * Returns a reference onto the parent class of this class node or <b>null</b>.
     *
     * @return PHP_Depend_Code_ASTClassReference
     * @since 0.9.5
     */
    public function getParentClassReference()
    {
        return $this->_parentClassReference;
    }

    /**
     * Sets a reference onto the parent class of this class node.
     *
     * @param PHP_Depend_Code_ASTClassReference $classReference Reference to the
     *        declared parent class.
     *
     * @return void
     * @since 0.9.5
     */
    public function setParentClassReference(
        PHP_Depend_Code_ASTClassReference $classReference
    ) {
        $this->_parentClassReference = $classReference;
    }

    /**
     * Returns a node iterator with all implemented interfaces.
     *
     * @return PHP_Depend_Code_NodeIterator
     * @since 0.9.5
     */
    public function getInterfaces()
    {
        $interfaces = array();
        foreach ($this->_interfaceReferences as $interfaceReference) {
            $interface = $interfaceReference->getType();
            if (in_array($interface, $interfaces, true) === true) {
                continue;
            }
            $interfaces[] = $interface;
            foreach ($interface->getInterfaces() as $parentInterface) {
                if (in_array($parentInterface, $interfaces, true) === false) {
                    $interfaces[] = $parentInterface;
                }
            }
        }

        if ($this->_parentClassReference === null) {
            return new PHP_Depend_Code_NodeIterator($interfaces);
        }

        $parentClass = $this->_parentClassReference->getType();
        foreach ($parentClass->getInterfaces() as $interface) {
            $interfaces[] = $interface;
        }
        return new PHP_Depend_Code_NodeIterator($interfaces);
    }

    /**
     * Adds a interface reference node.
     *
     * @param PHP_Depend_Code_ASTInterfaceReference $interfaceReference The extended
     *        or implemented interface reference.
     *
     * @return void
     * @since 0.9.5
     */
    public function addInterfaceReference(
        PHP_Depend_Code_ASTInterfaceReference $interfaceReference
    ) {
        $this->_interfaceReferences[] = $interfaceReference;
    }

    /**
     * Returns an <b>array</b> with all constants defined in this class or
     * interface.
     *
     * @return array(string=>mixed)
     */
    public function getConstants()
    {
        if ($this->_constants === null) {
            $this->_initConstants();
        }
        return $this->_constants;
    }

    /**
     * This method returns <b>true</b> when a constant for <b>$name</b> exists,
     * otherwise it returns <b>false</b>.
     *
     * @param string $name Name of the searched constant.
     *
     * @return boolean
     * @since 0.9.6
     */
    public function hasConstant($name)
    {
        if ($this->_constants === null) {
            $this->_initConstants();
        }
        return array_key_exists($name, $this->_constants);
    }

    /**
     * This method will return the value of a constant for <b>$name</b> or it
     * will return <b>false</b> when no constant for that name exists.
     *
     * @param string $name Name of the searched constant.
     *
     * @return mixed
     * @since 0.9.6
     */
    public function getConstant($name)
    {
        if ($this->hasConstant($name) === true) {
            return $this->_constants[$name];
        }
        return false;
    }

    /**
     * Returns all {@link PHP_Depend_Code_Method} objects in this type.
     *
     * @return PHP_Depend_Code_NodeIterator
     */
    public function getMethods()
    {
        return new PHP_Depend_Code_NodeIterator($this->_methods);
    }

    /**
     * Adds the given method to this type.
     *
     * @param PHP_Depend_Code_Method $method A new type method.
     *
     * @return PHP_Depend_Code_Method
     */
    public function addMethod(PHP_Depend_Code_Method $method)
    {
        if ($method->getParent() !== null) {
            $method->getParent()->removeMethod($method);
        }
        // Set this as owner type
        $method->setParent($this);
        // Store method
        $this->_methods[] = $method;

        return $method;
    }

    /**
     * Removes the given method from this class.
     *
     * @param PHP_Depend_Code_Method $method The method to remove.
     *
     * @return void
     */
    public function removeMethod(PHP_Depend_Code_Method $method)
    {
        if (($i = array_search($method, $this->_methods, true)) !== false) {
            // Remove this as owner
            $method->setParent(null);
            // Remove from internal list
            unset($this->_methods[$i]);
        }
    }

    /**
     * Returns all {@link PHP_Depend_Code_AbstractClassOrInterface} objects this
     * type depends on.
     *
     * @return PHP_Depend_Code_NodeIterator
     */
    public function getDependencies()
    {
        $references = $this->_interfaceReferences;
        if ($this->_parentClassReference !== null) {
            $references[] = $this->_parentClassReference;
        }

        return new PHP_Depend_Code_ClassOrInterfaceReferenceIterator($references);
    }

    /**
     * Returns an <b>array</b> with all tokens within this type.
     *
     * @return array(PHP_Depend_Token)
     */
    public function getTokens()
    {
        $storage = PHP_Depend_StorageRegistry::get(PHP_Depend::TOKEN_STORAGE);
        return (array) $storage->restore($this->getUUID(), get_class($this));
    }

    /**
     * Sets the tokens for this type.
     *
     * @param array(PHP_Depend_Token) $tokens The generated tokens.
     *
     * @return void
     */
    public function setTokens(array $tokens)
    {
        $storage = PHP_Depend_StorageRegistry::get(PHP_Depend::TOKEN_STORAGE);
        $storage->store($tokens, $this->getUUID(), get_class($this));
    }

    /**
     * Returns the line number where the class or interface declaration starts.
     *
     * @return integer
     * @since 0.9.6
     */
    public function getStartLine()
    {
        $tokens = $this->getTokens();
        if (isset($tokens[0]) === false) {
            return 0;
        }
        return reset($tokens)->startLine;
    }

    /**
     * Returns the line number where the class or interface declaration ends.
     *
     * @return integer
     * @since 0.9.6
     */
    public function getEndLine()
    {
        $tokens = $this->getTokens();
        if (isset($tokens[0]) === false) {
            return 0;
        }
        return end($tokens)->endLine;
    }

    /**
     * Returns the parent package for this class.
     *
     * @return PHP_Depend_Code_Package
     */
    public function getPackage()
    {
        return $this->_package;
    }

    /**
     * Sets the parent package for this class.
     *
     * @param PHP_Depend_Code_Package $package The parent package.
     *
     * @return void
     */
    public function setPackage(PHP_Depend_Code_Package $package = null)
    {
        $this->_package = $package;
    }

    /**
     * Returns <b>true</b> if this is an abstract class or an interface.
     *
     * @return boolean
     */
    public abstract function isAbstract();

    /**
     * Checks that this user type is a subtype of the given <b>$type</b>
     * instance.
     *
     * @param PHP_Depend_Code_AbstractClassOrInterface $type The possible parent
     *        type instance.
     *
     * @return boolean
     */
    public abstract function isSubtypeOf(
        PHP_Depend_Code_AbstractClassOrInterface $type
    );

    /**
     * Returns the declared modifiers for this type.
     *
     * @return integer
     */
    public abstract function getModifiers();

    /**
     * This method initializes the constants defined in this class or interface.
     *
     * @return void
     * @since 0.9.6
     */
    private function _initConstants()
    {
        $this->_constants = array();
        if (($parentClass = $this->getParentClass()) !== null) {
            $this->_constants = $parentClass->getConstants();
        }

        foreach ($this->getInterfaces() as $interface) {
            $this->_constants = array_merge(
                $this->_constants,
                $interface->getConstants()
            );
        }

        $definitions = $this->findChildrenOfType(
            PHP_Depend_Code_ASTConstantDefinition::CLAZZ
        );

        foreach ($definitions as $definition) {
            $declarators = $definition->findChildrenOfType(
                PHP_Depend_Code_ASTConstantDeclarator::CLAZZ
            );

            foreach ($declarators as $declarator) {
                $image = $declarator->getImage();
                $value = $declarator->getValue()->getValue();

                $this->_constants[$image] = $value;
            }
        }
        //$this->_constants = new PHP_Depend_Code_NodeIterator($constants);
    }

    // DEPRECATED METHODS AND PROPERTIES
    // @codeCoverageIgnoreStart

    /**
     * Sets the start line for this item.
     *
     * @param integer $startLine The start line for this item.
     *
     * @return void
     * @deprecated Since version 0.9.6
     */
    public function setStartLine($startLine)
    {
        fwrite(STDERR, 'Since 0.9.6 ' . __METHOD__ . '() is deprecated.' . PHP_EOL);
        $this->startLine = $startLine;
    }

    /**
     * Sets the end line for this item.
     *
     * @param integer $endLine The end line for this item
     *
     * @return void
     * @deprecated Since version 0.9.6
     */
    public function setEndLine($endLine)
    {
        fwrite(STDERR, 'Since 0.9.6 ' . __METHOD__ . '() is deprecated.' . PHP_EOL);
        $this->endLine = $endLine;
    }

    /**
     * Adds the given {@link PHP_Depend_Code_AbstractClassOrInterface} object as
     * dependency.
     *
     * @param PHP_Depend_Code_AbstractClassOrInterface $type A type this
     *        function depends on.
     *
     * @return void
     * @deprecated Since version 0.9.5, use addParentClassReference() and
     *             addInterfaceReference() instead.
     */
    public function addDependency(PHP_Depend_Code_AbstractClassOrInterface $type)
    {
        fwrite(STDERR, 'Since 0.9.5 ' . __METHOD__ . '() is deprecated.' . PHP_EOL);
        if (array_search($type, $this->_dependencies, true) === false) {
            // Store type dependency
            $this->_dependencies[] = $type;
        }
    }

    /**
     * Removes the given {@link PHP_Depend_Code_AbstractClassOrInterface} object
     * from the dependency list.
     *
     * @param PHP_Depend_Code_AbstractClassOrInterface $type A type to remove.
     *
     * @return void
     * @deprecated Since version 0.9.5
     */
    public function removeDependency(PHP_Depend_Code_AbstractClassOrInterface $type)
    {
        fwrite(STDERR, 'Since 0.9.5 ' . __METHOD__ . '() is deprecated.' . PHP_EOL);
        if (($i = array_search($type, $this->_dependencies, true)) !== false) {
            // Remove from internal list
            unset($this->_dependencies[$i]);
        }
    }

    /**
     * Returns an unfiltered, raw array of
     * {@link PHP_Depend_Code_AbstractClassOrInterface} objects this type
     * depends on. This method is only for internal usage.
     *
     * @return array(PHP_Depend_Code_AbstractClassOrInterface)
     * @access private
     */
    public function getUnfilteredRawDependencies()
    {
        fwrite(STDERR, 'Since 0.9.5 ' . __METHOD__ . '() is deprecated.' . PHP_EOL);
        $dependencies = $this->_dependencies;
        foreach ($this->_interfaceReferences as $interfaceReference) {
            $interface = $interfaceReference->getType();
            if (in_array($interface, $dependencies, true) === false) {
                $dependencies[] = $interface;
            }
        }

        // No parent? Then use the parent implementation
        if ($this->getParentClass() === null) {
            return $dependencies;
        }

        $dependencies[] = $this->getParentClass();

        return $dependencies;
    }
    
    // @codeCoverageIgnoreEnd
    
}