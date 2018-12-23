<?php

class Db
{
	
	public static function getConnection()
	{
		$paramsPath = ROOT .'config/db_params.php';
		$params = include($paramsPath);

        try {
            $conn = new PDO("mysql:host={$params['host']};dbname={$params['dbname']}", $params['user'], $params['password'],array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            

            return $conn;
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
	}

    public static function CreateTables()
    {

	}

}