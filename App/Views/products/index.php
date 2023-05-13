<?php  include(VIEWS.'template'.DS.'header.php');
    echo "<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js' integrity='sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p' crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js' integrity='sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF' crossorigin='anonymous'></script>
    ";
?>
<link rel="stylesheet" href="<?=BURL.'css/styleTable.css'?>"/>


<div class="container ">
    <div class="col-4 add">
        <a href="<?php url('products/add'); ?>" class="btn">
        <i class="fa fa-add"></i>Add New Products
      </a>
    </div>


<div class="container">
    <div class="row">
        <div class="col-10 mx-auto p-4 mb-5">
                <!-- <?php if(isset($success)): ?>
                    <h3 class="alert alert-success text-center"><?php  echo $success; ?></h3>
                <?php endif; ?>
                <?php if(isset($error)): ?>
                    <h3 class="alert alert-danger text-center"><?php  echo $error; ?></h3>
                <?php endif; ?> -->

            <table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0"">
                <thead>
                    <tr>
                    <th>#</th>
                    <th >image</th>
                    <th >Name</th>
                    <th >Price</th>
                    <th>availability</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $i=1; ?>
                    <?php foreach($products as $row):  ?>
                        <tr>
                            <td> <?php echo $i; $i++; ?></td>
                            <td><img src="<?='data:image/jpeg;base64,'.base64_encode($row['picture'])?>"  height="80px" width="100px" /></td>

                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['price']; ?> <b > $ </b></td>
                            <td class="text-center"><?php echo $row['availability']; ?></td>
                            <!-- <td><?php echo $row['picture']; ?></td> -->
                            <td>
                            <a href="<?php url('/products/edit/'.$row['id']) ;?>" class="btn btn-danger">
                            <i class="fa fa-edit"></i>
                            </a>
                            <a href="<?php url('/products/delete/'.$row['id']); ?>" class="btn btn-primary"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php  endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>
</div>


<?php  include(VIEWS.'template'.DS.'footer.php'); ?>
