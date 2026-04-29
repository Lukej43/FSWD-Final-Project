<?php
class storeModel
{
    private $id, $name, $created_at;

    public function __construct($id, $name, $created_at)
    {
        $this->set_id($id);
        $this->set_name($name);
        $this->set_created_at($created_at);
    }


    public function set_id($id)
    {
        $this->id = $id;
    }
    public function set_name($name)
    {
        $this->name = $name;
    }
    public function set_created_at($created_at)
    {
        $this->created_at = $created_at;
    }
    public function get_name()
    {
        return $this->name;
    }
    public function get_created_at()
    {
        return $this->created_at;
    }
}