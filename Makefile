.PHONY: all

info: intro usage

intro:
	@echo "\n    Dutch Laravel Hackathon\n"

usage:
	@echo "Project:"
	@echo "  make init                        Initialise the project for development."
	@echo "  make serve                       Run the project for development."
	@echo "\nEnvironment:"
	@echo "  make watch                       Start the file watchers for development."
	@echo "  make migrate                     Rebuild the database from scratch and run migrations + seeds."
	@echo "  make tinker                      Start up Tinker for command line interaction with the application."
	@echo "\nTests and checks:"
	@echo "  make tests                       Run the tests."
	@echo "  make codestyle                   Run the codestyle checks."
	@echo "  make codestyle-fix               Run the codestyle checks and fix them automatically."

# ===========================
# Commands
# ===========================

init: intro do_prepare_backend do_init do_prepare_frontend
serve: intro do_serve
update: intro do_prepare_backend do_prepare_frontend do_migrate
watch: intro do_run_develop
migrate: intro do_migrate
tinker: intro do_tinker
tests: intro do_tests
codestyle: intro do_codestyle
codestyle-fix: intro do_codestyle_fix

# ===========================
# Recipes
# ===========================

do_init:
	test -f .env || cp .env.example .env
	php artisan key:generate
	composer install

do_migrate:
	php artisan migrate:fresh --seed --force

do_tinker:
	php artisan tinker

do_serve:
	php artisan serve

do_tests:
ifdef filter
	vendor/bin/phpunit --filter=$(filter) $(arguments)
else
	vendor/bin/phpunit $(arguments)
endif

do_codestyle:
	vendor/bin/ecs --config=dev/ecs/config.yml check .

do_codestyle_fix:
	vendor/bin/ecs --config=dev/ecs/config.yml check --fix .

do_prepare_backend:
	composer install --prefer-dist --ignore-platform-reqs --no-suggest

do_prepare_frontend:
	npm ci
	npm run dev

do_run_develop:
	npm run watch
