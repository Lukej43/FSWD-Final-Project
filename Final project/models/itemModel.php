<?php

class itemModel
{

    private $id, $store_id, $name, $quantity, $checked, $created_at;

    public function __construct($id, $name, $store_id, $quantity, $checked, $created_at)
    {
        $this->set_id($id);
        $this->set_store_id($store_id);
        $this->set_name($name);
        $this->set_quantity($quantity);
        $this->set_checked($checked);
        $this->set_created_at($created_at);
    }

    public function set_id($id)
    {
        $this->id = $id;
    }
    public function set_store_id($store_id)
    {
        $this->store_id = $store_id;
    }
    public function set_name($name)
    {
        $this->name = $name;
    }
    public function set_quantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function set_checked($checked)
    {
        $this->checked = $checked;
    }
    public function set_created_at($created_at)
    {
        $this->created_at = $created_at;
    }
    public function get_id()
    {
        return $this->id;
    }
    public function get_store_id()
    {
        return $this->store_id;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function get_quantity()
    {
        return $this->quantity;
    }
    public function get_checked()
    {
        return $this->checked;
    }
    public function get_created_at()
    {
        return $this->created_at;
    }

}