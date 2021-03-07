<?php

// class list query
// ini adalah class yg nantinya akan dijadikan
// object untuk query data-data yg banyak
// ke database
class list_query {

    // variabel search by
    public $search_by;
    
    // variabel search value
    public $search_value;

    // variabel order by
    public $order_by;

    // variabel order dir
    public $order_dir;

    // variabel offset
    public $offset;

    // variabel limit
    public $limit;

    // konstruksi
    // fungsi yg akan dipanggil saat
    // membuat object
    public function __construct(){
    }

    public function set($data){
        $this->search_by = $data->search_by;
        $this->search_value = $data->search_value;
        $this->order_by = $data->order_by;
        $this->order_dir = $data->order_dir;
        $this->offset = (int)$data->offset;
        $this->limit = (int)$data->limit;
    }
}

?>