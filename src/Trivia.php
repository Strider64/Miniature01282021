<?php
namespace Miniature;

class Trivia extends DatabaseObject {

    static protected string $table = "trivia_questions";

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

    public static function fetch_correct_answer($answer):array
    {
        static::$searchItem = 'id';
        static::$searchValue = $answer;
        $sql = "SELECT id, correct FROM " . static::$table . " WHERE id=:id";
        return static::fetch_by_column_name($sql);
    }


}