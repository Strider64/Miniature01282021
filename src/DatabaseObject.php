<?php


namespace Miniature;

use JetBrains\PhpStorm\Pure;
use PDO;

class DatabaseObject
{
    static protected string $table = "";
    static protected array $db_columns = [];
    static protected $objects = [];
    static protected $minus_id = [];

    /*
     * There is NO read() method as fetch_all basically does the same thing:
     */
    public static function fetch_all(): array
    {
        $query = "SELECT * FROM " . static::$table;
        $stmt = Database::pdo()->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
     * Grab Record will be used for editing:
     */
    public static function fetch_by_id($id): array
    {
        $query = "SELECT " . implode(", ", static::$db_columns) . " FROM " . static::$table . " WHERE id=:id LIMIT 1";
        $stmt = Database::pdo()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * There is no id for a new record:
     */
    #[Pure] protected static function minus_id(): array
    {
        return array_slice(static::$db_columns, 1);
    }

    /*
     * Need to figure out the number of placeholders for
     * the prepared statements. ***NOTE*** All Queries will
     * have to have date_updated and date_added in them.
     * Though you could set $db-columns differently and
     * hard code it in the query string.
     */
    #[Pure] protected static function minus_dates(): array
    {
        return array_slice(static::minus_id(), 0, 4);
    }

    /*
     * Create prepared statements using ? question marks for the total amount of columns:
    */
    #[Pure] protected static function placeholders(): string
    {
        return str_repeat ('?, ',  count (static::minus_dates()) - 1) . '?';
    }

    public function create():bool
    {
        /*
         * Create the actual query to send to database table:
         */
        $query = 'INSERT INTO ' . static::$table . '(' . implode(", ", static::minus_id()) . ' )';
        $query .= ' VALUES ( ' . static::placeholders() . ', NOW(), NOW() )'; // Notice the 2 NOW() calls for dates:
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

    public function update($id) {

    }

    public function delete($id) {

    }



}