<?php


namespace Miniature;

use PDO;

class DatabaseObject // Extended by the children class:
{
    static protected string $table = ""; // Overridden by the calling class:
    static protected array $db_columns = []; // Overridden by the calling class:
    static protected array $objects = [];
    static protected array $params = [];
    static protected $searchItem;

    /*
     * There is NO read() method this fetch_all method
     *  basically does the same thing. The query ($sql)
     *  is done in the class the calls this method.
     */
    public static function fetch_by_column_name($sql)
    {
        $stmt = Database::pdo()->prepare($sql);

        $stmt->execute([ static::$searchItem => static::$params[0] ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Total rows in Database Table
     */
    public static function countAll() {
        return Database::pdo()->query("SELECT count(*) FROM " . static::$table)->fetchColumn();
    }

    /*
     * Pagination static function/method to limit
     * the number of records per page. This is
     * useful for tables that contain a lot of
     * records (data).
     */
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
        $sql = "SELECT * FROM " . static::$table . " WHERE id=:id LIMIT 1";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /*
     * Create/Insert new record in the database table
     * that can be used for more than one table.
     */
    public function create():bool
    {

        /* Initialize an array */
        $attribute_pairs = [];

        /*
         * Setup the query using prepared states with static:$params being
         * the columns and the array keys being the prepared named placeholders.
         */
        $sql = 'INSERT INTO ' . static::$table . '(' . implode(", ", array_keys(static::$params)) . ', date_updated, date_added)';
        $sql .= ' VALUES ( :' . implode(', :', array_keys(static::$params)) . ', NOW(), NOW() )'; // Notice the 2 NOW() calls for dates:

        /*
         * Prepare the Database Table:
         */
        $stmt = Database::pdo()->prepare($sql);

        /*
         * Grab the corresponding values in order to
         * insert them into the table when the script
         * is executed.
         */
        foreach (static::$params as $key => $value)
        {
            if($key === 'id') { continue; } // Don't include the id:
            $attribute_pairs[] = $value; // Assign it to an array:
        }

        return $stmt->execute($attribute_pairs); // Execute and send boolean true:

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