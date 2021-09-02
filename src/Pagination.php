<?php

namespace Miniature;

use JetBrains\PhpStorm\Pure;

class Pagination {

    public int $current_page;
    public int $per_page;
    public int $total_count;
    static public string $links = "";


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

    public function previous_link($url=""): string
    {
        if($this->previous_page() !== false) {
            static::$links .= '<a href="' . $url . '?page=' . $this->previous_page() . '">';
            static::$links .= "&laquo; Previous</a>";
        }
        return static::$links;
    }

    public function next_link($url=""): string
    {

        if($this->next_page() !== false) {
            static::$links .= '<a href="' . $url . '?page=' . $this->next_page() . '">';
            static::$links .= "Next &raquo;</a>";
        }
        return static::$links;
    }

    #[Pure] public function number_links($url=""): string
    {

        for($i=1; $i <= $this->total_pages(); $i++) {
            if($i === $this->current_page) {
                static::$links .= "<span class=\"selected\">{$i}</span>";
            } else {
                static::$links .= '<a href="' . $url . '?page=' . $i . '">' . $i . '</a>';
            }
        }

        return static::$links;
    }


    #[Pure] public function new_page_links($url): string
    {


        static::$links .= "<div class=\"pagination\">";

        $this->previous_link();
        if ($this->current_page <= $this->total_pages()) {
            if ($this->current_page === 1) {
                static::$links .= "<a class='selected' href=\"{$url}?page=1\">1</a>";
            } else {
                static::$links .= "<a href=\"{$url}?page=1\">1</a>";
            }

            $i = max(2, $this->current_page - 5);
            if ($i > 2) {
                static::$links .= '<span class="three-dots">' . " ... " . '</span>';
            }
            for (; $i < min($this->current_page + 6, $this->total_pages()); $i++) {
                if ($this->current_page === $i) {
                    static::$links .= "<a class='selected' href=\"{$url}?page={$i}\">{$i}</a>";
                } else {
                    static::$links .= "<a href=\"{$url}?page={$i}\">{$i}</a>";
                }

            }
            if ($i !== $this->total_pages()) {
                static::$links .= '<span class="three-dots">' . " ... " . '</span>';
            }
            if ($i === $this->total_pages()) {
                static::$links .= "<a href=\"{$url}?page={$this->total_pages()}\">{$this->total_pages()}</a>";
            } elseif ($i === $this->current_page) {
                static::$links .= "<a class='selected' href=\"{$url}?page={$this->total_pages()}\">{$this->total_pages()}</a>";
            } else {
                static::$links .= "<a href=\"{$url}?page={$this->total_pages()}\">{$this->total_pages()}</a>";
            }

        }
        $this->next_link();
        static::$links .= "</div>";
        return static::$links;
    }

}
