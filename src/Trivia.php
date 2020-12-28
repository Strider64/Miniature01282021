<?php

namespace Miniature;

use PDO;
use Miniature\Database as DB;

class Trivia {

    public $schedule = null;

    static protected function pdo() {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        return $pdo;
    }

    static public function countAll() {
        $stmt = static::pdo()->prepare("SELECT count(*) FROM trivia_questions WHERE hidden = ?");
        $stmt->execute(['no']);
        $count = $stmt->fetchColumn();
        return $count;
    }

    static public function read() {
        $query = 'SELECT * FROM trivia_questions WHERE hidden=:hidden';
        $stmt = static::pdo()->prepare($query); // Prepare the query:
        $stmt->execute([':hidden' => 'no']); // Execute the query with the supplied user's parameter(s):
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    static public function updateYear() {
        $days = new \DateTime("now", new \DateTimeZone("America/Detroit"));

        $records = static::read();
        foreach ($records as $record) {
            $play_date = $days->format("Y-m-d");

            $day_of_week = $days->format("N");
            $day_of_year = $days->format("z");
            $query = "UPDATE trivia_questions SET play_date=:play_date, day_of_week=:day_of_week, day_of_year=:day_of_year WHERE id=:id";
            $stmt = static::pdo()->prepare($query);
            $stmt->execute([':play_date' => $play_date, ':day_of_week' => $day_of_week, ':day_of_year' => $day_of_year, ':id' => $record['id']]);
            $days->modify("+1 day");
        }
    }

    public function resetPlaydate() {
        $this->schedule = new \DateTime("now", new \DateTimeZone("America/Detroit"));
        $this->records = static::read();
        foreach ($this->records as $record) {
            $this->query = "UPDATE trivia_questions SET play_date=:play_date, day_of_week=:day_of_week WHERE id=:id";
            $this->stmt = static::pdo()->prepare($this->query);
            $today = $this->schedule->format("Y-m-d H:i:s");
            $day_of_week = $this->schedule->format('N');
            $this->stmt->execute([':play_date' => $today, ':day_of_week' => $day_of_week, ':id' => $record['id']]);
        }
    }

    static public function readData($max_questions, $newOffset) {
        $query = "SELECT * FROM trivia_questions WHERE hidden=:hidden LIMIT :max_questions OFFSET :quizOffset";
        $stmt = static::pdo()->prepare($query);
        $stmt->execute([':hidden' => 'no', ':max_questions' => $max_questions, ':quizOffset' => $newOffset]);
        $result = $stmt->fetchALL(PDO::FETCH_ASSOC);
        return $result;
    }

    static public function insertHighScores($data) {
        $query = 'INSERT INTO hs_table( player, score, played, correct, totalQuestions, day_of_year ) VALUES ( :player, :score, NOW(), :correct, :totalQuestions, :day_of_year )';
        $stmt = static::pdo()->prepare($query);

        $result = $stmt->execute([':player' => $data['player'], ':score' => $data['score'], ':correct' => $data['correct'], ':totalQuestions' => $data['totalQuestions'], ':day_of_year' => $data['day_of_year']]);
        return $result;
    }

    static public function clearTable() {


        $sql = "DELETE FROM hs_table WHERE played < CURDATE()";

        $stmt = static::pdo()->prepare($sql);

        return $stmt->execute();
    }

}
