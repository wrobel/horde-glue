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
 * @subpackage Util
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    SVN: $Id$
 * @link       http://www.pdepend.org/
 */

/**
 * Utility class that can be used to detect simpl scalars or internal types.
 *
 * @category   PHP
 * @package    PHP_Depend
 * @subpackage Util
 * @author     Manuel Pichler <mapi@pdepend.org>
 * @copyright  2008-2009 Manuel Pichler. All rights reserved.
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    Release: 0.9.7
 * @link       http://www.pdepend.org/
 */
final class PHP_Depend_Util_Type
{
    /**
     * Constants for valid php data types.
     */
    const PHP_TYPE_ARRAY   = 'array',
          PHP_TYPE_BOOLEAN = 'boolean',
          PHP_TYPE_FLOAT   = 'float',
          PHP_TYPE_INTEGER = 'integer',
          PHP_TYPE_STRING  = 'string';
    /**
     * Constants with valid php data type identifiers.
     */         
    const IMAGE_ARRAY    = 'array',
          IMAGE_BOOL     = 'bool',
          IMAGE_BOOLEAN  = 'boolean',
          IMAGE_DOUBLE   = 'double',
          IMAGE_FLOAT    = 'float',
          IMAGE_INT      = 'int',
          IMAGE_INTEGER  = 'integer',
          IMAGE_MIXED    = 'mixed',
          IMAGE_REAL     = 'real',
          IMAGE_RESOURCE = 'resource',
          IMAGE_OBJECT   = 'object',
          IMAGE_STRING   = 'string',
          IMAGE_STDCLASS = 'stdclass',
          IMAGE_VOID     = 'void';

    /**
     * Constants with the metaphone representation of multiple php data types.
     */
    const IMAGE_METAPHONE_ARRAY        = 'AR',
          IMAGE_METAPHONE_BOOLEAN      = 'BLN',
          IMAGE_METAPHONE_DOUBLE       = 'TBL',
          IMAGE_METAPHONE_FLOAT        = 'FLT',
          IMAGE_METAPHONE_INTEGER      = 'INTJR',
          IMAGE_METAPHONE_MIXED        = 'MKST',
          IMAGE_METAPHONE_REAL         = 'RL',
          IMAGE_METAPHONE_RESOURCE     = 'RSRS',
          IMAGE_METAPHONE_OBJECT       = 'OBJKT',
          IMAGE_METAPHONE_STRING       = 'STRNK',
          IMAGE_METAPHONE_STDCLASS     = 'STTKLS',
          IMAGE_METAPHONE_UNKNOWN      = 'UNKNN',
          IMAGE_METAPHONE_UNKNOWN_TYPE = 'UNKNNTP';
 
    /**
     * Constants for other types/keywords frequently used.
     */
    const IMAGE_OTHER_NULL         = 'null',
          IMAGE_OTHER_FALSE        = 'false',
          IMAGE_OTHER_TRUE         = 'true',
          IMAGE_OTHER_UNKNOWN      = 'unknown',
          IMAGE_OTHER_UNKNOWN_TYPE = 'unknown_type';

    /**
     * This property contains a mapping between a unified lower case type name
     * and the corresponding PHP extension that declares this type.
     *
     * @var array(string=>string) $_typeNameToExtension
     */
    private static $_typeNameToExtension = null;

    /**
     * List of scalar php types.
     *
     * @var array(string) $_scalarTypes
     */
    private static $_scalarTypes = array(
        self::IMAGE_ARRAY                   =>  true,
        self::IMAGE_BOOL                    =>  true,
        self::IMAGE_BOOLEAN                 =>  true,
        self::IMAGE_DOUBLE                  =>  true,
        self::IMAGE_FLOAT                   =>  true,
        self::IMAGE_INT                     =>  true,
        self::IMAGE_INTEGER                 =>  true,
        self::IMAGE_MIXED                   =>  true,
        self::IMAGE_REAL                    =>  true,
        self::IMAGE_RESOURCE                =>  true,
        self::IMAGE_OBJECT                  =>  true,
        self::IMAGE_STRING                  =>  true,
        self::IMAGE_STDCLASS                =>  true,
        self::IMAGE_VOID                    =>  true,
        self::IMAGE_OTHER_NULL              =>  true,
        self::IMAGE_OTHER_FALSE             =>  true,
        self::IMAGE_OTHER_TRUE              =>  true,
        self::IMAGE_OTHER_UNKNOWN           =>  true,
        self::IMAGE_OTHER_UNKNOWN_TYPE      =>  true,
        self::IMAGE_METAPHONE_ARRAY         =>  true,
        self::IMAGE_METAPHONE_BOOLEAN       =>  true,
        self::IMAGE_METAPHONE_DOUBLE        =>  true,
        self::IMAGE_METAPHONE_FLOAT         =>  true,
        self::IMAGE_METAPHONE_INTEGER       =>  true,
        self::IMAGE_METAPHONE_MIXED         =>  true,
        self::IMAGE_METAPHONE_OBJECT        =>  true,
        self::IMAGE_METAPHONE_REAL          =>  true,
        self::IMAGE_METAPHONE_RESOURCE      =>  true,
        self::IMAGE_METAPHONE_STRING        =>  true,
        self::IMAGE_METAPHONE_STDCLASS      =>  true,
        self::IMAGE_METAPHONE_UNKNOWN       =>  true,
        self::IMAGE_METAPHONE_UNKNOWN_TYPE  =>  true,
    );

    /**
     * List of primitive php types.
     *
     * @var array(string=>string) $_primitiveTypes
     */
    private static $_primitiveTypes = array(
        self::IMAGE_BOOL               =>  self::PHP_TYPE_BOOLEAN,
        self::IMAGE_BOOLEAN            =>  self::PHP_TYPE_BOOLEAN,
        self::IMAGE_OTHER_FALSE        =>  self::PHP_TYPE_BOOLEAN,
        self::IMAGE_OTHER_TRUE         =>  self::PHP_TYPE_BOOLEAN,
        self::IMAGE_METAPHONE_BOOLEAN  =>  self::PHP_TYPE_BOOLEAN,
        self::IMAGE_REAL               =>  self::PHP_TYPE_FLOAT,
        self::IMAGE_FLOAT              =>  self::PHP_TYPE_FLOAT,
        self::IMAGE_DOUBLE             =>  self::PHP_TYPE_FLOAT,
        self::IMAGE_METAPHONE_REAL     =>  self::PHP_TYPE_FLOAT,
        self::IMAGE_METAPHONE_FLOAT    =>  self::PHP_TYPE_FLOAT,
        self::IMAGE_METAPHONE_DOUBLE   =>  self::PHP_TYPE_FLOAT,
        self::IMAGE_INT                =>  self::PHP_TYPE_INTEGER,
        self::IMAGE_INTEGER            =>  self::PHP_TYPE_INTEGER,
        self::IMAGE_METAPHONE_INTEGER  =>  self::PHP_TYPE_INTEGER,
        self::IMAGE_STRING             =>  self::PHP_TYPE_STRING,
        self::IMAGE_METAPHONE_STRING   =>  self::PHP_TYPE_STRING,
    );

    /**
     * Returns <b>true</b> if the given type is internal or part of an
     * extension.
     *
     * @param string $typeName The type name.
     *
     * @return boolean
     */
    public static function isInternalType($typeName)
    {
        self::_initTypeToExtension();

        return isset(self::$_typeNameToExtension[strtolower($typeName)]);
    }

    /**
     * Returns the package/extension for the given type name. If no package
     * exists, this method will return <b>null</b>.
     *
     * @param string $typeName The type name.
     *
     * @return string
     */
    public static function getTypePackage($typeName)
    {
        self::_initTypeToExtension();

        $typeName = strtolower($typeName);
        if (isset(self::$_typeNameToExtension[$typeName])) {
            return self::$_typeNameToExtension[$typeName];
        }
        return null;
    }

    /**
     * Returns an array with all package/extension names.
     *
     * @return array(string)
     */
    public static function getInternalPackages()
    {
        self::_initTypeToExtension();

        return array_unique(array_values(self::$_typeNameToExtension));
    }

    /**
     * This method will return <b>true</b> when the given package represents a
     * php extension.
     *
     * @param string $packageName Name of a package.
     *
     * @return boolean
     */
    public static function isInternalPackage($packageName)
    {
        $packageName = strtolower($packageName);
        return in_array($packageName, self::getInternalPackages());
    }

    /**
     * This method will return <b>true</b> when the given type identifier is in
     * the list of scalar/none-object types.
     *
     * @param string $scalarType The type identifier.
     *
     * @return boolean
     */
    public static function isScalarType($scalarType)
    {
        $image = strtolower($scalarType);
        if (isset(self::$_scalarTypes[$image]) === false) {
            return isset(self::$_scalarTypes[metaphone($image)]);
        }
        return true;
    }

    /**
     * This method will return <b>true</b> when the given type identifier is in
     * the list of primitive types.
     *
     * @param string $image The type image.
     *
     * @return boolean
     * @since 0.9.6
     */
    public static function isPrimitiveType($image)
    {
        return (self::getPrimitiveType($image) !== null);
    }

    /**
     * This method will return a unified type image for a detected source type
     * image.
     *
     * @param string $image The found primitive type image.
     *
     * @return string
     * @since 0.9.6
     */
    public static function getPrimitiveType($image)
    {
        $image = strtolower($image);
        if (isset(self::$_primitiveTypes[$image]) === true) {
            return self::$_primitiveTypes[$image];
        }
        $image = metaphone($image);
        if (isset(self::$_primitiveTypes[$image]) === true) {
            return self::$_primitiveTypes[$image];
        }
        return null;
    }

    /**
     * This method will return <b>true</b> when the given image describes a
     * php array type.
     *
     * @param string $image The found type image.
     *
     * @return boolean
     * @since 0.9.6
     */
    public static function isArrayType($image)
    {
        return (strtolower($image) === 'array');
    }

    /**
     * This method reads all available classes and interfaces and checks whether
     * this type belongs to an extension or is internal. All internal and extension
     * classes are collected in an internal data structure.
     *
     * @return void
     */
    private static function _initTypeToExtension()
    {
        // Skip when already done.
        if (self::$_typeNameToExtension !== null) {
            return;
        }

        self::$_typeNameToExtension = array();

        // Collect all available classes and interfaces
        $typeNames = array_merge(get_declared_classes(), get_declared_interfaces());

        foreach ($typeNames as $typeName) {
            $reflection = new ReflectionClass($typeName);
            if ($reflection->isInternal() === false) {
                continue;
            }
            $extensionName = strtolower($reflection->getExtensionName());
            $extensionName = ($extensionName === '' ? 'standard' : $extensionName);
            $extensionName = '+' . $extensionName;

            self::$_typeNameToExtension[strtolower($typeName)] = $extensionName;
        }
    }
}
?>
