<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class exam_result {
    public $course_id;
    public $user_id;
    public $total_answered;
    public $total_correct;

    public function __construct(){
    }

    public function set($data){
        $this->course_id = $data->course_id;
        $this->user_id = $data->user_id;
        $this->total_answered = $data->total_answered;
        $this->total_correct = $data->total_correct;
    }
 
    public function result($db) {
        $result_query = new result_query();
        $one = new exam_result();
        $query = "SELECT
            IFNULL(SUM(1),0) as total_answered,
            IFNULL(SUM(CASE exam_progress.exam_answer_id WHEN exam_solution.exam_answer_id THEN 1 ELSE 0 END),0) as correct
        FROM
            exam_progress
        INNER JOIN
            exam_solution
        ON
            exam_solution.exam_id = exam_progress.exam_id
        INNER JOIN
            exam
        ON
            exam.id = exam_progress.exam_id
        WHERE
            exam_progress.answer_by = ?
        AND
            exam.course_id = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ii', $this->user_id,$this->course_id);
        $stmt->execute();      
        if ($stmt->error != ""){
            $result_query-> error = "error at query one user: ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();
            return $result_query;
        }
        $result = $rows->fetch_assoc();
        $one->course_id = $this->course_id;
        $one->user_id = $this->user_id;
        $one->total_answered = (int) $result['total_answered'];
        $one->total_correct = (int) $result['correct'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
  
}


?>