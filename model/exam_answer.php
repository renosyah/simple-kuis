<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class exam_answer {
    public $id;
    public $exam_id;
    public $label;
    public $text;

    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->exam_id = $data->exam_id;
        $this->label = $data->label;
        $this->text = $data->text;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO exam_answer (exam_id,label,text) VALUES (?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('iss', $this->exam_id,$this->label,$this->text);
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
        $one = new exam_answer();
        $query = "SELECT id,exam_id,label,text FROM exam_answer WHERE id=? LIMIT 1";
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
        $one->label = $result['label'];
        $one->text = $result['text'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,exam_id,label,text
                FROM 
                    exam_answer
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
            $one = new exam_answer();
            $one->id = $result['id'];
            $one->exam_id = $result['exam_id'];
            $one->label = $result['label'];
            $one->text = $result['text'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE exam_answer SET exam_id = ? ,label = ?,text = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('issi', $this->exam_id,$this->label,$this->text,$this->id);
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
    
    public function delete($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "DELETE FROM exam_answer WHERE id=?";
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