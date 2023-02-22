<?php

class Jobs {
    private $id;
    private $user_id;
    private $title;
    private $status;
    private $description;
    private $salary;
    private $date_posted;
    private $location;

    function __construct($id, $user_id, $title, $status, $description, $salary, $date_posted, $location)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->title = $title;
        $this->status = $status;
        $this->description = $description;
        $this->salary = $salary;
        $this->date_posted = $date_posted;
        $this->location = $location;
    }

    function get_id(){
        return $this->id;
    }
    function get_user_id(){
        return $this->user_id;
    }
    function get_title(){
        return $this->title;
    }
    function get_status(){
        return $this->status;
    }
    function get_description(){
        return $this->description;
    }
    function get_salary(){
        return $this->salary;
    }
    function get_date_posted(){
        return $this->date_posted;
    }

    function get_location(){
        return $this->location;
    }
    
    function set_id($id){
        $this->id = $id;
    }
    function set_user_id($user_id){
        $this->user_id = $user_id;
    }
    function set_title($title){
        $this->title = $title;
    }
    function set_status($status){
        $this->status = $status;
    }
    function set_description($description){
        $this->description = $description;
    }
    function set_salary($salary){
        $this->salary = $salary;
    }
    function set_date_posted($date_posted){
        $this->date_posted = $date_posted;
    }

    function set_location($location){
        $this->location = $location;
    }
    
}
/*
$jobs1 = new jobs(1, 1, "title2", "ok", "description", 100, "20/09/2000");
echo $jobs1 -> get_id();
echo $jobs1 -> get_user_id();
echo $jobs1 -> get_title();
echo $jobs1 -> get_status();
$jobs1 -> set_id(3);
$jobs1 -> set_user_id(3);
echo $jobs1 -> get_id();
echo $jobs1 -> get_user_id();
echo $jobs1 -> get_title();
echo $jobs1 -> get_status();
*/

?>