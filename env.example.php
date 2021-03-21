<?php
/**
 * env.example.php serves as a reference to create env.php file.
 * env.php should be kept on the root of this project.
 * env.php should not be commited.
 */

$variables = [
    'DB_HOST' => 'localhost',
    'DB_USERNAME' => 'username',
    'DB_PASSWORD' => 'password',
    'DB_NAME' => 'phpunit'
];

foreach ($variables as $key => $value) {
    putenv("$key=$value");
}
