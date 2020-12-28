<?php

namespace Miniature;

use PDO;
//use Miniature\Database as DB;

class Journal extends Database {

    public $content;
    /**
     * @var mixed
     */
    protected $query;
    protected $stmt;
    protected $result;
    protected $perPage;
    protected $offset;


    public function editArticle($id = NULL) {
        $this->query = 'SELECT id, user_id, author, page_name, image_path, post, thumb_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM journal WHERE id=:id';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->bindParam(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    
    public function insert($content): bool
    {
        $this->query = 'INSERT INTO journal( content, date_updated, date_added ) VALUES ( :content, NOW(), NOW() )';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':content' => $content]);
        return true;
        
    }
    public function create(array $data) {
        $this->query = 'INSERT INTO journal( user_id, author, page_name, image_path, post, thumb_path, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, date_updated, date_added) VALUES ( :user_id, :author, :page_name, :image_path, :post,  :thumb_path, :Model, :ExposureTime, :Aperture, :ISO, :FocalLength, :heading, :content, NOW(), NOW())';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':user_id' => $data['user_id'], 'author' => $data['author'], ':page_name' => $data['page_name'], ':image_path' => $data['image_path'], ':post' => $data['post'], ':thumb_path' => $data['thumb_path'], ':Model' => $data['Model'], ':ExposureTime' => $data['ExposureTime'], ':Aperture' => $data['Aperture'], ':ISO' => $data['ISO'], ':FocalLength' => $data['FocalLength'], ':heading' => $data['heading'], ':content' => trim($data['content'])]);
        return $data['page_name'];
    }

    public function read($page_name = "index.php"): array
    {
        $this->query = 'SELECT id, user_id, author, category, page_name, image_path, post, thumb_path, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM journal WHERE page_name=:page_name ORDER BY myDate DESC';
        $this->stmt = static::pdo()->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':page_name' => $page_name]); // Execute the query with the supplied user's parameter(s):
        $this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->result;
    }

    public static function countAll() {
        $stmt = static::pdo()->prepare("SELECT count(*) FROM journal WHERE post = ?");
        $stmt->execute(['on']);
        return $stmt->fetchColumn();
    }

    public function readBlog($page_name = "index.php"): array
    {
        $this->query = 'SELECT id, user_id, author, page_name, image_path, post, thumb_path, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM journal WHERE page_name=:page_name ORDER BY myDate DESC';
        $this->stmt = static::pdo()->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':page_name' => $page_name]); // Execute the query with the supplied user's parameter(s):
        $data = $this->stmt->fetchAll();
        return $data;
    }

    public function update(array $data) {
        $this->query = 'UPDATE journal SET post=:post, heading=:heading, content=:content, date_updated=NOW() WHERE id =:id';
        $this->stmt = static::pdo()->prepare($this->query);
        $this->result = $this->stmt->execute([':post' => $data['post'], ':heading' => $data['heading'], ':content' => $data['content'], ':id' => $data['id']]);

        return $data['page_name'];
    }

    public function readImagePath($id = NULL) {
        $this->query = "SELECT image_path FROM journal WHERE id=:id";
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        $this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
        return $this->result->image_path;
    }

    public function readThumbPath($id = NULL) {
        $this->query = "SELECT thumb_path FROM journal WHERE id=:id";
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        $this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
        return $this->result->thumb_path;
    }

    public function deleteRecord(int $id = NULL): bool
    {
        $this->query = "DELETE FROM journal WHERE id=:id";
        $this->stmt = static::pdo()->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        return TRUE;
    }

    public function getIntro(string $content = "", int $count = 200): string
    {
        $this->content = $content;
        return substr($this->content, 0, $count) . "...";
    }


}
