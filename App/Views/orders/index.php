<?php  include(VIEWS.'template'.DS.'header.php');
    echo "<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js' integrity='sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p' crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js' integrity='sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF' crossorigin='anonymous'></script>
    ";
?>
<link rel="stylesheet" href="<?=BURL.'css/styleTable.css'?>"/>
<style>
    .fade 
    {
    transition: all .5 ease;
    -webkit-transition: all .5s ease;
    -moz-transition: all .5s ease;
    -ms-transition: all .5s ease;
    -o-transition: all .5s ease;
    }
</style>

<div class="container-fluid">
    <div class="row container">
        <div class="col-10 mx-auto">
                <?php $i=1; ?>
              <?php  foreach($userorders as $row):  ?>
                        <table  class="table  table-bordered " id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="align-baseline">#</th>
                                <th class="align-baseline">date</th>
                                <th class="align-baseline">Name</th>
                                <th class="align-baseline">Ext</th>
                                <th class="align-baseline">room</th>
                                <th class="align-baseline d-flex justify-content-between"> 
                                    <div>
                                    <span> Action</span> 
                                    </div>
                                    <div>
                                    <button class="btn" onclick="toggle(<?=$row['o_id']?>)">
                                        <span class="fa-stack fa-sm text-warning">
                                   <i class="fas fa-circle fa-stack-2x"></i>
                                 <i class="fas fa-plus fa-stack-1x fa-inverse" 
                                 id=<?="icon".$row['o_id']?>></i>
                                    </span>
                                        </button> 
                                    </div>
                                </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td> <?php echo $i; $i++; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td class="text-center"><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['roomNumber']; ?></td>
                            <td>
                             <form method="POST">
                                <div class="d-flex justify-content-around">
                                    <div>
                                    <select class="form-control" name="status">
                                <option value="deliver"
                                 <?php if($row['status']=="outfordelivery") echo 'selected'?>  >Outfordelivery</option>
                                <option value="processing" <?php if($row['status']=="processing") echo 'selected'?> >Processing</option>
                                <option value="done"
                                <?php if($row['status']=="done") echo 'selected'?> > Done</option>
                                  </select>
                                  <input type="hidden" name="id" value="<?=$row['o_id']; ?>">
                                    </div>

                                    <div>
                                    <input type="submit"  class="btn btn-secondary" value="Save"/>
                                    </div>

                                </div>
                          
                     
                         </form>
             
                            </td>
                        </tr>
                        </tbody>
                        </table>
                        <div  class="col-12  order_details" id=<?="order".$row['o_id']?>
                        style="display: none; border-left:1px solid red; border-right:1px solid red;"
                         >
                        <?php
                            foreach($orderDetails as $pic): ?>
                            <?php if($row['o_id']==$pic['o_id']): ?>
                                <div class="row container mt-3 mb-4">
                                <div class="col-3">
                                    <img src="<?='data:image/jpeg;base64,'.base64_encode($pic['picture'])?>"  height="80px" width="100px" /></div>
                                    <div class="col-3">
                                    <p><?= $pic['name']; ?><p>  
                                    </div>
                                <div class="col-3">

                                  <p><?=  $pic['quantity']; ?> Qt<p>
                                </div>

                                <div class="col-3">
                                 <p><?= $pic['totalPriceProduct']; ?> EGP<p>
                                   </div>

                                </div>
                                  
                            <?php endif;?>
                           <?php endforeach;  ?>
                           <div class="col-12 mt-3 mb-3">
                           <h3 class="text-right">Total : <?= $row['totalPrice']; ?> EGP </h3>
                           </div>
                     
                        </div>
 <?php  endforeach; ?>
            </div>
    </div>
 </div>

<?php  include(VIEWS.'template'.DS.'footer.php'); ?>



<script>

function toggle(order_id)
{
    let id='order'+order_id;
    let icon='icon'+order_id;
   let order=document.getElementById(id);
   let order_icon=document.getElementById(icon);

     order.classList.add("fade");
        
    if(order.style.display=='none'){
        order_icon.classList.remove("fa-plus");
        order_icon.classList.add("fa-minus");
        order.style.display='block';
    }
    else{
    order.style.display='none';
    order_icon.classList.add("fa-plus");
    order_icon.classList.remove("fa-minus");
    }
    setTimeout(() => {
        order.classList.remove("fade");
        
    }, 1000);
   

}
 </script>





                                