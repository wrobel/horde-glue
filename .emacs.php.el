(setq current-dir (file-name-directory load-file-name))

(setq liblocs (concat current-dir
		      "lib:"
		      current-dir
		      "pear/php:"
		      current-dir
		      "horde-release/horde-webmail/pear:"
		      "/usr/share/php5:"
		      "/usr/share/php"))

(setq logopts (concat " -d log_errors=1"
                      " -d error_log=\""
		      current-dir
		      "log/php-errors.log\" "))

(setq phpunit_pre "export XDEBUG_CONFIG=\"idekey=php_unit_run\"")
(setq phpunit_options "--verbose")
(setq phpunit_command "phpunit")
(setq phpunit_phpoptions "-d log_errors=1 -d error_log=\"php-errors.log\" -d error_reporting=\"E_ALL\"")
(setq phpunit_includes liblocs)

;;(setq phpunit_options (concat "--verbose --coverage-html=" current-dir "coverage")

(setq phpoptions (concat liblocs
			 logopts
                         " -c \""
			 current-dir
			 "php.ini\" "))
