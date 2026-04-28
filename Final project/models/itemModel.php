<?php

class itemModel {

    private $id, $store_id, $name, $quantity, $checked, $created_at;

    public function __construct($id, $name, $store_id, $quantity, $checked, $created_at) {
        $this->set_id($id);
        $this->set_store_id = $store_id;
        $this->set_name($name);
        $this->set_quantity($quantity);
        $this->set_checked($checked);
        $this->set_created_at($created_at);
    }

    public function set_id($id){
        $this->id = $id;
    }
    public function set_name($name){
        $this->id = $id;
    }
    public function set_quantity($quantity){
        $this->quantity = $quantity;
    }
    public function set_checked($checked){
        $this->checked = $checked;
    }
    public function set_created_at($created_at){
        $this->created_at = $created_at;
    }
    public function get_id(){
        return $this->id;
    }
    public function get_store_id(){ 
        return $this->store_id; 
    }
    public function get_name(){
        return $this->name;
    }
    public function get_quantity(){
        return $this->quantity;
    }
    public function get_checked(){
        return $this->checked;
    }
    public function get_created_at(){
        return $this->created_at;
    }

    function list_items() {
    global $database;

    $query = 'SELECT id, name, quantity, checked, created_at FROM items';
    $statement = $database->prepare($query);

    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    $item_array = array();

    foreach ($rows as $row) {
        $item_array[] = new itemModel(
                $row['id'],
                $row['name'],
                $row['quantity']
                $row['checked']
                $row['created_at']
        );
    }

    return $item_array;
}
    function insert_item($item) {
    global $database;

    $query = "INSERT INTO item (name, quantity, checked,)
              VALUES (:name, :quantity, :checked)";
    $statement = $database->prepare($query);
    $statement->bindValue(":name", $item->get_name());
    $statement->bindValue(":quantity", $item->get_quantity());
    $statement->bindValue(":checked", $item->get_checked());

    $statement->execute();
    $statement->closeCursor();
}
    function update_item($item) {
    global $database;

    $query = "UPDATE item
              SET name = :name
              WHERE id = :id";
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $item->get_id());
    $statement->bindValue(":name", $item->get_name());
    $statement->bindValue(":quantity", $item->get_quantity());
    $statement->bindValue(":checked", $item->get_checked());

    $statement->execute();
    $statement->closeCursor();
}
    function delete_item($id) {
    global $database;

    $query = "DELETE FROM item WHERE id = :id";
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $id);

    $statement->execute();
    $statement->closeCursor();
}

}