<?php  include(VIEWS.'template'.DS.'header.php');?>
<!-- <script src="<?=BURL.'js/home.js'?>"></script> -->
  <?php if(isset($success)): ?>
                <h3 class="alert alert-success text-center"><?php  echo $success; ?></h3>
            <?php endif; ?>
            <?php if(isset($error)): ?>
                <h3 class="alert alert-danger text-center"><?php  echo $error; ?></h3>
            <?php endif; ?>
            <?php if(isset($erroruserid)): ?>
                <h3 class="alert alert-danger text-center"><?php  echo $erroruserid; ?></h3>
            <?php endif; ?>
            <?php if(isset($errorroom)): ?>
                <h3 class="alert alert-danger text-center"><?php  echo $errorroom; ?></h3>
            <?php endif; ?>
<div class="container">
  <!-------------search by product-------------->
  <div class="col-4 m-auto mb-4">
      <form class="d-flex" role="search" method="POST">
        <input class="form-control me-2" type="search" name="search_prod" value="<?=(isset($search)) ? $search:'';?>"
         placeholder="Search by product" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
    <!---------------------------------->
  <div class="row">
    <div class="col-md-8">
      <h1>My Cafeteria Menu</h1>
    </div>
    <div class="col-md-4">
    <div class="btn-group">
        <button class="btn btn-secondary btn-lg dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            All Users
        </button>
        <ul class="dropdown-menu dropdown-menu-dark">
                    <?php foreach($users as $row): ?>
                      <li ><a class="dropdown-item" href="#" onclick="selectUser(this,'<?php echo $row['id']; ?>')"><?php echo $row['name']; ?></a></li>
                    <?php endforeach; ?>
        </ul>
    </div>
  </div>
  
   <div class="row">
        <div class="col-md-8 ">
        <?php if(isset($notfound)){?>
    <div class="alert alert-warning">
      <?= $notfound;?>
    </div>

    <?php }?>
            <div class="row">
            <?php $i=0; ?>
            <?php foreach($products as $row):  ?>
            
                <div class=" col-md-5 col-sm-12  mb-3">
                    <div class="card h-100 p-4 rounded-5  border-dark" style="height:200px; box-shadow: 0px 0px 10px 0px rgb(0 0 0 / 18%);
                    ">
                        <div class="row">
                            <div class="col-md-5 mt-3"  >
                            <img class="img-fluid" src="<?='data:image/jpeg;base64,'.base64_encode($row['picture'])?>"   />
                            <a  class="btn rounded-circle btn-sm btn-outline-secondary border-dark mt-2 font-weight-bold" onclick="fundecreaseQuantity('localQuantity<?=$row['name']?>')" id="decreaseQuantity<?=$row["name"]?>" >-</a>
                            <span id="localQuantity<?=$row["name"]?>">1</span>
                            <a  id="increaseQuantity<?=$row["name"]?>" onclick="funincreaseQuantity('localQuantity<?=$row['name']?>')" class="btn rounded-circle btn-sm btn-outline-secondary  border-dark mt-2 font-weight-bold" >+</a>

                            </div>
                            <div class="col-md-7">
                                    <div class="card-body">
                                <h4 class="card-title  text-truncate" style="color: rgb(112, 66, 50)"><?php echo $row['name']?></h4>
                                <p class="card-text " >Price:<span id="localPrice" class="font-weight-bold" style="color:orange" ><?php echo $row["price"] ?></span>$</p>

                            <button onclick="openOrderDetails('<?php echo $row['id'] ?>','<?php echo $row['name'] ?>')" id="addCart"   class="btn btn-block rounded-pill"style="color:white;background-color:orange" >Add To Cart</button>

                            </div>
                        </div>
                    </div>
                    
                
                </div>
                </div>
                <?php  $i++; ?>
                
            <?php  endforeach; ?>
        </div>
        
    
    </div> 
   

        <div id="cart-form" class="col-md-4" style="background-color:white;height: auto;">
            <H1 id="cartOrder" class="m-2" style="color: rgb(112, 66, 50)">Cart</H1>
            <form action="<?php url('orders/store'); ?>" method="POST" >
                <h3 style="color:orange">Notes</h3>
                <textarea name="notes" id="notes" cols="30" rows="5"></textarea><br>
                <input type="number" name="id_user" id="id_user" hidden>
                <input type="number" name="totalPriceOrder" id="totalPriceOrder" hidden>
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
                <div class="row">
                    <div class="col-md-8 p-3">Total Price</div>
                    <div  class="col-md-4 p-3" style="color:orange"><span id="totalPrice">0.00</span>$</div>
                </div>
                <button type="submit" class="btn rounded-pill mb-3"style="background-color:orange">Place an Order</button>
            </form>
        
        </div>
        </div>

    </div>
<script>
function openOrderDetails(id,nameProduct) {
  let localQuantityelement = document.getElementById("localQuantity"+nameProduct);
  let localQuantity = parseInt(localQuantityelement.innerText);

  let totalprice=document.getElementById("totalPrice") ;
  let  total=parseInt(totalprice.innerText)
    fetch(`<?php url('/products/cart/${id}/${localQuantity}/${total}') ?>`)
    .then(async (res) => {
         
    let data = await res.json();
    console.log(data);
    if(data["first"]==0){
        let input = document.getElementById("quantity"+data["name"]);
        let inputprice = document.getElementById("price"+data["name"]);

        if(input){
            input.innerText = parseInt(data["quantity"]) ;
            inputprice.innerText = parseInt(data["price"]);
        }
    }
    else{
        let row = document.createElement("div");
        row.id="id"+data['name']
        row.className="card border border-white";
        const imageUrl = `data:image/jpeg;base64,${data['picture']}`;
        row.innerHTML=`
        <div class="row">
                     <div class="col-md-5 mt-3"  >
                     <img id='image${data['name']}' src="${imageUrl}"  height="100%" width="100px" />
                      
                     </div>
                     <div class="col-md-7">
                            <div class="card-body">
                        <h4 class="card-title" id="${data['name']}" style="color: rgb(112, 66, 50)">${data['name']}</h4>
                        <span  class="card-text " >Price:<span id='price${data['name']}' class="font-weight-bold" style="color:orange" >${data['price']}</span>$</span>
                        <a  onclick="decreaseQuantity(${data['id']},'quantity${data['name']}')" class="btn btn-sm btn-outline-secondary rounded-circle ms-3 border-dark mt-2 font-weight-bold" >-</a>
                        <span id='quantity${data['name']}'>${data['quantity']}</span>
                        <a  onclick="increaseQuantity(${data['id']},'quantity${data['name']}')" class="btn btn-sm btn-outline-secondary rounded-circle  border-dark mt-2 font-weight-bold" >+</a>
                        <button onclick="deleteCart(${data['id']},this)"  class="btn rounded-pill ms-5 mt-3"style="color:white;background-color:red">Delete</button>
                        
                        </div>
                </div>
        `;
        let exitelement = document.getElementById("cartOrder") ;
        // document.getElementById("cart-form").appendChild(row);//to show on myView
        exitelement.insertAdjacentElement("afterend", row);
        const newElement = document.createElement("hr");
        newElement.id="hr"+data["name"];
        row.insertAdjacentElement("afterend", newElement);
       

    }    
    let totalprice=document.getElementById("totalPrice") ;
        totalprice.innerText=data["totalPrice"];
        
    let totalPriceOrder=document.getElementById("totalPriceOrder") ;
    totalPriceOrder.value=data["totalPrice"];
       
    })
    .catch((error) => console.log(error));

}
 //when click button delete 
 function deleteCart(id,btn){
    let totalprice=document.getElementById("totalPrice") ;
  let  total=parseInt(totalprice.innerText);

  console.log(id,total);
  
    fetch(`<?php url('/products/delectfromcart/${id}/${total}') ?>`)
    .then(async (res) => {
        
        let data = await res.json(); 
        let totalprice=document.getElementById("totalPrice") ;
        totalprice.innerText=data["totalPrice"];
        let totalPriceOrder=document.getElementById("totalPriceOrder") ;
    totalPriceOrder.value=data["totalPrice"];
        const rowid = document.getElementById("id"+data["name"]);
        rowid.remove();
      

        const rowhr = document.getElementById("hr"+data["name"]);
        rowhr.remove();
        
        
    })
    .catch((error) => console.log(error));
   }
function funincreaseQuantity(name){
    let quantity = document.getElementById(name);
    quantity.innerText=parseInt(quantity.innerText)+1;

}
function increaseQuantity(id,name){
    let quantity = document.getElementById(name);
    quantity.innerText=parseInt(quantity.innerText)+1;
  let localQuantity = parseInt(quantity.innerText);

  let totalprice=document.getElementById("totalPrice") ;
  let  total=parseInt(totalprice.innerText)

  
    fetch(`<?php url('/products/cart/${id}/${localQuantity}/${total}') ?>`)
    .then(async (res) => {
         
    let data = await res.json();
    let totalPriceOrder=document.getElementById("totalPriceOrder") ;
    totalPriceOrder.value=data["totalPrice"];
    if(data["first"]==0){
        let input = document.getElementById("quantity"+data["name"]);
        let inputprice = document.getElementById("price"+data["name"]);

        if(input){
            input.innerText = parseInt(data["quantity"]) ;
            inputprice.innerText = parseInt(data["price"]);
            let totalprice=document.getElementById("totalPrice") ;
        totalprice.innerText=data["totalPrice"];
        }
    }
})
    .catch((error) => console.log(error));
}
function fundecreaseQuantity(name){
    let quantity = document.getElementById(name);
    if(parseInt(quantity.innerText)-1>0)
          quantity.innerText=parseInt(quantity.innerText)-1;

}
function decreaseQuantity(id,name){
    let quantity = document.getElementById(name);
    if(parseInt(quantity.innerText)-1>0)
          quantity.innerText=parseInt(quantity.innerText)-1;
  let localQuantity = parseInt(quantity.innerText);

  let totalprice=document.getElementById("totalPrice") ;
  let  total=parseInt(totalprice.innerText)
  
    fetch(`<?php url('/products/cart/${id}/${localQuantity}/${total}') ?>`)
    .then(async (res) => {
         
    let data = await res.json();
    let totalPriceOrder=document.getElementById("totalPriceOrder") ;
    totalPriceOrder.value=data["totalPrice"];
    if(data["first"]==0){
        let input = document.getElementById("quantity"+data["name"]);
        let inputprice = document.getElementById("price"+data["name"]);

        if(input){
            input.innerText = parseInt(data["quantity"]) ;
            inputprice.innerText = parseInt(data["price"]);
            let totalprice=document.getElementById("totalPrice") ;
        totalprice.innerText=data["totalPrice"];
        }
    }
})
    .catch((error) => console.log(error));
}
function selectUser(element,id) {
    var selectedUser = element.textContent;
    var dropdownButton = document.querySelector('.dropdown-toggle');
    dropdownButton.textContent = selectedUser;
    // console.log(id)

    fetch(`<?php url('/products/getIdUser/${id}') ?>`)
        .then(async (res) => {
            let data = await res.json();
            
            let id = document.getElementById("id_user");
            id.value=data['userId'];
        })
}
function selectroom(element){
    var selectedUser = element.textContent;
    var dropdownButton = document.querySelector('#userroom');
    dropdownButton.textContent = selectedUser;
    
    let id = document.getElementById("userroomNumber");
            id.value=selectedUser;
}
</script>

<?php  include(VIEWS.'template'.DS.'footer.php');  ?>
