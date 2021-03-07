<?php

// menggabungkan kode dari file result_query.php
// yg mana result_query digunakan sebagai
// object yg digunakan untuk hasil
include("result_query.php");

class course {
    public $id;
    public $name;
    public $description;
    public $image_url;
    public $total_exam;
    public $require_correct;
    public $created_by;

    public function __construct(){
    }

    public function set($data){
        $this->id = (int) $data->id;
        $this->name = $data->name;
        $this->description = $data->description;
        $this->image_url = $data->image_url;
        $this->total_exam = $data->total_exam;
        $this->require_correct = $data->require_correct;
        $this->created_by = $data->created_by;
    }

    public function add($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "INSERT INTO course (name,description,image_url,total_exam,require_correct,created_by) VALUES (?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssiii', $this->name,$this->description,$this->image_url,$this->total_exam,$this->require_correct,$this->created_by);
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
        $one = new course();
        $query = "SELECT id,name,description,image_url,total_exam,require_correct,created_by FROM course WHERE id=? LIMIT 1";
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
        $one->name = $result['name'];
        $one->image_url = $result['image_url'];
        $one->description = $result['description'];
        $one->total_exam = $result['total_exam'];
        $one->require_correct = $result['require_correct'];
        $one->created_by = $result['created_by'];
        $result_query->data = $one;
        $stmt->close();
        return $result_query;
    }
 
    public function all($db,$list_query) {
        $result_query = new result_query();
        $all = array();
        $query = "SELECT 
                    id,name,description,image_url,total_exam,require_correct,created_by
                FROM 
                    course
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
            $one = new course();
            $one->id = $result['id'];
            $one->name = $result['name'];
            $one->image_url = $result['image_url'];
            $one->description = $result['description'];
            $one->total_exam = $result['total_exam'];
            $one->require_correct = $result['require_correct'];
            $one->created_by = $result['created_by'];
            array_push($all,$one);
        }
        $result_query->data = $all;
        $stmt->close();
        return $result_query;
    }

    public function update($db) {
        $result_query = new result_query();
        $result_query->data = "ok";
        $query = "UPDATE course SET name = ?,description = ?,image_url = ?,total_exam = ?,require_correct = ?,created_by = ? WHERE id=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('sssiiii', $this->name,$this->description,$this->image_url,$this->total_exam,$this->require_correct,$this->created_by,$this->id);
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
        $query = "DELETE FROM course WHERE id=?";
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