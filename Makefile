# Functions

# make_version
# params : $(1) version
#
define make_version
	@semver inc $(1)
	@echo "New release: `semver tag`"
	@git add .semver
	@git commit -m "Releasing `semver tag`"
	@git tag -a `semver tag` -m "Releasing `semver tag`"
endef

default : help

help:
	@echo 'help'

install:
	php composer.phar install

major:
	$(call make_version,major)

minor:
	$(call make_version,minor)

patch:
	$(call make_version,patch)

test: test-unit test-functional

test-unit:
	Vendor/Bin/atoum -ulr

test-functional:
	cp Tests/Functionals/_data/database.sqlite Tests/Functionals/_data/current.sqlite
	Vendor/Bin/codecept run api -f
