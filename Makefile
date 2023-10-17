##
## Проект
## ------

var: ## Убедиться, что существует папка var
	mkdir -p var

##
## Контроль качества кода
## ----------------------

check: composer-validate composer-unused composer-audit lint rector phpstan ## Запустить все проверки
.PHONY: check

fix: fixcs rector-fix composer-normalize ## Запускаем все инструменты исправления
.PHONY: fix

composer-validate: ## Провалидировать composer.json и composer.lock при помощи composer validate (https://getcomposer.org/doc/03-cli.md#validate)
	$(EXEC_PHP) composer validate --strict --no-check-publish
.PHONY: composer-validate

lint: var vendor ## Проверить PHP code style при помощи линтера
	$(EXEC_PHP) composer lint
.PHONY: lint

phpcs: var vendor ## Проверить PHP code style при помощи PHP CS Fixer (https://github.com/FriendsOfPHP/PHP-CS-Fixer)
	$(EXEC_PHP) composer phpcs-check
.PHONY: phpcs

fixcs: var vendor ## Исправить ошибки PHP code style при помощи PHP CS Fixer (https://github.com/FriendsOfPHP/PHP-CS-Fixer)
	$(EXEC_PHP) composer phpcs
.PHONY: fixcs

phpstan: var vendor ## Запустить полный статический анализ PHP кода при помощи Psalm (https://psalm.dev/)
	$(EXEC_PHP) composer phpstan
.PHONY: psalm

rector: var vendor ## Запустить полный анализ PHP кода при помощи Rector (https://getrector.org)
	$(EXEC_PHP) composer rector-check
.PHONY: rector

rector-fix: var vendor ## Запустить исправление PHP кода при помощи Rector (https://getrector.org)
	$(EXEC_PHP) composer rector
.PHONY: rector-fix

composer-unused: vendor ## Обнаружить неиспользуемые зависимости Composer при помощи composer-unused (https://github.com/icanhazstring/composer-unused)
	$(EXEC_PHP) composer unused
.PHONY: composer-unused

composer-audit: ## Обнаружить уязвимости в зависимостях Composer при помощи composer audit (https://getcomposer.org/doc/03-cli.md#audit)
	$(EXEC_PHP) composer audit
.PHONY: composer-audit

test:
	$(EXEC_PHP) composer test
.PHONY: test

composer-normalize: vendor # Упорядочить composer.json
	$(EXEC_PHP) composer normalize
.PHONY: composer-normalize

# -----------------------
