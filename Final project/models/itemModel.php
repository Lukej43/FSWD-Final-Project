<?php

class itemModel {

    private $id, $store_id, $name, $quantity, $checked, $created_at;

    public function __construct($id, $name, $created_at) {
        $this->set_id($id);
        $this->set_name($name);
        $this->set_quantity($quantity);
        $this->set_checked($checked);
        $this->set_created_at($created_at);
    }

    public function set_id($id){
        this->id = $id;
    }
    public function set_name($name){
        this->id = $id;
    }
    public function set_quantity($quantity){
        this->quantity = $quantity;
    }
    public function set_checked($checked){
        this->checked = $checked;
    }
    public function set_created_at($created_at){
        this->created_at = $created_at;
    }

}