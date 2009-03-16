(setq current-dir (file-name-directory load-file-name))

(setq liblocs (concat ":"
		      current-dir
		      "lib:"
		      current-dir
		      "pear:"
		      current-dir
		      "horde-release/horde-webmail/pear:"
		      "/usr/share/php5:"
		      "/usr/share/php\""))

(setq logopts (concat " -d log_errors=1"
                      " -d error_log=\""
		      current-dir
		      "log/php-errors.log\" "))

(setq phpunitoptions (concat liblocs
			     logopts))

(setq phpoptions (concat liblocs
			 logopts
                         " -c \""
			 current-dir
			 "php.ini\" "))
