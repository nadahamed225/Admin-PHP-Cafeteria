<?php
class Products
{
    private $db;
    private $table = "product";

    public function __construct()
    {
        $this->db = new DB();
    }

    public function getAllProducts()
    {
            
        return $this->db->select($this->table);
    }

    /**
     * insert new product in db
     * @param array $data => fileds and values of product row 
     */
    public function insertProducts($data)
    {
        return $this->db->insert($this->table,$data);
        // $this->db->connect()->insert($this->table,$data);

        
    }


    /**
     * delete product from db 
     * @param int $id => id of product 
     */

     
    public function deleteProduct($id)
    {
        return $this->db->delete($this->table,$id);
    }


    /**
     * get data of product from database
     * @param int $id 
     * @return array 
     */

    public function getProduct($id)
    {
        return $this->db->selectById($this->table,$id);
    }

    public function updateProduct($id,$data)
    {
        return $this->db->update($this->table,$id,$data);
    }

    public function searchByProduct($search)
    {

        return $this->db->rawQuery("SELECT * FROM `{$this->table}` WHERE `name` LIKE '%".$search."%'");

    }

    
}