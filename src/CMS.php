<?php

namespace Miniature;

use PDO;
use Miniature\Database as DB;
use PDOStatement;

class CMS {

    public $content = null;

    /*
     * Create a static pdo connection to database
     */
    private string $query;
    private false|PDOStatement $stmt;
    private bool $result;

    static protected function pdo() {
        $db = DB::getInstance();
        return $db->getConnection();
    }

    public function create(array $data) {
        $this->query = 'INSERT INTO cms( user_id, author, post, page, thumb_path, path, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, date_updated, date_added) VALUES ( :user_id, :author, :post, :page, :thumb_path, :path, :Model, :ExposureTime, :Aperture, :ISO, :FocalLength, :heading, :content, NOW(), NOW())';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':user_id' => $data['user_id'], ':author' => $data['author'], ':post' => $data['post'], ':page' => $data['page'], ':thumb_path' => $data['thumb_path'], ':path' => $data['path'], ':Model' => $data['Model'], ':ExposureTime' => $data['ExposureTime'], ':Aperture' => $data['Aperture'], ':ISO' => $data['ISO'], ':FocalLength' => $data['FocalLength'], ':heading' => $data['heading'], ':content' => trim($data['content'])]);
        return true;
    }

    public function read($page = "index.php"): array
    {
        $query = 'SELECT id, user_id, author, page, post, page, thumb_path, path, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE page=:page ORDER BY myDate DESC';
        $stmt = static::pdo()->prepare($query); // Prepare the query:
        $stmt->execute([':page' => $page]); // Execute the query with the supplied user's parameter(s):
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function update(array $data) {
        $this->query = 'UPDATE cms SET post=:post, heading=:heading, content=:content, date_updated=NOW() WHERE id =:id';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':post' => $data['post'], ':heading' => $data['heading'], ':content' => $data['content'], ':id' => $data['id']]);

        return $data['page_name'];
    }

    public function delete(int $id = NULL) {
        $this->query = "DELETE FROM cms WHERE id=:id";
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        return \TRUE;
    }

    public function getIntro($content = "", $count = 200, $pageId = 0) {;
        $this->content = (string) $content;
        return substr($this->content, 0, (int)$count) . '<a class="moreBtn" href="mainArticle.php?page=' . (int)$pageId . '"> ...more</a>';
    }

    public function page($id) {
        $this->query = 'SELECT id, user_id, author, page, post, page, thumb_path, path, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE id=:id';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        $this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
        return $this->result;
    }

    static public function countAll() {
        $stmt = static::pdo()->prepare("SELECT count(*) FROM cms WHERE post = ?");
        $stmt->execute(['on']);
        return $stmt->fetchColumn();
    }

}
