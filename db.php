<?php

class db {
    protected static $connection = null;

    //open the connection if one does not exist
    public static function getConnection() {
        if (static::$connection === null) {
            try {
                static::$connection = new PDO(
                    'mysql:dbname='. DB_NAME . ';host=' . DB_HOST .';charset=utf8', 
                    DB_USER,
                    DB_PASS
                );
         
                static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }
        }
         
        return static::$connection;
    }

    /**
     * runs a query
     * 
     * @param string $query - the SQL query to be run
     */

    public static function query($query, $values = []) {

        $connection = static::getConnection();

         //prepare the query and get a statement
        $statement = $connection->prepare($query);

        //execute the statement
        $worked = $statement->execute($values);
        
        if(!$worked) {
            //exit on error
            static::exitWithError();
        }

        //return statement on success
        return $statement;
    }

    public static function select($query, $values = []) {
        $statement = static::query($query, $values);

        $statement->setFetchMode(PDO::FETCH_ASSOC);

        $all_results = $statement->fetchAll();

        return $all_results;
    }

    public static function find($query, $values = []) {
        $statement = static::query($query, $values);

        $statement->setFetchMode(PDO::FETCH_OBJ);
        
        //fetch the first result
        $result = $statement->fetch();

        return $result;
    }

    public static function exitWithError() {
        // print an <h1>
        echo '<h1>MySQL error:</h1>';
    
        // dump information about the error
        var_dump(static::getConnection()->errorInfo());
    
        // end execution
        exit();
    }


}