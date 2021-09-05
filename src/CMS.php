<?php /** @noinspection ALL */

namespace Miniature;

use Exception;
use JetBrains\PhpStorm\Pure;
use DateTime;
use DateTimeZone;

class CMS extends DatabaseObject
{
    protected static string $table = "cms"; // Table Name:
    static protected array $db_columns = ['id', 'user_id', 'thumb_path', 'image_path', 'Model', 'ExposureTime', 'Aperture', 'ISO', 'FocalLength', 'author', 'heading', 'content', 'data_updated', 'date_added'];
    public $id;
    public $user_id;
    public $page;
    public $thumb_path;
    public $image_path;
    public $Model;
    public $ExposureTime;
    public $Aperture;
    public $ISO;
    public $FocalLength;
    public $author;
    public $heading;
    public $content;
    public $date_updated;
    public $date_added;

    /*
     * Create a short description of content and place a link button that I call 'more' at the end of the
     * shorten content.
     */
    #[Pure] public static function intro($content = "", $count = 100): string
    {
        return substr($content, 0, $count) . "...";
    }

    public static function styleTime($prettyDate): string
    {
        try {
            $dateStylized = new DateTime($prettyDate, new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
        }

        return $dateStylized->format("Y-m-d H:i:s");
    }

    public static function countAllPage($page)
    {
        static::$searchItem = 'page';
        static::$searchValue = $page;
        $sql = "SELECT count(id) FROM " . static::$table . " WHERE page=:page";
        $stmt = Database::pdo()->prepare($sql);

        $stmt->execute([ static::$searchItem => static::$searchValue ]);
        return $stmt->fetchColumn();
    }

    protected static function filterwords($text){
        $filterWords = array('fuck', 'shit', 'ass', 'asshole', 'motherfucker');
        $filterCount = sizeof($filterWords);
        for ($i = 0; $i < $filterCount; $i++) {
            $text = preg_replace_callback('/\b' . $filterWords[$i] . '\b/i', function($matches){return str_repeat('*', strlen($matches[0]));}, $text);
        }
        return $text;
    }

    /*
     * Put the date from 00-00-0000 00:00:00 that is stored in the MySQL
     * database table to a more presentable format such as January 1, 2021.
     */
    public static function styleDate($prettyDate): string
    {

        try {
            $dateStylized = new DateTime($prettyDate, new DateTimeZone("America/Detroit"));
        } catch (Exception $e) {
        }

        return $dateStylized->format("F j, Y");
    }

    /*
     * Construct the data for the CMS
     */
    public function __construct($args = [])
    {
//        $this->user_id = $args['user_id'] ?? null;
//        $this->author = $args['author'] ?? null;
//        $this->heading = $args['heading'] ?? null;
//        $this->content = $args['content'] ?? null;
//        $this->date_updated = $args['date_updated'] ?? null;
//        $this->date_added = $args['date_added'] ?? null;


        // Caution: allows private/protected properties to be set
        foreach ($args as $k => $v) {
            if (property_exists($this, $k)) {
                $v = static::filterwords($v);
                $this->$k = $v;
                static::$params[$k] = $v;
                static::$objects[] = $v;
            }
        }
    } // End of construct method:

} // End of class: