<?php  include(VIEWS.'template'.DS.'header.php'); ?>

    <style>
        .form-group
        {
            padding:2% 0%;
        }
    </style>

    <div class="container card col-10 mt-5">
        <div class="header text-center" style="background-color:rgb(112, 66, 50);">
            <h2 class="text-white">Delete User</h2>
        </div>
        <div class="content col-12">

            <?php if(isset($success)): ?>
                <h3 class="alert alert-success text-center"><?php  echo $success; ?></h3>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <h3 class="alert alert-danger text-center"><?php  echo $error; ?></h3>
            <?php endif; ?>
        </div>
    </div>

<?php  include(VIEWS.'template'.DS.'footer.php'); ?>
