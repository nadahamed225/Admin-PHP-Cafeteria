<?php


class ChecksController extends controller 
{
    private $conn;
    private $users;

    public function __construct()
    {
        $this->conn = new Checks();
        $this->users=new Users();
    
    }


    public function index()
    {
        $data['usersOrders']=$this->conn->users_orders();
        $data['users']=$this->users->getAllUsersByRole(0);
        if(isset($_SESSION['from'])&&isset($_SESSION['to']))
        {
            unset($_SESSION['from']);
            unset($_SESSION['to']);
        }
        if(isset($_POST['filter']))
        {
            if($_POST['from']>$_POST['to'])
            {
                $data['error']="date to shouldn`t be less than from!";
            }else{
            $_SESSION['from']=$_POST['from'];
            $_SESSION['to']=$_POST['to'];
            $data['usersOrders']=$this->conn->filter($_POST['from'],$_POST['to'],$_POST['userId']);
            $data['from']=$_POST['from'];
            $data['to']=$_POST['to'];
            $data['userId']=$_POST['userId'];
            }

        }
        return $this->view('checks/index',$data);
    }

    public function ordersUser($idUser)
    {
        $data=$this->conn->user_orders($idUser);
        print_r(json_encode($data));
    }

    public function orderDetails($idOrder)
    {
        $data=$this->conn->order_details($idOrder);
        $result =array();
        foreach($data as $order)
        {
            array_push($result,
            [
                "quantity"=>$order["quantity"],
                "price"=>$order["price"],
                "name"=>$order["name"],
                "picture"=>base64_encode($order["picture"])
            ]);

        }
      
        print_r(json_encode($result));
    }

}


?>