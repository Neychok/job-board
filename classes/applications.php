<?php

class Applications {
    private $id;
    private $user_id;
    private $job_id;
    private $custom_message;
    private $cv;

    function __construct($id, $user_id, $job_id, $custom_message, $cv)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->job_id = $job_id;
        $this->custom_message = $custom_message;
        $this->cv = $cv;
    }
    function get_id(){
        return $this->id;
    }
    function get_user_id(){
        return $this->user_id;
    }
    function get_job_id(){
        return $this->job_id;
    }
    function get_custom_message(){
        return $this->custom_message;
    }
    function get_cv(){
        return $this->cv;
    }
    function set_id($id){
        $this->id = $id;
    }
    function set_user_id($user_id){
        $this->user_id = $user_id;
    }
    function set_job_id($job_id){
        $this->job_id = $job_id;
    }
    function set_custom_message($custom_message){
        $this->custom_message = $custom_message;
    }
    function set_cv($cv){
        $this->cv = $cv;
    }
}/*
$applications1 = new applications(1, 1, 1, "please hire me\n", "cv info\n");
echo $applications1 -> get_id();
echo $applications1 -> get_user_id();
echo $applications1 -> get_job_id();
echo $applications1 -> get_custom_message();
echo $applications1 -> get_cv();
$applications1 -> set_id(3);
$applications1 -> set_user_id(3);
$applications1 -> set_job_id(3);
$applications1 -> set_custom_message("dont hire me\n");
$applications1 -> set_cv("NULL\n");
echo $applications1 -> get_id();
echo $applications1 -> get_user_id();
echo $applications1 -> get_job_id();
echo $applications1 -> get_custom_message();
echo $applications1 -> get_cv();
*/
?>