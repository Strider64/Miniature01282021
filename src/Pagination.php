<?php

namespace Miniature;

use JetBrains\PhpStorm\Pure;

class Pagination {

    public $current_page;
    public $per_page;
    public $total_count;

    public function __construct($page=1, $per_page=20, $total_count=0) {
        $this->current_page = (int) $page;
        $this->per_page = (int) $per_page;
        $this->total_count = (int) $total_count;
    }

    public function offset(): float|int
    {
        return $this->per_page * ($this->current_page - 1);
    }

    #[Pure] public function total_pages(): float|bool
    {
        return ceil($this->total_count / $this->per_page);
    }

    public function previous_page(): bool|int
    {
        $prev = $this->current_page - 1;
        return ($prev > 0) ? $prev : false;
    }

    #[Pure] public function next_page(): bool|int
    {
        $next = $this->current_page + 1;
        return ($next <= $this->total_pages()) ? $next : false;
    }

    #[Pure] public function previous_link($url=""): string
    {
        $link = "";
        if($this->previous_page() !== false) {
            $link .= "<a href=\"{$url}?page={$this->previous_page()}\">";
            $link .= "&laquo; Previous</a>";
        }
        return $link;
    }

    #[Pure] public function next_link($url=""): string
    {
        $link = "";
        if($this->next_page() !== false) {
            $link .= "<a href=\"{$url}?page={$this->next_page()}\">";
            $link .= "Next &raquo;</a>";
        }
        return $link;
    }

    #[Pure] public function number_links($url=""): string
    {
        $output = "";
        for($i=1; $i <= $this->total_pages(); $i++) {
            if($i === $this->current_page) {
                $output .= "<span class=\"selected\">{$i}</span>";
            } else {
                $output .= "<a href=\"{$url}?page={$i}\">{$i}</a>";
            }
        }
        return $output;
    }

    #[Pure] public function page_links($url): string
    {
        $output = "";
        if($this->total_pages() > 1) {
            $output .= "<div class=\"pagination\">";
            $output .= $this->previous_link($url);
            $output .= $this->number_links($url);
            $output .= $this->next_link($url);
            $output .= "</div>";
        }
        return $output;
    }
}
