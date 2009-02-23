SYMLINK = horde-cvs/framework/devtools/horde-fw-symlinks.php

TEST_PKGS = Auth Kolab_Format Kolab_Server Kolab_Storage Kolab_FreeBusy Kolab_Filter Date Share iCalendar VFS
TEST_APPS = turba kronolith

.PHONY:lib
lib:
	@php -c php.ini -q $(SYMLINK) --src horde-cvs/framework --dest lib > /dev/null
	@php -c php.ini -q $(SYMLINK) --src horde/framework --dest lib > /dev/null
	@echo "Successfully updated the libraries!"

.PHONY: test
test: clean-test $(TEST_PKGS:%=test-%) $(TEST_APPS:%=test-%)

.PHONY: clean-test
clean-test:
	rm -f log/test*.log

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

