<?php

require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

$factory = (new Factory)
        ->withServiceAccount('fyp-project-9d41b-firebase-adminsdk-2mwqo-8135ccc427.json')
        ->withDatabaseUri('https://fyp-project-9d41b-default-rtdb.firebaseio.com/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();
?>
