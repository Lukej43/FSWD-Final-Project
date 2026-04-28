<?php
class storeModel {
    private $id, $name, $created_at;

    public function __construct($id, $name, $created_at) {
        $this->set_id($id);
        $this->set_name($name);
        $this->set_created_at($created_at);
    }


    public function set_id($id){
        $this->id = $id;
    }
    public function set_name($name){
        $this->id = $id;
    }
    public function set_created_at($created_at){
        $this->created_at = $created_at;
    }
    public function get_id(){
        return $this->id;
    }
    public function get_id(){
        return $this->id;
    }
    public function get_name(){
        return $this->name;
    }
    public function get_created_at(){
        return $this->created_at;
    }
        function list_stores() {
    global $database;

    $query = 'SELECT id, name, created_at FROM stores';
    $statement = $database->prepare($query);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    return $rows;
}
function list_items_by_store($store_id) {
    global $database;

    $query = 'SELECT id, store_id, name, quantity, checked, created_at
              FROM items
              WHERE store_id = :store_id';

    $statement = $database->prepare($query);
    $statement->bindValue(':store_id', $store_id);
    $statement->execute();
    $rows = $statement->fetchAll();
    $statement->closeCursor();

    return $rows;
}
    function insert_store($store) {
    global $database;

    $query = "INSERT INTO store (name)
              VALUES (:name)";
    $statement = $database->prepare($query);
    $statement->bindValue(":name", $store->get_name());

    $statement->execute();
    $statement->closeCursor();
}
    function update_store($store) {
    global $database;

    $query = "UPDATE store
              SET name = :name
              WHERE id = :id";
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $store->get_id());
    $statement->bindValue(":name", $store->get_name());

    $statement->execute();
    $statement->closeCursor();
}
    function delete_store($id) {
    global $database;

    $query = "DELETE FROM store WHERE id = :id";
    $statement = $database->prepare($query);
    $statement->bindValue(":id", $id);

    $statement->execute();
    $statement->closeCursor();
}
}