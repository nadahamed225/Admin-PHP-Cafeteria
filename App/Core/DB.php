<?php
class DB 
{

    private $pdo="mysql:dbname=".DB_NAME.";host=".DB_HOST.";port=".DB_PORT."";
    public $conn;

    function __construct()
    {
        try
        {
        $this->conn=new PDO($this->pdo,DB_USER,DB_PASS);
        }catch(PDOException $e)
        {
            echo $e->getMessage();
        }

    }

    // public function connect(){
    //     try {
    //        $this->conn = new PDO($this->pdo, DB_USER, DB_PASS);
    //         return $this->conn ;
    
    //     } catch (Exception $e){
    //         echo $e->getMessage();
    //     }
    // }
    /*public function selectUserByRole($q){
        $query =$q;
        $select_stmt = $this->conn->prepare($query);
        $res=$select_stmt->execute();
        $data = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }*/
    function select($table)
    {
        try
        {
        $query="select *from {$table}";
        $stmt=$this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e)
        {
            return false;
        }

    }


    function selectById($table,$id)
    {
        try
        {
        $query="select *from {$table} where id=:id";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        }catch(Exception $e)
        {
            return false;
        }

    }


    function insert($table,$arr)
    {
        try 
        {
        $query="insert into `{$table}` (";

        foreach($arr as $k=>$v)
        {
            $query.="`$k`,";

        }
        $query=trim($query,',');

        $query.=") values (";

        foreach($arr as $k=>$v)
        {
            $query.=":$k ,";
        }
        $query=trim($query,',');
        $query.=")";

        $stmt=$this->conn->prepare($query);
    

        foreach($arr as $k=>&$v)
        {
    
            $stmt->bindParam(":$k",$v);
        }

    
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

      }catch(PDOException $e)
      {
       return false;
      }

        



    }


    function update($table,$id,$arr)
    {

        try 
        {
        $query="update  `{$table}` set ";

      
        foreach($arr as $k=>$v)
        {
            if($k!='id')
            $query.=" `$k` = :$k ,";
        }
        $query=rtrim($query,',');
        $query.="where `id`= :id";

        $stmt=$this->conn->prepare($query);


        foreach($arr as $k=>&$v)
        {
            if($k!='id')
            $stmt->bindParam(":$k",$v);
        }
    
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
   

        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

      }catch(PDOException $e)
      {
        return false;
      }

    }


    function delete($table,$id)
    {
        try 
        {
        $user=$this->selectById($table,$id);
        $query="delete from {$table} where id=:id";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        }catch(PDOException $e)
        {
            return false;
        }

    }


    function rawQuery($query)
    {
        $select_stmt = $this->conn->prepare($query);
        if($select_stmt->execute()){
        $data = $select_stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
        }
        return false;
    }

}



?>