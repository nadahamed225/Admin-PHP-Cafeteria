<?php

class UsersController extends Controller
{
    private $conn;
    private $connProduct;
    public function __construct()
    {
        $this->conn = new Users();
        $this->connProduct=new Products();
    }
    public function index()
    {
        $data['users'] = $this->conn->getAllUsers();
        return $this->view('users/index',$data);
    }
    public function add()
    {
        $dsn = "mysql:host=127.0.0.1;dbname=cafeteria;port=8111;";
        $username = "root";
        $password = "";
        $pdo = new PDO($dsn, $username, $password);

        $query = "select * from `room`";
        $select_stmt = $pdo->prepare($query);
        $res=$select_stmt->execute();
        $dataroom = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['rooms']=$dataroom;
        return $this->view('users/add',$data);
    }
    public function store()
    {
        $dsn = "mysql:host=127.0.0.1;dbname=cafeteria;port=8111;";
        $username = "root";
        $password = "";
        $pdo = new PDO($dsn, $username, $password);

        $query = "select * from `room`";
        $select_stmt = $pdo->prepare($query);
        $res=$select_stmt->execute();
        $dataroom = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['rooms']=$dataroom;
        if(isset($_POST)&&isset($_FILES))
        {
           

            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmPassword=$_POST["confirmpassword"];
             $formatData=[];
             $errors=[];
            $phone = $_POST['phone'];
            // $tmp_img = $_FILES['picture']['tmp_name'];
            $picture;
            $isAdmin = 0;
            $roomNumber	= $_POST['userroomNumber'];
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
            if(isset($name) and empty($name)){
                $errors['name']='Product must have name';
            }else{
                $formatData['name']=$name;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formatData['email']=$email;
                $errors['email'] = "Invalid email format";
            }else{
                
                $formatData['email']=$email;
                // Check email uniqueness
                $query = "select COUNT(*) from `room` WHERE email = ?";

                $stmt = $pdo->prepare($query);
                $stmt->execute([$email]);
                $count = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($count > 0) {
                    $errors['email'] = "Email already exists";
                }
            }
            if(isset($password) and empty($password)){
                $errors['password']='must enter password';
            }else{
                $formatData['password']="";
            }
            if($password!=$confirmPassword){
                $errors['password']='must matched';
            }
            $regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z0-9]{8}$/";
            if (!preg_match($regex, $password)) {
                $errors['password']=' Matches passwords that are exactly 8 characters long and only contain lowercase , Capitalcase letters, numbers';
            }
            if($errors){
                $data['errors']=$errors;
                $data['formatData']=$formatData;
                return $this->view('users/add',$data);
                
            }
            $this->conn = new Users();
            $dataInsert = Array (
                "name" => $name ,
                "email" => $email  ,
                "password" => $password ,
                "phone"=>$phone,
                 "picture" => $picture,
                "isAdmin" => $isAdmin,
                "roomNumber" => $roomNumber
            );

            if($this->conn->insertUsers($dataInsert))
            {
                $data['success'] = "Data Added Successfully";
                return $this->index();
            }
            else 
            {
                $data['error'] = "Error";
                return $this->view('users/add',$data);
            }
        }
        return $this->view('users/add');
    }

    public function edit($id)
    {
        $data['user'] = $this->conn->getUser($id);
        return $this->view('users/edit',$data);
    }

    public function update()
    {
        if(isset($_FILES))
        {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['phone'];
            $tmp_img = $_FILES['picture']['tmp_name'];
            $picture= file_get_contents($tmp_img);
            $isAdmin = 0;
            $roomNumber	= $_POST['roomNumber'];

            $this->conn = new Users();
            $dataInsert = Array (
                "name" => $name ,
                "picture" => $picture,
            );
            if($this->conn->updateUser($id,$dataInsert))
            {
                $data['success'] = "Updated Successfully";
                $data['users'] = $this->conn->getAllUsers();
                return $this->view('users/index',$data);

            }
            else
            {
                $data['error'] = "Error";
                $data['user'] = $this->conn->getUser($id);
                return $this->view('users/edit',$data);
            }
        }
        redirect('users/index');
    }

    public function delete($id)
    {
        if($this->conn->deleteUser($id))
        {
            $data['success'] = "User Have Been Deleted";
            return $this->index();
        }
        else
        {
            $data['error'] = "Error";
            return $this->view('users/delete',$data);
        }
        return $this->view('users/delete');

    }
    ////////////

    public function login(){
        return $this->view('users/login');
    
    }
    public function validationlogin(){
        try{
            $data =  $this->conn->getAllUsers();
            
        foreach ($data as $row){
            // var_dump($_POST['email'],$_POST['password']);
            if(isset($_POST['email']) && isset($_POST['password'])){
            if ($row['email'] == $_POST['email'] and $row['password'] == $_POST['password'] ){
                
                    if($row['isAdmin']==false){
                        $data['errorLogin']="this user not Admin";
                
                        if(isset($_POST['email'])){
                        $data['oldDataEmail']=$_POST['email'];}
                        // header($url);
                        return $this->view('users/login',$data);
                    }
                 session_destroy();

                    session_start();    
                    $_SESSION["email"]=$row["email"];
                $data['users']=$this->conn->getAllUsersByRole(0);  
                $data['products'] = $this->connProduct->getAllProducts();
                    $dsn = "mysql:host=127.0.0.1;dbname=cafeteria;port=8111;";
                    $username = "root";
                    $password = "";
                    $pdo = new PDO($dsn, $username, $password);
            
                    $query = "select * from `room`";
                    $select_stmt = $pdo->prepare($query);
                    $res=$select_stmt->execute();
                    $dataroom = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
                    $data['rooms']=$dataroom;
                    //return $this->view('home/index',$data);
                    header("location:/products/home");
                    exit();
                }
            }
            }
                $data['errorLogin']="invalid email or password";
                
                if(isset($_POST['email'])){
                $data['oldDataEmail']=$_POST['email'];}
                // header($url);
                return $this->view('users/login',$data);
        
    }catch (Exception $e) {
        echo $e->getMessage();
    }
    }

    public function logout(){
        unset($_SESSION["email"]);
        unset($_SESSION["cart"]);

        session_destroy();
        return $this->view('users/login');
    
    }
}




























//

//class UsersController extends Controller
//{
//    private $conn;
//    public function __construct()
//    {
//        $this->conn = new Users();
//    }
//    public function index()
//    {
//        $data['users'] = $this->conn->getAllUsers();
//        return $this->view('users/index',$data);
//    }
//    public function add()
//    {
//        return $this->view('users/add');
//    }
//    public function store()
//    {
//        if(isset($_POST)&&isset($_FILES))
//        {
//            $name = $_POST['name'];
//            $email = $_POST['email'];
//            $password = $_POST['password'];
//            $phone = $_POST['phone'];
//            $tmp_img = $_FILES['picture']['tmp_name'];
//            $picture= file_get_contents($tmp_img);
//            $isAdmin = 0;
//            $roomNumber	= $_POST['roomNumber'];
//            $this->conn = new Users();
//            $dataInsert = Array ( "name" => $name ,
//                "email" => $email  ,
//                "password" => $password ,
//                "phone"=>$phone,
//                "picture" => $picture,
//                "isAdmin" => $isAdmin,
//                "roomNumber" => $roomNumber
//            );
//
//            if($this->conn->insertUsers($dataInsert))
//            {
//                $data['success'] = "Data Added Successfully";
//                return $this->view('users/add',$data);
//            }
//            else
//            {
//                $data['error'] = "Error";
//                return $this->view('users/add',$data);
//            }
//        }
//        return $this->view('users/add');
//    }
//    public function edit($id)
//    {
//        $data['user'] = $this->conn->getUser($id);
////        var_dump($data['user']);
//        return $this->view('users/edit',$data);
//    }
//    public function update()
//    {
//        if(isset($_POST)&&isset($_FILES))
//        {
//            $id = $_POST['id'];
//            $name = $_POST['name'];
//            $email = $_POST['email'];
//            $password = $_POST['password'];
//            $phone = $_POST['phone'];
//            $tmp_img = $_FILES['picture']['tmp_name'];
//            $picture= file_get_contents($tmp_img);
//            $isAdmin = 0;
//            $roomNumber	= $_POST['roomNumber'];
//            $this->conn = new Users();
//            $dataInsert = Array ( "name" => $name ,
//                "email" => $email  ,
//                "password" => $password ,
//                "phone"=>$phone,
//                "picture" => $picture,
//                "isAdmin" => $isAdmin,
//                "roomNumber" => $roomNumber
//            );
//            // data of user
//
//            if($this->conn->updateUser($id,$dataInsert))
//            {
//                $data['success'] = "Updated Successfully";
//                $data['user'] = $this->conn->getUser($id);
//                $this->view('users/edit',$data);
//            }
//            else
//            {
//                $data['error'] = "Error";
//                $data['user'] = $this->conn->getUser($id);
//                return $this->view('users/edit',$data);
//            }
//        }
//        redirect('home/index');
//    }
//    public function delete($id)
//    {
//        if($this->conn->deleteUser($id))
//        {
//            $data['success'] = "User Have Been Deleted";
//            return $this->view('users/delete',$data);
//        }
//        else
//        {
//            $data['error'] = "Error";
//            return $this->view('users/delete',$data);
//        }
//    }
//}