<?php

include('../vendor/autoload.php');

$config = include ('../config/main.php');

\app\base\App::call()-> run($config);

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 13:43
 */