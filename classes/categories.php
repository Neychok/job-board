<?php

class Categories {
    private $id;
    private $title;

    function __construct($id, $title)
    {
        $this->id = $id;
        $this->title = $title;
    }
    function get_id(){
        return $this->id;
    }
    function get_title(){
        return $this->title;
    }
    function set_id($id){
        $this->id = $id;
    }
    function set_title($title){
        $this->title = $title;
    }
}/*
$categories1 = new categories(1, " IT ");
echo $categories1 -> get_id();
echo $categories1 -> get_title();
$categories1 -> set_id(2);
$categories1 -> set_title(" CEO ");
echo $categories1 -> get_id();
echo $categories1 -> get_title();
*/

?>