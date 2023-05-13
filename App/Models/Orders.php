<?php 

class Orders
{
    private $db;
    private $table = "order";

    public function __construct()
    {
        $this->db = new DB();
    }


    public function getAllOrders()
    {
        return $this->db->select($this->table);
    }
    
    /**
     * insert new product in db
     * @param array $data => fileds and values of product row 
     */
    public function insertOrder($data)
    {
        return $this->db->insert($this->table,$data);
    }

    public function updateStatus($id,$data)
    {
        return $this->db->update($this->table,$id,$data);
    }

    public function users_orders()
    {
        return $this->db->rawQuery("SELECT `order`.`id`as`o_id`,`user`.`id` ,`user`.`name` , `user`.`phone`,`order`.`date`,`order`.`roomNumber`,`order`.`totalPrice`,
        `orderdetails`.`quantity`,`product`.`picture`,`product`.`name` as `p_name` , 
        `order`.`status`
        FROM `order` , `orderdetails` ,`product` ,`user` WHERE `order`.`id`=`orderdetails`.`orderID` and 
        `orderdetails`.`productID`=`product`.`id` and `order`.`userID`=`user`.`id` GROUP BY `orderdetails`.`orderID`");
    }

    public function order_details()
    {

       return $this->db->rawQuery(" SELECT `order`.`id`as`o_id`,`user`.`id`,`product`.`picture`, `product`.`name` ,`orderdetails`.`totalPriceProduct`,`orderdetails`.`quantity`  FROM `order` , `orderdetails` ,`product`,`user` WHERE   `order`.`id`=`orderdetails`.`orderID` and
        `orderdetails`.`productID`=`product`.`id` and `order`.`userID`=`user`.`id`" ) ;
    }

}