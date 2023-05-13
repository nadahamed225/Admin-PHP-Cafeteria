<?php

class Categories 
{

    private $db;
    private $table="category";

    public function __construct()
    {
        $this->db=new DB();
    }

    public function getAllCategories()
    {
        return $this->db->select($this->table);
    }

    public function insertCategory($data)
    {
        
        return $this->db->insert($this->table,$data);
    }

    public function deleteCategory($id)
    {
        // $category=$this->db->connect()->where('id',$id);
        return $this->db->delete($this->table,$id);
    }

    public function getCategory($id)
    {
        return $this->db->selectById($this->table,$id);

    }

    public function updateCategory($id,$data)
    {
        return $this->db->update($this->table,$id,$data);
    }

}



?>