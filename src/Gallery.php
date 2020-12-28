<?php

namespace Miniature;

use PDO;
use Miniature\Database as DB;

class Gallery {

    protected $query = \NULL;
    protected $stmt = \NULL;
    public $result = \null;

    static protected function pdo() {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        return $pdo;
    }

    public function create(array $data) {
        $this->query = 'INSERT INTO gallery( user_id, author, category, thumb_path, path, Model, ExposureTime, Aperture, ISO, FocalLength, date_updated, date_added) VALUES ( :user_id, :author, :category, :thumb_path, :path, :Model, :ExposureTime, :Aperture, :ISO, :FocalLength, NOW(), NOW())';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':user_id' => $data['user_id'], ':author' => $data['author'], ':category' => $data['category'], ':thumb_path' => $data['thumb_path'], ':path' => $data['path'], ':Model' => $data['Model'], ':ExposureTime' => $data['ExposureTime'], ':Aperture' => $data['Aperture'], ':ISO' => $data['ISO'], ':FocalLength' => $data['FocalLength']]);
        if ($this->result) {
            return true;
        }
    }

    public function read() {
        $this->query = 'select id, user_id, category, thumb_path, path, Model, ExposureTime, Aperture, ISO, FocalLength, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM gallery ORDER BY category DESC';
        $this->stmt = static::pdo()->prepare($this->query); // Prepare the query:
        $this->stmt->execute(); // Execute the query with the supplied user's parameter(s):
        $this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->result;
    }

}
