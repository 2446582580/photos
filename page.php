<?php
function convent_page_info($total_rows, $current_page_index, $per_page_rows, $num_pages=8)
{
    $pages = ceil($total_rows / $per_page_rows);
    $current = $current_page_index > $pages ? $pages : $current_page_index;
    $o = new Pagination($current, $pages, $num_pages);
    return $o->pagination();
}

class Pagination
{
    var $data = [];

    public function __construct($current, $pages, $pageSize)
    {
        $this->data = [
            'pageSize' => +$pageSize,
            'first' => 0,
            'tail' => 0,
            'beg' => 0,
            'end' => 0,
            'current' => +$current,
            'next' => 0,
            'prev' => 0,
            'pages' => +$pages
        ];
    }

    public function pagination()
    {
        if ($this->pages() <= $this->pageSize()) {
            return $this->single();
        }
        if ($this->pageSize() % 2 === 0) {
            return $this->even();
        } else {
            return $this->odd();
        }
    }

    function pages()
    {
        return $this->property('pages');
    }

    function pageSize()
    {
        return $this->property('pageSize');
    }

    function current()
    {
        return $this->property('current');
    }

    function property($name)
    {
        return $this->data[$name] ? $this->data[$name] : null;
    }

    public function even()
    {
        //偶数分页
        $pageSize = $this->pageSize();
        $left = floor($pageSize / 2);
        $right = $left - 1;
        return $this->page($left, $right);
    }

    function odd()
    {
//        奇数分页
        $pageSize = $this->pageSize();
        $offset = floor($pageSize / 2);
        return $this->page($offset, $offset);
    }

    function page($left, $right)
    {
        $pageSize = $this->pageSize();
        $pages = $this->pages();
        $current = $this->current();
        $beg = $current - $left;
        $end = $current + $right;
        $data = $this->data;
        if ($beg <= 1) {
            $data['beg'] = 1;
            $data['end'] = $pageSize;
            $data['next'] = $current + 1;
            $data['tail'] = $pages;
        } elseif ($end >= $pages) {
            $data['end'] = $pages;
            $beg = $pages - $right - $left;
            $data['beg'] = $beg;
            $data['prev'] = $current - 1;
            $data['first'] = 1;
        } else {
            $data['first'] = 1;
            $beg = $current - $left;
            $data['prev'] = $current - 1;
            $data['beg'] = $beg;
            $end = $current + $right;
            $data['end'] = $end;
            $data['next'] = $current + 1;
            $data['tail'] = $pages;
        }
        return $data;
    }

    function single()
    {
        $data = $this->data;
        $data['beg'] = 1;
        $data['end'] = $data['pages'];
        return $data;
    }
}