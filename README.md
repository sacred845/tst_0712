# Setup

```bash
# install dependencies
$ composer install

# Create cfg/config.php and add database parameters

# Create shema db and add test data
$ vendor/bin/doctrine orm:schema-tool:create
$ php bin/fixture

