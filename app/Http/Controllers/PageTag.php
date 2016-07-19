<?php

namespace App\Http\Controllers;

class PageTag
{
    protected $row;
    protected $column;
    protected $page = 0;
    protected $pagesize;

    protected $listnum;

    public $start, $end;

    public function __construct($row, $column, $allcols, $page) {
       $this->row = $row;
       $this->listnum = $row;
       $this->column = $column;
       $this->page = $page;
       $this->pagesize = ceil($allcols/$row);

       if($this->page == 0)
       {
           $this->row = $allcols;
       }

       $this->start = floor(($page-1)/$column)*$column+1;
       $this->end = $this->start + $column;
       if($this->end > $this->pagesize + 1 )
       {
           $this->end = $this->pagesize + 1;
       }
    }

    public function isAvaliable() {
        if($this->page != 0 && $this->pagesize > 1)
        {
            return true;
        }

        return false;
    }

    public function getRow()
    {
        return $this->row;
    }
    
    public function getColumns()
    {
        return $this->column;
    }

    public function setPage($page)
    {
        $this->page = $page;

        $this->start = floor(($page-1)/$this->column)*$this->column+1;
        $this->end = $this->start + $this->column;
        if($this->end > $this->pagesize + 1 )
        {
            $this->end = $this->pagesize + 1;
        }
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getPageSize()
    {
        return $this->pagesize;
    }

    public function setListNum($listnum)
    {
        $this->listnum = $listnum;
    }

    public function getListNum()
    {
        return $this->listnum;
    }
}
