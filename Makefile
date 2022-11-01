COMPOSER_BIN := composer
PHP_BIN := php
PHP_CS_FIXER_BIN := ./vendor/bin/php-cs-fixer
PHPSTAN_BIN	:= ./vendor/bin/phpstan
PHPUNIT_BIN	:= ./vendor/bin/phpunit
PARATEST_BIN := ./vendor/bin/paratest
RECTOR_BIN	:= ./vendor/bin/rector

.PHONY: it
it: composer-install tests cs-check qa

.PHONY: composer-install
composer-install:
	$(COMPOSER_BIN) install --optimize-autoloader

.PHONY: tests
tests: tests-unit tests-integration

.PHONY: tests-unit
tests-unit:
	$(PARATEST_BIN) --group=unit

.PHONY: tests-integration
tests-integration:
	$(PARATEST_BIN) --group=integration

.PHONY: tests-coverage
tests-coverage:
	XDEBUG_MODE=coverage $(PHPUNIT_BIN) --coverage-html coverage

.PHONY: qa
qa: cs-check analyse

.PHONY: cs-check
cs-check:
	PHP_CS_FIXER_FUTURE_MODE=1 PHP_CS_FIXER_IGNORE_ENV=1 $(PHP_CS_FIXER_BIN) fix --allow-risky=yes --diff --using-cache=no --verbose --dry-run

.PHONY: cs-fix
cs-fix:
	PHP_CS_FIXER_FUTURE_MODE=1 PHP_CS_FIXER_IGNORE_ENV=1 $(PHP_CS_FIXER_BIN) fix --allow-risky=yes

.PHONY: analyse
analyse:
	$(PHPSTAN_BIN) analyse -c phpstan.neon --memory-limit=-1

.PHONY: phpstan-baseline
analyse-baseline:
	 $(PHPSTAN_BIN)  analyze -c phpstan.neon --generate-baseline=.phpstan/baseline.neon --memory-limit=-1

.PHONY: refactor
refactor:
	$(RECTOR_BIN) process
