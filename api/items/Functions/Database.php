<?php
namespace Functions;
use DateTime;
use mysqli;
use mysqli_sql_exception;


class Database
{
    public const DateFormat = "Y-m-d H:i:s";
    public const DateFormatSimplified = "Y-m-d";
    public const TimeFormat = "H:i:s";

    private static array $database_settings = array(
        "address" => "localhost",
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "database" => "bdd_Opportunity",
        "charset" => "utf8"
    );

    private static ?Mysqli $database = null;

    /**
     * @throws IOException
     */
    public static function getConnection(): Mysqli
    {
        if (self::$database == null || !self::$database->stat()) {
            try {
                self::$database = new mysqli(
                    hostname: self::$database_settings["address"],
                    username: self::$database_settings["username"],
                    password: self::$database_settings["password"],
                    port: self::$database_settings["port"]);
                if (self::$database->connect_error) {
                    throw new IOException(address: self::$database_settings["address"], port: self::$database_settings["port"]);
                } else {
                    self::$database->select_db(self::$database_settings["database"]);
                    self::$database->set_charset(self::$database_settings["charset"]);
                }
            } catch (mysqli_sql_exception $e) {
                throw new IOException(address: self::$database_settings["address"], port: self::$database_settings["port"]);
            }
        }
        return self::$database;
    }

    public static function getNextIncrement($table, $commit = false) : int {
        try {
            $value = self::getConnection()->query("SELECT auto_increment as 'val' FROM INFORMATION_SCHEMA.TABLES WHERE table_name = '$table'")->fetch_array()["val"];
            if($value === null){
                return 1;
            } else return $value;
        } catch (IOException $e){
            echo $e->getTraceAsString();
            return -1;
        }
    }

}