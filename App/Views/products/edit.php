<?php  include(VIEWS.'template'.DS.'header.php'); ?>
<!-- 
<h1 class="text-center  mt-5 mb-2 py-3">Edit Product </h1>

    <div class="container">
        <div class="row">
            <div class="col-8 mx-auto">

            
                <?php if(isset($success)): ?>
                    <h3 class="alert alert-success text-center"><?php  echo $success; ?></h3>
                <?php endif; ?>
                <?php if(isset($error)): ?>
                    <h3 class="alert alert-danger text-center"><?php  echo $error; ?></h3>
                <?php endif; ?>


                <form class="p-5 border mb-5" method="POST" action="<?php url('products/update'); ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" required value="<?php echo $row['name']; ?>" name="name" class="form-control" id="name" >
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" required class="form-control" value="<?php echo $row['price']; ?>" name="price" id="price">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" required class="form-control" value="<?php echo $row['description']; ?>" name="description" id="description">
                    </div>

                    <div class="form-group">
                        <label for="qty">Quantity</label>
                        <input type="number" required class="form-control" value="<?php echo $row['qty']; ?>" name="qty" id="qty">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>
                            
            </div>
        </div>
    </div> -->





<style>
    .form-group 
    {
        padding:2% 0%;
    }
</style>
                <!-- <?php if(isset($success)): ?>
                    <h3 class="alert alert-success text-center"><?php  echo $success; ?></h3>
                <?php endif; ?>
                <?php if(isset($error)): ?>
                    <h3 class="alert alert-danger text-center"><?php  echo $error; ?></h3>
                <?php endif; ?> -->
<div class="container card col-10 mt-5">
    <div class="header text-center" style="background-color:rgb(112, 66, 50);">
    <h2 class="text-white">Edit Products</h2>
    </div>
    <div class="content col-10">
    <form action="<?php url('products/update'); ?>" method="POST"  enctype="multipart/form-data">
    <input type="hidden" value="<?php echo $row['id']; ?>" name="id">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" required value="<?php echo $row['name']; ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="">price</label>
            <input type="number" name="price" required value="<?php echo $row['price']; ?>" class="form-control">
        </div>
        <!-- <div class="form-group">
            <label for="">category</label>
            <input type="number" name="categoryID" required value="<?php echo $row['categoryID']; ?>" class="form-control">
        </div> -->
        <div class="form-group">
            <label for="">availability</label>
            <input type="number" name="availability" required value="<?php echo $row['availability']; ?>"  class="form-control">
        </div>

        <div class="form-group">
            <label for="">category</label>
            <!-- <input type="number" name="categoryID" required class="form-control"> -->
            <select name="categoryID" class="w-100">
               <?php     foreach($categories as $category):  ?>
                        <option   value="<?php echo $category['id']; ?>"> <?php echo $category['name']; ?></option> 
               <?php  endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="">Upload Picture</label>
            <input type="file" name="picture" required class="form-control">
        </div>

        <input type="submit" name="submit" class="btn mb-2 mt-2" value="edit" style="background-color:rgb(112, 66, 50);
         color:white;" >

    </form>
    </div>
 
</div>

<?php  include(VIEWS.'template'.DS.'footer.php'); ?>