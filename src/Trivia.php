<?php /** @noinspection ALL */

namespace Miniature;

class Trivia extends DatabaseObject
{

    public $id;
    public $user_id;
    public $hidden;
    public $question;
    public $answer1;
    public $answer2;
    public $answer3;
    public $answer4;
    public $correct;
    public $category;
    public $play_date;
    public $day_of_week;
    public $day_of_year;

    static protected string $table = "trivia_questions";
    static protected array $db_columns = ['id', 'user_id', 'hidden', 'question', 'answer1', 'answer2', 'answer3',
        'answer4', 'correct', 'category', 'play_date', 'day_of-week', 'day_of_year'];

    public function __construct($args = [])
    {
        foreach ($args as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
                static::$params[$k] = $v;
                static::$objects[] = $v;
            }
        }
    }

    public static function fetch_data($searchTerm): array
    {
        static::$searchItem = 'category';
        static::$searchValue = $searchTerm;
        $sql = "SELECT id, user_id, hidden, question, answer1, answer2, answer3, answer4, category FROM " . static::$table . " WHERE category=:category";
        return static::fetch_all_by_column_name($sql);
    }
    /*
     * Grab all the columns from table in order
     * to edit:
     */
    public static function fetch_all_data($searchTerm): array
    {
        static::$searchItem = 'category';
        static::$searchValue = $searchTerm;
        $sql = "SELECT * FROM " . static::$table . " WHERE category=:category";
        return  static::fetch_all_by_column_name($sql);

    }

    /*
     * Fetch correct answer:
     */
    public static function fetch_correct_answer($searchTerm):array
    {
        static::$searchItem = 'id';
        static::$searchValue = $searchTerm;
        $sql = "SELECT id, correct FROM " . static::$table . " WHERE id=:id";
        return static::fetch_by_column_name($sql);
    }

    public function create():bool
    {

        /* Initialize an array */
        $attribute_pairs = [];

        /*
         * Setup the query using prepared states with static:$params being
         * the columns and the array keys being the prepared named placeholders.
         */
        $sql = 'INSERT INTO ' . static::$table . '(' . implode(", ", array_keys(static::$params)) . ', play_date)';
        $sql .= ' VALUES ( :' . implode(', :', array_keys(static::$params)) . ', NOW() )'; // Notice the 2 NOW() calls for dates:

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

    public function update(): bool
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
        $sql .= implode(", ", $attribute_pairs) . ', play_date=NOW() WHERE id =:id';

        /* Normally in two lines, but you can daisy chain pdo method calls */
        Database::pdo()->prepare($sql)->execute(static::$params);

        return true;

    }

    static public function insertHighScores($data) {
        $query = 'INSERT INTO hs_table( player, score, played, correct, totalQuestions, day_of_year ) VALUES ( :player, :score, NOW(), :correct, :totalQuestions, :day_of_year )';
        $stmt = Database::pdo()->prepare($query);

        $result = $stmt->execute([':player' => $data['player'], ':score' => $data['score'], ':correct' => $data['correct'], ':totalQuestions' => $data['totalQuestions'], ':day_of_year' => $data['day_of_year']]);
        return $result;
    }

    static public function clearTable() {


        $sql = "DELETE FROM hs_table WHERE played < CURDATE()";

        $stmt = Database::pdo()->prepare($sql);

        return $stmt->execute();
    }

}