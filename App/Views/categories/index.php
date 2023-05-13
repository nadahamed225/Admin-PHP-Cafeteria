<?php include VIEWS . 'template' . DS . 'header.php'; ?>
<link rel="stylesheet" href="<?= BURL . 'css/styleTable.css' ?>"/>


<div class="container table-responsive">
    <div class="col-4 add">
        <a href="<?php url('categories/add'); ?>" class="btn">
        <i class="fa fa-add"></i>Add New Category
      </a>
    </div>

 <table class="table  table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
      
        <tbody>
            <?php
            $i = 0;
            foreach ($categories as $category) {
                $i++; ?>
            <tr>
                <td><?= $i ?></td>
                <td><img src="<?= 'data:image/jpeg;base64,' .
                    base64_encode(
                        $category['picture']
                    ) ?>"  height="80px" width="100px" />
            </td>
                <td><?= $category['name'] ?></td>
                <td>
                    <a href="<?php url(
                        '/categories/edit/' . $category['id']
                    ); ?>" class="btn btn-danger">
                        <i class="fa fa-edit"></i>
                        </a>
                    <a href="<?php url(
                        '/categories/delete/' . $category['id']
                    ); ?>" class="btn btn-primary"><i class="fa fa-trash"></i></a>
                </td>
             
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
            </div>


<?php include VIEWS . 'template' . DS . 'footer.php'; ?>
