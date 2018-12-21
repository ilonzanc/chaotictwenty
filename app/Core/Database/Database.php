<?php

include_once('Config/bootstrap.php');

/*
*
*   Database class, for connecting to the database
*
*/
class Database
{
    /*
    *
    *   Instance of the database so we only connect to it once
    *
    */
    protected static $_db;

    /*
    *
    *   Connect to the database and return a database instance
    *
    */
    static function connect() {
        $config = DatabaseConfig::database();

        $dsn_properties = [
            'dbname'  => $config['dbname'],
            'host'    => $config['host'],
            'port'    => $config['port'],
            'charset' => 'utf8',
        ];

        $dsn = 'mysql:';

        foreach ($dsn_properties as $property => $value)
        {
            $dsn .= "{$property}={$value};";
        }

        $dbconfig  = [
            'dsn'      => $dsn,
            'user'     => $config['dbuser'],
            'password' => $config['dbpass'],
            'options'  => array(
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::NULL_TO_STRING => false
            ),
        ];

        try
        {
            $db = new PDO(
                $dbconfig['dsn'],
                $dbconfig['user'],
                $dbconfig['password'],
                $dbconfig['options']
            );
        }

        catch (PDOException $e)
        {
            die('Failed to connect to the database<pre>' . $e->getMessage() .'</pre>');
        }

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        self::$_db = $db;
    }

    /*
    *
    *   Select
    *
    */
    static function SQLselect($sql, $return = true)
    {
        $db = self::$_db;
        if ($db->query($sql))
        {
            if ($_SERVER['REQUEST_METHOD'] != 'DELETE')
            {
                $rows = $db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
                if ($rows)
                {
                    return $rows;
                }
            }
        }
    }

    /*
    *
    *   Do a raw SQL for INSERT and UPDATE
    *
    */
    static function SQL($sql, $return = true) {
        $db = self::$_db;
        $stmt = $db->prepare($sql);
        if ($stmt)
        {
            $stmt->execute();
            if ($return)
            {
                $id = $db->lastInsertId();
                return $id;
            }

            return true;
        }
    }

    /*
    *
    *   Get the fields of a table
    *
    */
    static function fields($tablename)
    {
        Database::connect();
        return Database::SQLselect("
            SELECT COLUMN_NAME, DATA_TYPE
            FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME = '" . $tablename . "'
            AND TABLE_SCHEMA = '" . DatabaseConfig::database()['dbname'] . "';"
        );
    }
}
