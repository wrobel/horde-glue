SYMLINK = horde-cvs/framework/devtools/horde-fw-symlinks.php

TEST_HEAD_PKGS = Auth History Kolab_Storage Kolab_FreeBusy Kolab_Server Kolab_Format Date
TEST_CVS_PKGS = Kolab_Filter Share iCalendar VFS
TEST_CVS_APPS = turba kronolith

REVCMP = Kolab_Format Kolab_Server Kolab_Storage Kolab_Filter Kolab_FreeBusy
REVBIN = ./tools/horde-rev-cmp.sh

MODULES = horde horde-hatchery horde-cvs horde-fw3 kolab-cvs topgit

SUBMODULES=horde-fw3      \
           horde-cvs      \
           horde-support  \
           horde-release  \
           horde-hatchery \
           horde

.PHONY:lib
lib:
	@php -c php.ini -q $(SYMLINK) --src horde-cvs/framework --dest lib > /dev/null
	@php -c php.ini -q $(SYMLINK) --src horde-hatchery/framework --dest lib > /dev/null
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
	@php -c php.ini tools/test_lint horde/framework/$(@:test-HEAD-%=%) log/$@-HEAD-syntax.log
	@php -c php.ini pear/phpcpd --min-lines 5 --min-tokens 40 horde/framework/$(@:test-HEAD-%=%) | tee -a log/$@-HEAD-cpd.log | grep "^0.00%" > /dev/null || echo "Copy/Paste detected!"
	@php -c php.ini pear/phpmd.php horde/framework/$(@:test-HEAD-%=%) emacs pear/dev/trunk/rulesets/codesize_horde.xml | tee -a log/$@-HEAD-pmd.log | grep "Error" > /dev/null && echo "Mess detected!"
	@php -c php.ini pear/phpcs --standard=PEAR --report=emacs horde/framework/$(@:test-HEAD-%=%) | tee -a log/$@-HEAD-cs.log | grep "error" > /dev/null && echo "Style violations detected!"

$(TEST_HEAD_PKGS:%=test2-HEAD-%): lib
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

.PHONY: spec-fw3
spec-fw3:
	rm -rf spec-fw3
	mkdir spec-fw3
	for xml in horde-fw3/framework/*/package.xml; \
	  do \
	  php -c php.ini tospec.php $$xml; \
	done

.PHONY: status
status:
	@for module in $(MODULES); \
	  do \
	    cd $$module; \
	    echo $$module; \
	    git status; \
	    cd ..; \
	    echo; \
	  done

.PHONY: branches
branches:
	@for module in $(MODULES); \
	  do \
	    cd $$module; \
	    echo $$module; \
	    git branch -a; \
	    cd ..; \
	    echo; \
	  done

.PHONY: stashes
stashes:
	@for module in $(MODULES); \
	  do \
	    cd $$module; \
	    echo $$module; \
	    git stash list; \
	    cd ..; \
	    echo; \
	  done

.PHONY:setup
setup:
	for MODULE in $(SUBMODULES);     \
	do                               \
	  git submodule init $$MODULE;   \
	  git submodule update $$MODULE; \
	done
	cd horde; git remote add horde git://dev.horde.org/horde/git/horde || echo "Remote exists"
	cd horde-hatchery; git remote add horde git://dev.horde.org/horde/git/horde-hatchery || echo "Remote exists"
	cd horde-support; git remote add horde git://dev.horde.org/horde/git/horde-support || echo "Remote exists"
	cd horde-release; tg remote --populate origin; git checkout t/EXPERIMENTAL;tg update
