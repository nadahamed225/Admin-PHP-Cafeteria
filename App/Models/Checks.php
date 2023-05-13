<?php

class Checks
{
    
    private $db;
    public function __construct()
    {
        $this->db = new DB();
    }

    public function users_orders()
    {
        return $this->db->rawQuery("SELECT `user`.`id` ,`user`.`name` , sum(`product`.`price` * `orderdetails`.`quantity`) as `totalprice`  
        FROM `order` , `orderdetails` ,`product` ,`user` WHERE `order`.`id`=`orderdetails`.`orderID` and 
        `orderdetails`.`productID`=`product`.`id` and `order`.`userID`=`user`.`id` GROUP BY `order`.`userID`");
    }

    public function user_orders($idUser)
    {

        if(isset($_SESSION['to'])&&$_SESSION['from']&&!empty($_SESSION['to'])&&!empty($_SESSION['from'])
        )
        {
            $from=$_SESSION['from'];
            $to=$_SESSION['to'];
        return $this->db->rawQuery("SELECT `order`.`id` ,`order`.`date` ,sum(`product`.`price` * `orderdetails`.`quantity`) as `totalprice`  
        FROM `order` , `orderdetails` ,`product` WHERE `order`.`id`=`orderdetails`.`orderID` and 
        `orderdetails`.`productID`=`product`.`id` and  `order`.`userID`={$idUser} and
        DATE(`order`.`date`) BETWEEN '{$from}' and '{$to}'
         GROUP BY `order`.`id`
        ");
        }
        else{
        return $this->db->rawQuery("SELECT `order`.`id` ,`order`.`date` ,sum(`product`.`price` * `orderdetails`.`quantity`) as `totalprice`  
        FROM `order` , `orderdetails` ,`product` WHERE `order`.`id`=`orderdetails`.`orderID` and 
        `orderdetails`.`productID`=`product`.`id` and  `order`.`userID`={$idUser} GROUP BY `order`.`id`
        ");
        }

    }

    
    public function order_details($idOrder)
    {
       return $this->db->rawQuery(" SELECT `product`.`picture`, `product`.`name` ,`orderdetails`.`quantity` ,`product`.`price`  FROM `order` , `orderdetails` ,`product` WHERE   `order`.`id`=`orderdetails`.`orderID` and 
        `orderdetails`.`productID`=`product`.`id` and `order`.`id`={$idOrder}");
    }

    public function filter($from,$to,$user)
    {
        if($user!=0)
        {
        return $this->db->rawQuery("SELECT `user`.`id` ,`user`.`name` ,  sum(`product`.`price` * `orderdetails`.`quantity`) as `totalprice`  
        FROM `order` , `orderdetails` ,`product` ,`user` WHERE `order`.`id`=`orderdetails`.`orderID` and  `order`.`userID`=`user`.`id` and 
        `orderdetails`.`productID`=`product`.`id` and `order`.`userID`={$user} and
         DATE(`order`.`date`) BETWEEN '{$from}' and '{$to}'  GROUP BY `order`.`userID` having `totalprice`>0
         ");
        }else
        {
        
           return $this->db->rawQuery("SELECT `user`.`id` ,`user`.`name` ,
            sum(`product`.`price` * `orderdetails`.`quantity`) as `totalprice`  
            FROM `order` , `orderdetails` ,`product` ,`user` WHERE `order`.`id`=`orderdetails`.`orderID` and  `orderdetails`.`productID`=`product`.`id` and `order`.`userID`=`user`.`id` and  
            DATE(`order`.`date`) BETWEEN '{$from}' and '{$to}' GROUP BY `order`.`userID`");
          

        }
        
    }

}

?>

