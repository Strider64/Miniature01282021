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

    public static function fetch_all_data($searchTerm): array
    {
        static::$searchItem = 'category';
        static::$searchValue = $searchTerm;
        $sql = "SELECT * FROM " . static::$table . " WHERE category=:category";
        return  static::fetch_all($sql);

    }

    public static function fetch_correct_answer($answer):array
    {
        static::$searchItem = 'id';
        static::$searchValue = $answer;
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

}