# Getting started with PHPUnit

PHPUnit examples in support of my blog:  
https://neerajdas.com/blog/getting-started-with-phpunit

Setup:
1. Clone / Download: https://github.com/nkdas91/Getting-started-with-PHPUnit.git
2. Copy ```env.example.php``` to ```env.php``` and replace default values.
3. Create a DB ```phpunit``` and import ```sql/phpunit.sql```
4. Update ```ABSOLUTE_PATH_TO_DOCUMENT_ROOT``` in ```phpunit.xml```.
5. Run ```composer install``` in the root directory.
6. Run ```XDEBUG_MODE=coverage ./vendor/bin/phpunit``` to run unit tests and generate Code Coverage.
