<?php

namespace Miniature;

use JetBrains\PhpStorm\Pure;
use PDO;

class Pagination extends Journal {

    public $currentPage;
    public $perPage;
    public $totalCount;
    public $result = NULL;
    protected $query = NULL;
    protected $stmt = NULL;

    public function __construct($currentPage = 1, $perPage = 20, $totalCount = 0) {
        $this->currentPage = (int) $currentPage;
        $this->perPage = (int) $perPage;
        $this->totalCount = (int) $totalCount;
    }

    public function offset(): float|int
    {
        return $this->perPage * ($this->currentPage - 1);
    }

    #[Pure] public function totalPages() {
        return ceil($this->totalCount / $this->perPage);
    }

    public function previousPage(): bool|int
    {
        $prev = $this->currentPage - 1;
        return ($prev > 0) ? $prev : false;
    }

    #[Pure] public function nextPage(): bool|int
    {
        $next = $this->currentPage + 1;
        return ($next <= $this->totalPages()) ? $next : false;
    }

    #[Pure] public function previousLink($url = ""): string
    {
        $link = "";
        if ($this->previousPage() !== false) {
            $link .= "<a class=\"menuExit\" href=\"{$url}?page={$this->previousPage()}\">";
            $link .= "&laquo; Previous</a>";
        }
        return $link;
    }

    #[Pure] public function nextLink($url = ""): string
    {
        $link = "";
        if ($this->nextPage() !== false) {
            $link .= "<a class=\"menuExit\" href=\"{$url}?page={$this->nextPage()}\">";
            $link .= "Next &raquo;</a>";
        }
        return $link;
    }

    #[Pure] public function numberLinks($url = ""): string
    {
        $output = "";
        for ($i = 1; $i <= $this->totalPages(); $i++) {
            if ($i === $this->currentPage) {
                $output .= "<span class=\"selected\">{$i}</span>";
            } else {
                $output .= "<a class=\"menuExit\" href=\"{$url}?page={$i}\">{$i}</a>";
            }
        }
        return $output;
    }

    #[Pure] public function pageLinks($url): string
    {
        $output = "";
        if ($this->totalPages() > 1) {
            $output .= "<div class=\"pagination\">";
            $output .= $this->previousLink($url);
            $output .= $this->numberLinks($url);
            $output .= $this->nextLink($url);
            $output .= "</div>";
        }
        return $output;
    }

    public function readPage(): array
    {

        $this->query = 'SELECT id, user_id, author, page, thumb_path, path, post, page, Model, ExposureTime, Aperture, ISO, FocalLength, heading, content, DATE_FORMAT(date_added, "%M %e, %Y") as date_added, date_added as myDate FROM cms ORDER BY myDate DESC LIMIT :perPage OFFSET :blogOffset';
        $this->stmt = static::pdo()->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':perPage' => $this->perPage, ':blogOffset' => $this->offset()]); // Execute the query with the supplied data:
        $this->result = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->result;
    }

}
