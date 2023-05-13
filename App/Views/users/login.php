<?php
// if(isset($_GET['errors'])){
//     $errors = json_decode($_GET["errors"],true);
// }

// if(isset($_GET["old"])){
//     $oldData = json_decode($_GET["old"],true);
// }else{
//     $oldData['email']="";
// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
<div class="text-center mt-5 ">
    <h1>cafateria</h1>
</div>

<div class="d-flex justify-content-center mt-5" >
    <form action="<?php url('users/validationlogin'); ?>" method="POST" >
        <span class="text-danger"> <?php if(isset($errorLogin)) echo $errorLogin; ?> </span>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" value="<?php if(isset($oldDataEmail)) echo $oldDataEmail?>" class="form-control"  name="email" id="email" >
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1">
        </div>

        <button type="submit" class="btn btn-primary">login</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>