<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace system\helper;

/**
 * Description of Pagination
 *
 * @author Masfu Hisyam
 */
class Pagination {

    private $limit;
    private $adjacents;
    private $rows;
    private $page;

    function __construct($rows, $page, $limit = 10, $adjacents = 10) {
        $this->limit = $limit;
        $this->rows = $rows;
        $this->adjacents = $adjacents;
        $this->setPage($page);
    }

    public function getLimit() {
        return $this->limit;
    }

    public function getAdjacents() {
        return $this->adjacents;
    }

    public function getRows() {
        return $this->rows;
    }

    public function getPage() {
        return $this->page;
    }

    public function setLimit($limit) {
        $this->limit = $limit;
    }

    public function setAdjacents($adjacents) {
        $this->adjacents = $adjacents;
    }

    public function setRows($rows) {
        $this->rows = $rows;
    }

    public function setPage($page) {
        if ($page == 0) {
            $this->page = 1;
        } else {
            $this->page = $page;
        }
    }

    public function render() {
        $pagination = '';
        //if no page var is given, default to 1.
        $prev = $this->page - 1;       //previous page is page - 1
        $next = $this->page + 1;       //next page is page + 1
        $prev_ = '';
        $first = '';
        $lastpage = ceil($this->rows / $this->limit);
        $next_ = '';
        $last = '';
        if ($lastpage > 1) {

            //previous button
            if ($this->page > 1)
                $prev_.= "<li><a href=\"?page=$prev\">previous</a></li>";
            else {
                $pagination.= "<li class=\"disabled\"><a href=\"#\">previous</a></li>";	
            }

            //pages	
            if ($lastpage < 5 + ($this->adjacents * 2)) { //not enough pages to bother breaking it up
                $first = '';
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $this->page)
                        $pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                    else
                        $pagination.= "<li><a href=\"?page=$counter\">$counter</a></li>";
                }
                $last = '';
            }
            elseif ($lastpage > 3 + ($this->adjacents * 2)) { //enough pages to hide some
                //close to beginning; only hide later pages
                $first = '';
                if ($this->page < 1 + ($this->adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($this->adjacents * 2); $counter++) {
                        if ($counter == $this->page)
                            $pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                        else
                            $pagination.= "<li><a href=\"?page=$counter\">$counter</a></li>";
                    }
                    $last.= "<li><a href=\"?page=$lastpage\">Last</a></li>";
                }

                //in middle; hide some front and some back
                elseif ($lastpage - ($this->adjacents * 2) > $this->page && $this->page > ($this->adjacents * 2)) {
                    $first.= "<li><a href=\"?page=1\">First</a></li>";
                    for ($counter = $this->page - $this->adjacents; $counter <= $this->page + $this->adjacents; $counter++) {
                        if ($counter == $this->page)
                            $pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                        else
                            $pagination.= "<li><a href=\"?page=$counter\">$counter</a><li>";
                    }
                    $last.= "<li><a href=\"?page=$lastpage\">Last</a></li>";
                }
                //close to end; only hide early pages
                else {
                    $first.= "<li><a  href=\"?page=1\">First</a></li>";
                    for ($counter = $lastpage - (2 + ($this->adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $this->page)
                            $pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
                        else
                            $pagination.= "<li><a href=\"?page=$counter\">$counter</a></li>";
                    }
                    $last = '';
                }
            }
            if ($this->page < $counter - 1)
                $next_.= "<li><a  href=\"?page=$next\">next</a></li>";
            else {
                $pagination.=  "<li class=\"disabled\"><a href=\"#\">next</a></li>";	
            }
            $pagination = "<ul class=\"pagination\">" . $first . $prev_ . $pagination . $next_ . $last;
            //next button

            $pagination.= "</ul>\n";
        }

        return $pagination;
    }

}
