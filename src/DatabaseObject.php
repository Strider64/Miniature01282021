<?php


namespace Miniature;

use PDO;

class DatabaseObject
{
    static protected string $table = "";
    static protected array $db_columns = [];
    static protected $objects = [];
    public static function fetch_all(): array
    {
        $query = "SELECT * FROM " . static::$table;
        $stmt = Database::pdo()->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function fetch_by_id($id): array
    {
        $query = "SELECT " . implode(", ", static::$db_columns) . " FROM " . static::$table . " WHERE id=:id LIMIT 1";
        $stmt = Database::pdo()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create():bool
    {
        /*
         * There is no id for a new record:
         */
        $db_columns_minus_id = array_slice(static::$db_columns, 1);
        /*
         * Need to figure out the number of placeholders for
         * the prepared statements. ***NOTE*** All Queries will
         * have to have date_updated and date_added in them.
         * Though you could set $db-columns differently and
         * hard code it in the query string.
         */
        $db_columns_minus_data = array_slice($db_columns_minus_id, 0, 4);
        /*
         * Create prepared statements using ? question marks for the total amount of columns:
         */
        $placeholders = str_repeat ('?, ',  count ($db_columns_minus_data) - 1) . '?';
        /*
         * Create the actual query to send to database table:
         */
        $query = 'INSERT INTO ' . static::$table . '(' . implode(", ", $db_columns_minus_id) . ' )';
        $query .= ' VALUES ( ' . $placeholders . ', NOW(), NOW() )'; // Notice the 2 NOW() calls for dates:
        /*
         * Prepare the Database Table:
         */
        $stmt = Database::pdo()->prepare($query);
        /*
         * Bind the Objects values of the parameters to the db table:
         */
        for ($x=1, $xMax = count(static::$objects); $x <= $xMax; $x++)
        {
            $stmt->bindParam($x, static::$objects[$x-1], PDO::PARAM_INT );
        }
        return $stmt->execute(); // Execute and send boolean true:

    }



}