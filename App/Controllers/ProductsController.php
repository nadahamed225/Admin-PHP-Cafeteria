<?php

class ProductsController extends Controller 
{
    private $conn;
    private $conn_users;
    public $id_user;
    public $errors=[];
    public $formatData=[];
    public function __construct()
    {
        $this->conn = new Products();
        $this->conn_users = new Users();
        $this->conn_category = new Categories();

    }
    public function index()
    {
        $data['products'] = $this->conn->getAllProducts();
        $data['users']=$this->conn_users->getAllUsersByRole(0);  

        return $this->view('products/index',$data);
    }
    public function getIdUser($id){
        $result = [
            'userId' => $id,
        ];
        $this->id_user=$id;
        echo json_encode($result);
    }


    
    public function add()
    {
        $data['categories']=$this->conn_category->getAllCategories(); 
        return $this->view('products/add',$data);
    }

    public function store()
    {
        if(isset($_POST)&&isset($_FILES))
        {
            $data['categories']=$this->conn_category->getAllCategories(); 
            if (!empty($_FILES['picture']['name'])) {
                $imageName = $_FILES['picture']['name'];
                $tmp_file = $_FILES['picture']['tmp_name'];
                $imageType = $_FILES['picture']['type'];
            
                // Check if the uploaded file is an image (JPEG or PNG)
                if ($imageType === 'image/jpeg' || $imageType === 'image/png') {
                    $picture = file_get_contents($tmp_file);
                } else {
                    $errors['picture'] = 'Invalid image format. Only JPEG and PNG are allowed.';
                }
            } else {
                $errors['picture'] = 'Product must have an image.';
            }
            
            $name = $_POST['name'];
            if(isset($name) and empty($name)){
                $errors['name']='Product must have name';
            }else{
                $formatData['name']=$name;
            }
            $availability  = $_POST['availability'];
            $price = $_POST['price'];
            if(isset($price) and empty($price)){
                $errors['price']='Product must have pirce';
            }else{
                $formatData['price']=$price;
            }
            if($price<0){
                $errors['price']='price must not  be negative';
            }else{
                $formatData['price']=$price;
            }
            $categoryID = $_POST['categoryID'];
            if(isset($categoryID) and empty($categoryID)){
                $errors['categoryID']='Product must added to category';
            }else{
                $formatData['categoryID']=$categoryID;
            }
            if($errors){
                $data['errors']=$errors;
                $data['formatData']=$formatData;
                
                return $this->view('products/add',$data);
            }
            $this->conn = new Products();
            $dataInsert = Array ( "name" => $name ,
                            "availability" => $availability  ,
                            "price" => $price ,
                             "picture" => $picture,
                            "categoryID" => $categoryID
                            );

            if($this->conn->insertProducts($dataInsert))
            {
                $data['success'] = "Data Added Successfully";
                return $this->index();
            }
            else 
            {
                $data['error'] = "Error";
                return $this->view('products/add',$data);
            }
        }
        return $this->view('products/add');
    }




    public function edit($id)
    {
        // var_dump($this->conn->getProduct($id));
        $data['categories']=$this->conn_category->getAllCategories(); 
        $data['row'] = $this->conn->getProduct($id);
        return $this->view('products/edit',$data);
    }

    public function update()
    {
        {
            $tmp_file = $_FILES['picture']['tmp_name'];
            $picture= file_get_contents($tmp_file);
            $name = $_POST['name'];
            $availability  = $_POST['availability'];
            $price = $_POST['price'];
            $categoryID = $_POST['categoryID'];
            $id=$_POST['id'];
            $this->conn = new Products();
            $dataInsert = Array ( "name" => $name ,
                                    "availability" => $availability  ,
                                    "price" => $price ,
                                    "picture" => $picture,
                                    "categoryID" => $categoryID
            );
            // data of product
            if($this->conn->updateProduct($id,$dataInsert))
            {
                $data['success'] = "Updated Successfully";
                $data['row'] = $this->conn->getProduct($id);
                $data['products'] = $this->conn->getAllProducts();

                return $this->view('products/index',$data);
            }
            else 
            {
                $data['error'] = "Error";
                $data['row'] = $this->conn->getProduct($id);
                return $this->view('products/edit',$data);
            }
        }
        redirect('home/index');
    }



    
    public function delete($id)
    {
        if($this->conn->deleteProduct($id))
        {
            $data['success'] = "Product Have Been Deleted";
            return $this->index();
        }
        else 
        {
            $data['error'] = "Error";
            return $this->view('products/delete',$data);
        }
    }


    
    //////////////////////////////////////////////////////////
    public function home()
    {
        // session_start();
        unset($_SESSION["cart"]);
        $data['products'] = $this->conn->getAllProducts();
        $data['users']=$this->conn_users->getAllUsersByRole(0);  

        $dsn = "mysql:host=127.0.0.1;dbname=cafeteria;port=8111;";
        $username = "root";
        $password = "";
        $pdo = new PDO($dsn, $username, $password);

        $query = "select * from `room`";
        $select_stmt = $pdo->prepare($query);
        $res=$select_stmt->execute();
        $dataroom = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['rooms']=$dataroom;
        ///search
        if($_SERVER['REQUEST_METHOD']=='POST')
        {
            $data['search']=$_POST['search_prod'];
            $data['products'] =$this->conn->searchByProduct($_POST['search_prod']);
            if(!$data['products'] )
            {
                $data['notfound']="No Result";
            }

        }
        return $this->view('home/index',$data);
    }

    public function delectfromcart($id,$total)
    {
        $totalPrice=$total;
        $pro=$this->conn->getProduct($id);
        if($pro)
        {
            
            // Check if the cart exists in the session
            if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $i => $result){
                if($pro['name']==$result['name']){
                    $totalPrice-=$_SESSION['cart'][$i]['price'];
                    unset($_SESSION['cart'][$i]);
                    $result = [
                        'name' => $result["name"],
                        'price' => $result["price"],
                        'totalPrice' =>$totalPrice,
                        'quantity' =>$result['quantity'],
                        'i'=>$_SESSION['cart']
                    ];
                    
                    echo json_encode($result);
                    
                }  
              }
            }
        }
        
        else 
        {
            $data['error'] = "Error";
        }
    }
    
    public function cart($id,$quantity,$total)
    {
        $totalPrice=$total;
        $pro=$this->conn->getProduct($id);
        if($pro)    
        {
            
            // Check if the cart exists in the session
            if (!isset($_SESSION['cart'])) {
            // If the cart doesn't exist, create an empty array
            $_SESSION['cart'] = array();
            }
            
            $i=0;
           
            foreach ($_SESSION['cart'] as $result){
                if($pro['name']==$result['name']){
                    
                    $totalPrice-=$_SESSION['cart'][$i]['price'];
                    $_SESSION['cart'][$i]['quantity']=$quantity;
                    $_SESSION['cart'][$i]['price']=$quantity* $pro["price"];
                    $totalPrice+=$_SESSION['cart'][$i]['price'];
                    $result = [
                        'name' => $pro["name"],
                        'price' => $_SESSION['cart'][$i]['price'],
                        'quantity' =>$_SESSION['cart'][$i]['quantity'],
                        'id' =>$pro["id"],
                        'first' => 0,
                        'totalPrice' =>$totalPrice,
                        'picture' => base64_encode($pro["picture"]) // Encode the picture as base64
                    ];
                    echo json_encode($result);
                    return;
                }
                $i++;
              }
             
            // Add the item to the cart
            $item = array(
            'name' => $pro["name"],
            'price' => $pro["price"]*$quantity,
            'quantity' => $quantity,
            'id' =>$pro["id"],
            'first' => 1,
            'picture' => base64_encode($pro["picture"]) // Encode the picture as base64
            );
            $_SESSION['cart'][] = $item;
            $data['success'] = "Product Have Been saved";
            $totalPrice+=$pro["price"]*$quantity;
            $result = [
                'name' => $pro["name"],
                'price' => $_SESSION['cart'][$i]['price'],
                'quantity' =>$_SESSION['cart'][$i]['quantity'],
                'id' =>$pro["id"],
                'first' => 1,
                'totalPrice' =>$totalPrice,
                'picture' => base64_encode($pro["picture"]) // Encode the picture as base64
            ];
            echo json_encode($result);
            
        }
        else 
        {
            $data['error'] = "Error";
        }
    }

    
}   