<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class exam_progress {
    public $id;
    public $exam_id;
    public $exam_answer_id;
    public $answer_by;

    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->exam_id = $data->exam_id;
        $this->exam_answer_id = $data->exam_answer_id;
        $this->answer_by = $data->answer_by;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO exam_progress (exam_id,exam_answer_id,answer_by) VALUES (?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iii', $this->exam_id,$this->exam_answer_id,$this->answer_by);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error =  "error at add new course : ".$stmt->error;
            $result_query->data = "not ok";
        }
        $stmt->close();
        return $result_query;
    }
    
    public function one($db) {
        $result_query = new result_query();
        $one = new exam_progress();
        $query = "SELECT id,exam_id,exam_answer_id,answer_by FROM exam_progress WHERE id=? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
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
        $one->id = $result['id'];
        $one->exam_id = $result['exam_id'];
        $one->exam_answer_id = $result['exam_answer_id'];
        $one->answer_by = $result['answer_by'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }

    public function oneAnswered($db) {
        $result_query = new result_query();
        $one = new exam_progress();
        $query = "SELECT id,exam_id,exam_answer_id,answer_by FROM exam_progress WHERE exam_id = ? AND answer_by = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ii', $this->exam_id,$this->answer_by);
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
        $one->id = $result['id'];
        $one->exam_id = $result['exam_id'];
        $one->exam_answer_id = $result['exam_answer_id'];
        $one->answer_by = $result['answer_by'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,exam_id,exam_answer_id,answer_by
                FROM 
                    exam_progress
                WHERE
                    ".$list_query->search_by." LIKE ?
                ORDER BY
                    ".$list_query->order_by." ".$list_query->order_dir." 
                LIMIT ? 
                OFFSET ?";
        $stmt = $db->prepare($query);
        $search = "%".$list_query->search_value."%";
        $offset = $list_query->offset;
        $limit =  $list_query->limit;
        $stmt->bind_param('sii',$search ,$limit, $offset);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query-> error = "error at query all kota : ".$stmt->error;
            $stmt->close();
            return $result_query;
        }
        $rows = $stmt->get_result();
        if($rows->num_rows == 0){
            $stmt->close();
            $result_query->data = $all;
            return $result_query;
        }

        while ($result = $rows->fetch_assoc()){
            $one = new exam_progress();
            $one->id = $result['id'];
            $one->exam_id = $result['exam_id'];
            $one->exam_answer_id = $result['exam_answer_id'];
            $one->answer_by = $result['answer_by'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE exam_progress SET exam_id = ? ,exam_answer_id = ?,answer_by = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iiii', $this->exam_id,$this->exam_answer_id,$this->answer_by,$this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at update one user : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }

    public function reset($db,$course_id,$user_id) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE ep FROM exam_progress ep INNER JOIN exam e ON e.id = ep.exam_id WHERE e.course_id = ? AND ep.answer_by = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('ii', $course_id, $user_id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one user : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }

    public function delete($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE FROM exam_progress WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $this->id);
        $stmt->execute();
        if ($stmt->error != ""){
            $result_query->error = "error at delete one user : ".$stmt->error;
            $result_query->data = "not ok";
            $stmt->close();
            return $result_query;
        }
        $stmt->close();
        return $result_query;
    }
}


?>