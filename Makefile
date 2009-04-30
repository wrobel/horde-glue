SYMLINK = horde-cvs/framework/devtools/horde-fw-symlinks.php

TEST_HEAD_PKGS = Kolab_Server
TEST_CVS_PKGS = Auth Kolab_Format Kolab_Storage Kolab_FreeBusy Kolab_Filter Date Share iCalendar VFS
TEST_CVS_APPS = turba kronolith

REVCMP = Kolab_Format Kolab_Server Kolab_Storage Kolab_Filter Kolab_FreeBusy
REVBIN = ./horde-rev-cmp.sh

.PHONY:lib
lib:
	@php -c php.ini -q $(SYMLINK) --src horde-cvs/framework --dest lib > /dev/null
	@php -c php.ini -q $(SYMLINK) --src horde/framework --dest lib > /dev/null
	@php -c php.ini -q $(SYMLINK) --src horde-hatchery --dest lib --pkg horde-hatchery/koward > /dev/null
	@echo "Successfully updated the libraries!"

.PHONY: test-HEAD
test-HEAD: clean-test $(TEST_HEAD_PKGS:%=test-HEAD-%) $(TEST_CVS_PKGS:%=test-CVS-%)
	@echo " -> All done."

.PHONY: clean-test
clean-test:
	@rm -f log/test*.log

.PHONY: $(TEST_HEAD_PKGS:%=test-HEAD-%)
$(TEST_HEAD_PKGS:%=test-HEAD-%): lib
	@PHP_FILES=`find horde/framework/$(@:test-HEAD-%=%)/ -name '*.php'`; \
	if [ -n "$$PHP_FILES" ]; then \
	  rm -f log/$@-HEAD-syntax.log; \
	  for TEST in $$PHP_FILES; do \
	    php -l -f $$TEST | tee -a log/$@-HEAD-syntax.log | grep "^No syntax errors detected in" > /dev/null || SYNTAX="$$SYNTAX $$TEST"; \
	  done; \
	  if [ -n "$$SYNTAX" ]; then \
	    echo; \
	    echo "FAIL (framework/$(@:test-CVS-%=%)): Syntax errors in files: $$SYNTAX"; \
	  else \
	    echo -n "."; \
	  fi; \
	fi
	@SIMPLE_TESTS=`find horde/framework/$(@:test-HEAD-%=%)/ -name '*.phpt' | xargs -L 1 -r dirname | sort | uniq`; \
	if [ -n "$$SIMPLE_TESTS" ]; then \
	  rm -f log/$@-HEAD-simple.log; \
	  for TEST in $$SIMPLE_TESTS; do \
	    pear -c .pearrc run-tests $$TEST/*.phpt | tee -a log/$@-HEAD-simple.log | grep "^FAIL " | sed -e 's/FAIL.*\(\[.*\]\)/FAIL: \1/'; \
	  done; \
	fi
	@ALL_TESTS=`find horde/framework/$(@:test-HEAD-%=%)/ -name AllTests.php | xargs -L 1 -r dirname | sort | uniq`; \
	if [ -n "$$ALL_TESTS" ]; then \
	  CWD=`pwd`; \
	  rm -f log/$@-HEAD-phpunit.log; \
	  for TEST in $$ALL_TESTS; do \
	    cd $$TEST && phpunit -d include_path=".:$$CWD/lib:$$CWD/pear/php:$$CWD/horde-release/horde-webmail/pear:/usr/share/php5:/usr/share/php" -d log_errors=1 -d error_log="$$CWD/logs/php-errors.log" AllTests.php 2>&1 | tee -a $$CWD/log/$@-HEAD-phpunit.log | grep "^OK" > /dev/null || PHPUNIT="FAIL"; \
	    cd $$CWD; \
	  done; \
	  if [ -n "$$PHPUNIT" ]; then \
	    echo; \
	    echo "FAIL (framework/$(@:test-CVS-%=%)): Some phpunit tests failed!"; \
	  else \
	    echo -n "."; \
	  fi; \
	fi

.PHONY: $(TEST_CVS_PKGS:%=test-CVS-%)
$(TEST_CVS_PKGS:%=test-CVS-%): lib
	@PHP_FILES=`find horde-cvs/framework/$(@:test-CVS-%=%)/ -name '*.php'`; \
	if [ -n "$$PHP_FILES" ]; then \
	  rm -f log/$@-CVS-syntax.log; \
	  for TEST in $$PHP_FILES; do \
	    php -l -f $$TEST | tee -a log/$@-CVS-syntax.log | grep "^No syntax errors detected in" > /dev/null || SYNTAX="$$SYNTAX $$TEST"; \
	  done; \
	  if [ -n "$$SYNTAX" ]; then \
	    echo; \
	    echo "FAIL (framework/$(@:test-CVS-%=%)): Syntax errors in files: $$SYNTAX"; \
	  else \
	    echo -n "."; \
	  fi; \
	fi
	@SIMPLE_TESTS=`find horde-cvs/framework/$(@:test-CVS-%=%)/ -name '*.phpt' | xargs -L 1 -r dirname | sort | uniq`; \
	if [ -n "$$SIMPLE_TESTS" ]; then \
	  rm -f log/$@-CVS-simple.log; \
	  for TEST in $$SIMPLE_TESTS; do \
	    pear -c .pearrc run-tests $$TEST/*.phpt | tee -a log/$@-CVS-simple.log | grep "^FAIL " | sed -e 's/FAIL.*\(\[.*\]\)/FAIL: \1/'; \
	  done; \
	fi
	@ALL_TESTS=`find horde-cvs/framework/$(@:test-CVS-%=%)/ -name AllTests.php | xargs -L 1 -r dirname | sort | uniq`; \
	if [ -n "$$ALL_TESTS" ]; then \
	  CWD=`pwd`; \
	  rm -f log/$@-CVS-phpunit.log; \
	  for TEST in $$ALL_TESTS; do \
	    cd $$TEST && phpunit -d include_path=".:$$CWD/lib:$$CWD/pear/php:$$CWD/horde-release/horde-webmail/pear:/usr/share/php5:/usr/share/php" -d log_errors=1 -d error_log="$$CWD/logs/php-errors.log" AllTests.php  2>&1 | tee -a $$CWD/log/$@-CVS-phpunit.log | grep "^OK" > /dev/null || PHPUNIT="FAIL"; \
	    cd $$CWD; \
	  done; \
	  if [ -n "$$PHPUNIT" ]; then \
	    echo; \
	    echo "FAIL (framework/$(@:test-CVS-%=%)): Some phpunit tests failed!"; \
	  else \
	    echo -n "."; \
	  fi; \
	fi

.PHONY: $(TEST_PKGS:%=test-%)
$(TEST_PKGS:%=test-%): lib
	@echo
	@echo "TESTING framework/$(@:test-%=%)"
	@echo "===================================="
	@echo
	@PHP_FILES=`find horde*/framework/$(@:test-%=%)/ -name '*.php'`; \
	if [ -n "$$PHP_FILES" ]; then \
	  rm -f log/$@-syntax.log; \
	  for TEST in $$PHP_FILES; do \
	    php -l -f $$TEST | tee -a log/$@-syntax.log | grep "^No syntax errors detected in" > /dev/null || SYNTAX="$$SYNTAX $$TEST"; \
	  done; \
	  if [ -n "$$SYNTAX" ]; then \
	    echo "FAIL: Syntax errors in files: $$SYNTAX"; \
	  else \
	    echo "OK: Syntax checks."; \
	  fi; \
	fi
	@SIMPLE_TESTS=`find horde*/framework/$(@:test-%=%)/ -name '*.phpt' | xargs -L 1 -r dirname | sort | uniq`; \
	if [ -n "$$SIMPLE_TESTS" ]; then \
	  rm -f log/$@-simple.log; \
	  for TEST in $$SIMPLE_TESTS; do \
	    pear -c lib/.pearrc run-tests $$TEST/*.phpt | tee -a log/$@-simple.log | grep "^FAIL " | sed -e 's/FAIL.*\(\[.*\]\)/FAIL: \1/'; \
	  done; \
	fi
	@ALL_TESTS=`find horde*/framework/$(@:test-%=%)/ -name AllTests.php | xargs -L 1 -r dirname | sort | uniq`; \
	if [ -n "$$ALL_TESTS" ]; then \
	  CWD=`pwd`; \
	  rm -f log/$@-phpunit.log; \
	  for TEST in $$ALL_TESTS; do \
	    cd $$TEST && phpunit -d include_path=".:$$CWD/lib:/usr/share/php5:/usr/share/php" -d log_errors=1 -d error_log="$$CWD/logs/php-errors.log" AllTests.php | tee -a $$CWD/log/$@-phpunit.log | grep "^OK" > /dev/null || PHPUNIT="FAIL"; \
	    cd $$CWD; \
	  done; \
	  if [ -n "$$PHPUNIT" ]; then \
	    echo "FAIL: Some phpunit tests failed!"; \
	  else \
	    echo "OK: PHPUnit checks."; \
	  fi; \
	fi

.PHONY: revcmp-kolab
revcmp-kolab:
	for MODULE in $(REVCMP); \
	do                       \
	  $(REVBIN) horde-release/horde-webmail/lib/ horde-fw3/framework/$$MODULE/lib/ | grep -v "Nur in"; \
	done

.PHONY: revcmp-horde
revcmp-horde:
	for MODULE in $(REVCMP); \
	do                       \
	  $(REVBIN) horde-fw3/framework/$$MODULE/ horde-cvs/framework/$$MODULE/; \
	done

.PHONY: check-series
check-series:
	diff -Naur -I '^tg:' -I '^commit [0-9a-f]*' -I '^index [0-9a-f.]*' -I '^Date: ' -I '@version[ ]*CVS[:]* \$$Id:' --exclude="CVS" --exclude="series" kolab-cvs/server/kolab-webclient/patches/1.2.0/KOLAB/ patches/horde-webmail/1.2.0/KOLAB/

.PHONY: pear-config
pear-config:
	pear config-create `pwd` .pearrc
	pear -c .pearrc config-set php_ini `pwd`/php.ini
	pear -c .pearrc config-set php_bin "/usr/bin/php -c `pwd`/php.ini"

.PHONY: www-koward
www-koward:
	rsync -avz horde-hatchery/koward/www/ www/  --delete-after --exclude=".htaccess" --exclude="config/*.php" --exclude="log" --exclude="tmp" --exclude="storage"
