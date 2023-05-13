<?php  include(VIEWS.'template'.DS.'header.php'); ?>
<link rel="stylesheet"  href="<?=BURL.'css/checks.css'?>" />

<section class="container-fluid row">

    <div class="mt-5 col-lg-2 col-12">
        <form class="card p-3" method="POST">
        <?php if(isset($error)) {?>
      <div class="alert alert-warning">
        <h6><?=$error;?></h6>
      </div>
      <?php }?>
          <div class="form-group">
            <label for="from">From:</label>
          <input type="date" name="from" class="form-control"
          value="<?=(isset($from))?$from : '2023-01-01'?>" 
           max="<?= date('Y-m-d'); ?>"   required
          >
          </div>
         
          <div class="form-group">
          <label for="to">To:</label>
          <input type="date" name="to" class="form-control"  
           max="<?= date('Y-m-d'); ?>"    required
           value="<?=(isset($to))?$to : date('Y-m-d');?>"> 
          </div>
           
             <div class="form-group">
             <select name="userId" class="form-select">
              <option value="0" selected 
              <?= (isset($userId)&&$userId==0)?'selected':''?>>AllUsers</option>
                  <?php foreach($users as $user){ ?>
                    <option value="<?=$user['id'];?>"  
                    <?= (isset($userId)&&$userId==$user['id'])?'selected':''?>><?= $user['name'];?></option>
                    <?php }?>
                </select>
             </div>
            <input type="submit" name="filter" class="btn btn-warning text-white">
        </form>
    </div>


    <div class="col-lg-10 col-12">
<div id="accordion" class="myaccordion row">

    <div class="card" style="background-color:rgb(112, 66, 50);">
     <div class="row text-center text-white">
        <div class="col-5"><h2>Name</h2></div>
        <div class="col-4"><h2>Total Price</h2></div>
     </div>
    </div>
   

    <?php foreach($usersOrders as $userOrder){?>
  <div class="card">
    <div class="card-header" id="heading<?=$userOrder['id'];?>">
      <h2 class="mb-0">
        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapse<?=$userOrder['id'];?>" aria-expanded="false" aria-controls="collapse<?=$userOrder['id'];?>"  type="button" onClick="userOrder(<?= $userOrder['id'];?>)">
            <div class="col-5"><?= $userOrder['name']?></div>
          <div class="col-4"><?= $userOrder['totalprice'] ?> $</div>
          <div class="col-3">

          <span class="fa-stack fa-sm">
            <i class="fas fa-circle fa-stack-2x"></i>
            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
          </span>

          </div>
        </button>
      </h2>
    </div>


    <div id="collapse<?=$userOrder['id'];?>" class="collapse" aria-labelledby="heading<?=$userOrder['id'];?>" data-bs-parent="#accordion">
      <div class="card-body">
      <div id="subaccordion<?=$userOrder['id']?>" class="accordion">

      <div class="card bg-warning">
      <div class="row text-center text-white">
        <div class="col-5"><h4>Date</h4></div>
        <div class="col-4"><h4>Total Price</h4></div>
     </div>
     </div>

     <div class="row container" id="user<?=$userOrder['id']?>">



     </div>



      </div>
         </div>
      </div>
    </div>

    <?php }?>


  </div>

    </div>


</section>



<script src="<?=BURL.'js/checks.js'?>"></script>
<?php  include(VIEWS.'template'.DS.'footer.php'); ?>
