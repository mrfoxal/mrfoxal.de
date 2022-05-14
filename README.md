# mrfoxal

Source code of the mrfoxal.

## Clone project via GIT

```
git clone https://github.com/mrfoxal/mrfoxal
cd mrfoxal
```

#### Build and run Docker

- `docker-compose build` - Build Docker
- `docker-compose up -d` - Start Docker
- `docker-compose exec php /bin/bash` - SSH Login to Docker
- `docker-compose down` - Stop Docker

#### Add new hosts to your `hosts` File:

```
127.0.0.1 mrfoxal.local
```

#### Development links
```
http://mrfoxal.local:8025
```

## Install all dependencies via Composer

```
composer install
```

## Copy config files from "/config/dist"

```
cp -r config/dist/* config
```

Remove "-dist" from this config files.

## Apply post create project script

```
composer run-script post-create-project-cmd
```

## Apply migrations

Setup DB settings in "config/db.php" and run migrations.

```
php yii migrate
```

## Apply RBAC

```
php yii rbac/init 
```

## Register new user and assign the roles

Setup reCAPTCHA settings in config/params.php and register a new user.

```
php yii rbac/assign admin admin
php yii rbac/assign moderator mrfoxal
```

## Generate sitemap.xml

```
php yii sitemap
```

## Tests

```
# Once run 'build'
vendor/bin/codecept build

# Apply migrations for _test db
php yii_test migrate

# Run all tests
vendor/bin/codecept run
```

## License
This project is licensed under the MIT License. See the LICENSE file for details.

## Contributing
1. Fork it
2. Create your feature branch (git checkout -b my-new-feature)
3. Make your changes
4. Commit your changes (git commit -am 'Added some feature')
5. Push to the branch (git push origin my-new-feature)
6. Create new Pull Request
