<?php

class CategoriesController extends Controller 
{
    private $conn;
    private $conn_users;

    public function __construct()
    {
        $this->conn = new Categories();
        $this->conn_users = new Users();
    }
    public function index()
    {
        $data['categories'] = $this->conn->getAllCategories();
        return $this->view('Categories/index',$data);
    }
    public function add()
    {
        return $this->view('Categories/add');
    }
    public function store()
    {
        if(isset($_POST)&&isset($_FILES))
        {
            $tmp_img = $_FILES['picture']['tmp_name'];
            $picture= file_get_contents($tmp_img);
            $name = $_POST['name'];

            $this->conn = new Categories();
            $dataInsert = Array ( 
                            "name" => $name ,
                             "picture" => $picture,
                            );
            if($this->conn->insertCategory($dataInsert))
            {
                $data['success'] = "Category Added Successfully";
                return $this->index();
            }
            else 
            {
                $data['error'] = "Error";
                return $this->view('categories/add',$data);
            }
        }
        return $this->view('categories/index');
    

    
    }
    public function edit($id)
    {
        $data['category'] = $this->conn->getCategory($id);
        return $this->view('categories/edit',$data);
    }

    public function update()
    {
        if(isset($_POST)&&isset($_FILES))
        {
            $id=$_POST['id'];

            $name = $_POST['name'];
            $tmp_img = $_FILES['picture']['tmp_name'];
            $picture= file_get_contents($tmp_img);

            $this->conn = new Categories();
            $dataInsert = Array ( "name" => $name ,
                                    "picture" => $picture,
            );
            if($this->conn->updateCategory($id,$dataInsert))
            {
                $data['success'] = "Updated Successfully";
                $data['category'] = $this->conn->getCategory($id);
                return $this->index();

            }
            else 
            {
                $data['error'] = "Error";
                $data['category'] = $this->conn->getCategory($id);
                return $this->view('Categories/edit',$data);
            }
        }
        redirect('categories/index');
    
    }

    public function delete($id)
    {
        if($this->conn->deleteCategory($id))
        {
            $data['success'] = "Category Have Been Deleted";
            return $this->index();

        }
        else 
        {
            $data['error'] = "Error";
            return $this->view('Categories/delete',$data);
        }
        return $this->view('categories/delete');
        
    }

}