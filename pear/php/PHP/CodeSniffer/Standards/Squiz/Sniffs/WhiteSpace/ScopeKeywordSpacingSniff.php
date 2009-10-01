<?php
/**
 * Squiz_Sniffs_WhiteSpace_ScopeKeywordSpacingSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: ScopeKeywordSpacingSniff.php 244265 2007-10-16 01:29:10Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Squiz_Sniffs_WhiteSpace_ScopeKeywordSpacingSniff.
 *
 * Ensure there is a single space after scope keywords.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @author    Marc McIntyre <mmcintyre@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.2.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class Squiz_Sniffs_WhiteSpace_ScopeKeywordSpacingSniff implements PHP_CodeSniffer_Sniff
{


    /**
     * Returns an array of tokens this test wants to listen for.
     *
     * @return array
     */
    public function register()
    {
        $register   = PHP_CodeSniffer_Tokens::$scopeModifiers;
        $register[] = T_STATIC;
        return $register;

    }//end register()


    /**
     * Processes this test, when one of its tokens is encountered.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file being scanned.
     * @param int                  $stackPtr  The position of the current token
     *                                        in the stack passed in $tokens.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $nextToken = $tokens[($stackPtr + 1)];
        if ($nextToken['code'] !== T_WHITESPACE || strlen($nextToken['content']) !== 1 || $nextToken['content'] === $phpcsFile->eolChar) {
            $error = 'Scope keyword "'.$tokens[$stackPtr]['content'].'" must be followed by a single space';
            $phpcsFile->addError($error, $stackPtr);
        }

    }//end process()


}//end class

?>
