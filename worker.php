<?php
/**
 * Created by PhpStorm.
 * User: Hamid
 * Date: 12/19/2017
 * Time: 6:10 PM
 */

require __DIR__.'/bootstrap/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$i = 1;
while (true) {
//    echo file_get_contents('http://localhost:3333/queue');
    $line = trim(fgets(STDIN));

    if ($line == 'exit') {
        break;
    }

/*    if ($i <= 1){
        continue;
    }*/
    echo $i;
    try {
        $i++;
    } catch (Exception $exception) {

    }
    if ($i > 10) {
        break;
    }

//    echo $line;

}
//echo 'Hello world!';