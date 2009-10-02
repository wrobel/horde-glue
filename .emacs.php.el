(setq current-dir (file-name-directory load-file-name))

(setq liblocs (concat current-dir
		      "lib:"
		      current-dir
		      "pear/php:"
		      current-dir
		      "horde-release/horde-webmail/pear"))

(setq logopts (concat " -d log_errors=1"
                      " -d error_log=\""
		      current-dir
		      "log/php-errors.log\" "))

(setq package_dir "framework")

(setq phplint_cmd (concat "php -d include_path=\".:" liblocs "\" " current-dir "/tools/test_lint --verbose"))

(setq phpcs_command (concat "php -d include_path=\".:" liblocs "\" " current-dir "/pear/phpcs"))
(setq phpcs_options (concat " --standard=PEAR --report=emacs"))

(setq pcp_command (concat "php -d include_path=\".:" liblocs "\" " current-dir "/pear/phpcpd"))
(setq pcp_options (concat " --min-lines 5 --min-tokens 40"))

(setq plc_command (concat "php -d include_path=\".:" liblocs "\" " current-dir "/pear/phploc"))
(setq plc_options (concat ""))

(setq pmd_pre "echo")
(setq pmd_command (concat "php -d include_path=\".:" liblocs "\" " current-dir "/pear/phpmd.php"))
(setq pmd_format "emacs")
(setq pmd_codestyle (concat current-dir "/pear/dev/trunk/rulesets/codesize_horde.xml"))
(setq pmd_options "")

(setq phpunit_pre "export XDEBUG_CONFIG=\"idekey=php_unit_run\"")
(setq phpunit_options "--verbose")
(setq phpunit_command (concat "php -d include_path=\".:" liblocs "\" " current-dir "/pear/phpunit"))
(setq phpunit_phpoptions "")
(setq phpunit_includes liblocs)

;(setq phpunit_options (concat "--verbose --coverage-html=" current-dir "coverage"))

(setq phpoptions (concat liblocs
			 logopts
                         " -c \""
			 current-dir
			 "php.ini\" "))
