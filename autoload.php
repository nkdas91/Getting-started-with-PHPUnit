<?php
/**
 * autoload.php loads the environment variables into the application.
 */

/** Autoload Vendor packages */
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

/** Check if 'env.php' file exists and include it here */
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/env.php')) {
    include $_SERVER['DOCUMENT_ROOT'] . '/env.php';
} else {
    die(
        '<div style="background:yellow; display:inline-block; padding:10px; font-weight:bold;">' .
        '"env.php" file is missing!<br>Please add it to the root of this project using "env.example.php"' .
        '</div>'
    );
}

/**
 * Create function 'myEnv'. We named it 'myEnv' just to separate it from the general 'env' function used in other
 * frameworks like Laravel
 */
if (!function_exists('myEnv')) {

    /**
     * Function to fetch environment variable for a given key. If a key is not set, a default value is returned if
     * passed to the function call, otherwise returns null.
     *
     * @param $key     String The environment variable whose value is to be fetched
     * @param $default String The default value to be returned if the environment variable is not set
     *
     * @return $value String Value of the environment variable
     */
    function myEnv($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }

}
