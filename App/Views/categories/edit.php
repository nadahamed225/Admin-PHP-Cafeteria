<?php include VIEWS . 'template' . DS . 'header.php'; ?>

<style>
    .form-group 
    {
        padding:2% 0%;
    }
</style>

<div class="container card col-10 mt-5">
    <div class="header text-center" style="background-color:rgb(112, 66, 50);">
    <h2 class="text-white">Update Category</h2>
    </div>
    
    <div class="content col-10">

    <?php if (isset($success)): ?>
                    <h3 class="alert alert-success text-center"><?php echo $success; ?></h3>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <h3 class="alert alert-danger text-center"><?php echo $error; ?></h3>
                <?php endif; ?>
    <form action="<?php url(
        'Categories/update'
    ); ?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" value="<?php echo $category['id']; ?>" name="id">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" name="name" class="form-control" required value="<?php echo $category['name']; ?>">
        </div>

        <div class="form-group">
            <label for="">Upload Picture</label>
            <input type="file" name="picture" class="form-control" required  accept="image/*">
           
        </div>

        <input type="submit" class="btn mb-2 mt-2" value="Confirm update" name="submit"style="background-color:rgb(112, 66, 50);
         color:white;" >

    </form>
    </div>
 
</div>



<?php include VIEWS . 'template' . DS . 'footer.php'; ?>
