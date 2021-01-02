<?php


namespace Miniature;

use Exception;
use JetBrains\PhpStorm\Pure;
use PDO;
use DateTime;
use DateTimeZone;

class CMS extends DatabaseObject
{
    protected static string $table = "cms";
    public $id;
    public $user_id;
    public $author;
    public $heading;
    public $content;
    public $date_updated;
    public $date_added;


    #[Pure] public static function intro($content = "", $count = 100, $id = 0): string
    {
        return substr($content, 0, $count) . '<a class="moreBtn" href="edit.php?id=' . urldecode($id) . '"> ...more</a>';
    }

    public static function styleDate($prettyDate): string
    {
        try {
            $dateStylized = new DateTime($prettyDate, new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
            error_log("Caught $e");
        }
        return $dateStylized->format("F j, Y");
    }

    protected function setColumnsNames(): array
    {
        $result = Database::pdo()->query('select * from ' . static::$table .' limit 1');
        return array_keys($result->fetch(PDO::FETCH_ASSOC));
    }


    public function __construct($args = [])
    {
//        $this->user_id = $args['user_id'] ?? null;
//        $this->author = $args['author'] ?? null;
//        $this->heading = $args['heading'] ?? null;
//        $this->content = $args['content'] ?? null;
//        $this->date_updated = $args['date_updated'] ?? null;
//        $this->date_added = $args['date_added'] ?? null;

        static::$db_columns = $this->setColumnsNames(); // Set ColumnNames in DatabaseObject() Class:

        // Caution: allows private/protected properties to be set
        foreach($args as $k => $v) {
           if(property_exists($this, $k)) {
            $this->$k = $v;
            static::$arrayOfObjects[$k] = $v;
            static::$objects[] = $v;
          }
        }
    }

}