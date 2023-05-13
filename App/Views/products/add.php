<?php  include(VIEWS.'template'.DS.'header.php'); ?>

    <style>
    .form-group 
    {
        padding:2% 0%;
    }
</style>
<div class="container card col-10 mt-5">
    <div class="header text-center" style="background-color:rgb(112, 66, 50);">
    <h2 class="text-white">Add New products</h2>
    </div>
    <div class="content col-10">
    <form action="<?php url('products/store'); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name"  class="form-control" value="<?php if(isset($formatData["name"])){echo $formatData["name"];} ?>">
        </div>
        <span class="text-danger"> <?php  if(isset($errors["name"])) echo $errors["name"] ?> </span>
        
        <div class="form-group">
            <label for="">price</label>
            <input type="number" name="price" min=0  class="form-control"  value="<?php if(isset($formatData["price"])){echo $formatData["price"];} ?>">
        </div>
        <span class="text-danger"> <?php  if(isset($errors["price"])) echo $errors["price"] ?> </span>

        <div class="form-group">
            <label for="">availability</label>
            <input type="number" name="availability" min=0 max=1  class="form-control" placeholder="value 0 or 1">
        </div>

        <div class="form-group">
            <label for="">category</label>
            <!-- <input type="number" name="categoryID" required class="form-control"> -->
            <select name="categoryID" class="w-100">
               <?php     foreach($categories as $row):  ?>
                        <option   value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?></option> 
               <?php  endforeach; ?>
            </select>
        </div>
        <span class="text-danger"> <?php  if(isset($errors["categoryID"])) echo $errors["categoryID"] ?> </span>
        
        <div class="form-group">
            <label for="">Upload Picture</label>
            <input type="file" name="picture"  class="form-control" accept="image/*">
        </div>
        <span class="text-danger"> <?php  if(isset($errors["picture"])) echo $errors["picture"] ?> </span>
        <span class="text-danger"> <?php  if(isset($errors["image"])) echo $errors["image"] ?> </span><br>
        
        <input type="submit" class="btn mb-2 mt-2" value="Add" style="background-color:rgb(112, 66, 50);
         color:white;" >

    </form>
    </div>
 
</div>


<?php  include(VIEWS.'template'.DS.'footer.php'); ?>
