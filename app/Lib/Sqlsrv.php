<?php
/**
 * Created by PhpStorm.
 * User: Hamid Parchami
 * Date: 12/27/16
 * Time: 3:30 PM
 */

namespace App\Lib;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use PDO;

class Sqlsrv
{
    public static function connection()
    {
        try {
            $server   = Config::get('database.connections.sqlsrv.host');
            $database = Config::get('database.connections.sqlsrv.database');
            $username = Config::get('database.connections.sqlsrv.username');
            $password = Config::get('database.connections.sqlsrv.password');

            //Establish the connection
            $conn = new PDO( "sqlsrv:server=$server; Database=$database", $username, $password);

        } catch (\Exception $e) {
            if (App::environment('local', 'development')) {
                die("Could not connect to the database. Please check your configuration." . $e);
            } else {
                die("Could not connect to the database. Please check your configuration.");
            }
        }

        return $conn;
    }
}