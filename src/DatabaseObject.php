<?php


namespace Miniature;

use JetBrains\PhpStorm\Pure;
use PDO;

class DatabaseObject
{
    static protected string $table = "";
    static protected array $db_columns = [];
    static protected $objects = [];
    static protected $params = [];

    /*
     * There is NO read() method as fetch_all basically does the same thing:
     */
    public static function fetch_all(): array
    {
        $query = "SELECT * FROM " . static::$table;
        $stmt = Database::pdo()->query($query);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /*
     * Total rows in Database Table
     */
    public static function countAll() {
        return Database::pdo()->query("SELECT count(*) FROM " . static::$table)->fetchColumn();
    }

    public static function page($perPage, $offset): array
    {
        $sql = 'SELECT * FROM ' . static::$table . ' ORDER BY date_updated DESC LIMIT :perPage OFFSET :blogOffset';
        $stmt = Database::pdo()->prepare($sql); // Prepare the query:
        $stmt->execute(['perPage' => $perPage, 'blogOffset' => $offset]); // Execute the query with the supplied data:
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    /*
     * Grab Record will be used for editing:
     */
    public static function fetch_by_id($id)
    {
        $query = "SELECT * FROM " . static::$table . " WHERE id=:id LIMIT 1";
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
    #[Pure] protected static function placeholders($arrayLength): string
    {
        return str_repeat ('?, ', $arrayLength-1 ) . '?';
    }

    /*
     * I found using Question ? for placeholders was easier than trying
     * to figuring out how to use named placeholders. However, I'm sure it can be done,
     * but I go by the motto if it isn't broke don't fix it. I don't think the variables
     * have to be sanitized as I am using prepared statements. Though it wouldn't
     * hurt to do so and I might go back to do this when I start validating my code.
     * Once I get this class written I will be able to use it on login/registration
     * and other pages that require a database table.
     */

    public function create():bool
    {
        /*
         * Figure out the length of the the array including the id.
         */
        $arrayLength = count(static::minus_dates());

        /*
         * Generate the ? placeholders string.
         */
        $placeholders = self::placeholders($arrayLength);

        /*
         * Create the actual query to send to database table:
         */
        $sql = 'INSERT INTO ' . static::$table . '(' . implode(", ", static::minus_id()) . ' )';
        $sql .= ' VALUES ( ' . $placeholders . ', NOW(), NOW() )'; // Notice the 2 NOW() calls for dates:
        /*
         * Prepare the Database Table:
         */
        $stmt = Database::pdo()->prepare($sql);

        /*
         * Bind the Objects values of the parameters to the db table:
         */
        for ($x=1, $xMax = count(static::$objects); $x <= $xMax; $x++)
        {
            $stmt->bindParam($x, static::$objects[$x-1], PDO::PARAM_INT );
        }

        return $stmt->execute(); // Execute and send boolean true:

    }

    /*
     * This is the update that method that I came up with and
     * it does use named place holders. I have always found
     * updating was easier that creating/adding a record for
     * some strange reason?
     */
    public function update(): void
    {
        /* Initialize an array */
        $attribute_pairs = [];

        /* Create the prepared statement string */
        foreach (static::$params as $key => $value)
        {
            if($key === 'id') { continue; } // Don't include the id:
            $attribute_pairs[] = "{$key}=:{$key}"; // Assign it to an array:
        }

        /*
         * The query/sql implodes the prepared statement array in the proper format
         * and I also hard code the date_updated column as I practically use that for
         * all my database table. Though I think you could override that in the child
         * class if you needed too.
         */
        $sql  = 'UPDATE ' . static::$table . ' SET ';
        $sql .= implode(", ", $attribute_pairs) . ', date_updated=NOW() WHERE id =:id';

        /* Normally in two lines, but you can daisy chain pdo method calls */
        Database::pdo()->prepare($sql)->execute(static::$params);

    }

    /*
     * Delete is probably the most easiest of CRUD (Create Read Update Delete),
     * but is the most dangerous method of the four as the erasure of the data is permanent of
     * PlEASE USE WITH CAUTION! (I use a small javascript code to warn users of deletion)
     */
    public function delete($id): bool
    {
            $sql = 'DELETE FROM ' . static::$table . ' WHERE id=:id';
            return Database::pdo()->prepare($sql)->execute([':id' => $id]);
    }

}