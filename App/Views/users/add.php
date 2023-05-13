<?php  include(VIEWS.'template'.DS.'header.php'); ?>

    <style>
        .form-group
        {
            padding:2% 0%;
        }
    </style>

    <div class="container card col-10 mt-5">
        <div class="header text-center" style="background-color:rgb(112, 66, 50);">
            <h2 class="text-white">Add New User</h2>
        </div>

        <div class="content col-10">

        
            <form action="<?php url('users/store'); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name"  class="form-control" value="<?php if(isset($formatData["name"])){echo $formatData["name"];} ?>">
        </div>
        <span class="text-danger"> <?php  if(isset($errors["name"])) echo $errors["name"] ?> </span>
        
        <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="text" class="form-control" name="email" value="<?php if(isset($formatData["email"])){echo $formatData["email"];} ?>" >
    </div>
    <span class="text-danger"> <?php if(isset($errors['email'])) echo $errors['email']; ?> </span>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">confirmPassword</label>
        <input type="password" class="form-control" name="confirmpassword" id="exampleInputPassword2">
    </div>
    <span class="text-danger"> <?php if(isset($errors['password'])) echo $errors['password']; ?> </span>
    <input type="number" name="userroomNumber" id="userroomNumber" hidden>

    <div class="btn-group">
        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" id="userroom" data-bs-toggle="dropdown" aria-expanded="false">
        Room
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
                    <?php foreach($rooms as $row): ?>
                      <li ><a class="dropdown-item" href="#" onclick="selectroom(this)"><?php echo $row['roomNumber']; ?></a></li>
                    <?php endforeach; ?>
        </ul>
    </div>
                <div class="form-group">
                    <label for="">Ext.</label>
                    <input type="number" name="phone" min=0 class="form-control">
                </div>

                <div class="form-group">
                    <label for="">Profile Picture</label>
                    <input type="file" name="picture" class="form-control">
                </div>
                <span class="text-danger"> <?php  if(isset($errors["picture"])) echo $errors["picture"] ?> </span>
        <span class="text-danger"> <?php  if(isset($errors["image"])) echo $errors["image"] ?> </span><br>
        
                <input type="submit" class="btn mb-2 mt-2" value="Add" name="submit"style="background-color:rgb(112, 66, 50);
         color:white;" >

            </form>
        </div>

    </div>


<script>
    function selectroom(element){
    var selectedUser = element.textContent;
    var dropdownButton = document.querySelector('#userroom');
    dropdownButton.textContent = selectedUser;
    
    let id = document.getElementById("userroomNumber");
            id.value=selectedUser;
}
</script>
<?php  include(VIEWS.'template'.DS.'footer.php'); ?>