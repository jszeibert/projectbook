
app_name=$(notdir $(CURDIR))
build_tools_directory=$(CURDIR)/build/tools
composer=$(shell which composer 2> /dev/null)


all: dev-setup lint build-js-production test

# Dev env management
dev-setup: clean clean-dev composer npm-init

composer:
	composer install --prefer-dist
	composer update --prefer-dist

npm-init:
	npm ci

npm-update:
	npm update

# Building
build-js:
	npm run dev

build-js-production:
	npm run build

watch-js:
	npm run watch

# Linting
lint:
	npm run lint

lint-fix:
	npm run lint:fix

# Style linting
stylelint:
	npm run stylelint

stylelint-fix:
	npm run stylelint:fix

# Cleaning
clean:
	rm -f js/*

clean-dev:
	rm -rf node_modules


# Testing
test: test-unit test-js	

test-unit:
	./vendor/phpunit/phpunit/phpunit -c tests/phpunit.xml
	./vendor/phpunit/phpunit/phpunit -c tests/phpunit.integration.xml

test-js:
	npm run test

test-watch:
	npm run test:watch

test-coverage:
	npm run test:coverage

