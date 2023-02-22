<?php

class Jobs_categories {
    private $id;
    private $job_id;
    private $category_id;

    function __construct($id, $job_id, $category_id)
    {
        $this->id = $id;
        $this->job_id = $job_id;
        $this->category_id = $category_id;
    }
    function get_id(){
        return $this->id;
    }
    function get_job_id(){
        return $this->job_id;
    }
    function get_category_id(){
        return $this->category_id;
    }
    function set_id($id){
        $this->id = $id;
    }
    function set_job_id($job_id){
        $this->job_id = $job_id;
    }
    function set_category_id($category_id){
        $this->category_id = $category_id;
    }
}
/*
$jobs_categories1 = new jobs_categories(1, 1, 1);
echo $jobs_categories1 -> get_id();
echo $jobs_categories1 -> get_job_id();
echo $jobs_categories1 -> get_category_id();
$jobs_categories1 -> set_id(2);
$jobs_categories1 -> set_job_id(2);
$jobs_categories1 -> set_category_id(2);
echo $jobs_categories1 -> get_id();
echo $jobs_categories1 -> get_job_id();
echo $jobs_categories1 -> get_category_id();
*/

?>