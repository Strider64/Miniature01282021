<?php

namespace Miniature;

use JetBrains\PhpStorm\Pure;

class Pagination {

    public int $current_page;
    public int $per_page;
    public int $total_count;


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
            $link .= '<a href="' . $url . '?page=' . $this->previous_page() . '">';
            $link .= "&laquo; Previous</a>";
        }
        return $link;
    }

    #[Pure] public function next_link($url=""): string
    {
        $link = "";
        if($this->next_page() !== false) {
            $link .= '<a href="' . $url . '?page=' . $this->next_page() . '">';
            $link .= "Next &raquo;</a>";
        }
        return $link;
    }

    #[Pure] public function number_links($url=""): string
    {

        for($i=1; $i <= $this->total_pages(); $i++) {
            if($i === $this->current_page) {
                $output .= "<span class=\"selected\">{$i}</span>";
            } else {
                $output .= '<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            }
        }

        return $output;
    }


    #[Pure] public function new_page_links($url): string
    {

        $links = "";
        $links .= "<div class=\"pagination\">";

        if ($this->current_page <= $this->total_pages()) {
            if ($this->current_page === 1) {
                $links .= "<a class='selected' href=\"{$url}?page=1\">1</a>";
            } else {
                $links .= "<a href=\"{$url}?page=1\">1</a>";
            }

            $i = max(2, $this->current_page - 5);
            if ($i > 2) {
                $links .= '<span class="three-dots">' . " ... " . '</span>';
            }
            for (; $i < min($this->current_page + 6, $this->total_pages()); $i++) {
                if ($this->current_page === $i) {
                    $links .= "<a class='selected' href=\"{$url}?page={$i}\">{$i}</a>";
                } else {
                    $links .= "<a href=\"{$url}?page={$i}\">{$i}</a>";
                }

            }
            if ($i !== $this->total_pages()) {
                $links .= '<span class="three-dots">' . " ... " . '</span>';
            }
            if ($i === $this->total_pages()) {
                $links .= "<a href=\"{$url}?page={$this->total_pages()}\">{$this->total_pages()}</a>";
            } elseif ($i === $this->current_page) {
                $links .= "<a class='selected' href=\"{$url}?page={$this->total_pages()}\">{$this->total_pages()}</a>";
            } else {
                $links .= "<a href=\"{$url}?page={$this->total_pages()}\">{$this->total_pages()}</a>";
            }

        }
        $links .= "</div>";
        return $links;
    }

}
