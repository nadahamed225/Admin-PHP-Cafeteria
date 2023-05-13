function openOrderDetails(id) {
    fetch(`<?php url('/products/cart/${id}') ?>`)
    .then(async (res) => {
        
    let data = await res.json(); 
    if(data["quantity"]>1){
        let input = document.getElementById("quantity"+data["name"]);
        let inputprice = document.getElementById("price"+data["name"]);

        if(input){
            input.value = parseInt(data["quantity"]) ;
            inputprice.value = parseInt(data["price"]) ;
        }
    }
    else{
        let row = document.createElement("div");
        row.className="card border border-white";
        row.innerHTML=`
        <div class="row">
                     <div class="col-md-5 mt-3"  >
                     <img  src="${'data:image/jpeg;base64,'.base64_encode(data['picture'])}"  height="100%" width="100px" />
                     </div>
                     <div class="col-md-7">
                            <div class="card-body">
                        <h4 class="card-title" id="<?php echo $data['name']?>" style="color: rgb(112, 66, 50)"><?php echo $data['name']?></h4>
                        <span id="price<?php echo $data['price']?>" class="card-text " >Price:<span class="font-weight-bold" style="color:orange" ><?php echo $data["price"] ?></span>$</span>
                        <a  class="btn rounded-circle ms-3 border-dark mt-2 font-weight-bold" >-</a>
                        <span id="quantity<?php echo $data['quantity']?>">1</span>
                        <a  class="btn rounded-circle  border-dark mt-2 font-weight-bold" >+</a>
                        <button href="#" class="btn rounded-pill ms-5 mt-3"style="color:white;background-color:red">Delete</button>
                        
                        </div>
                </div>
        `;
        
        document.getElementById("cart-form").appendChild(row);//to show on myView

    }           
    })
    .catch((error) => console.log(error));


    //when click button delete 
   function deleteCart(id,btn){
    fetch(`<?php url('/products/delectfromcart/${id}') ?>`)
    .then(async (res) => {
        
        let data = await res.json(); 
        const elementname = document.getElementById(data["name"]);
        elementname.remove();
   
        const elementprice = document.getElementById("price"+data["name"]);
        elementprice.remove();

        const elementquantity = document.getElementById("quantity"+data["name"]);
        elementquantity.remove();
        const btn = document.getElementById("btn"+data["name"]);
        btn.remove();
    })
    .catch((error) => console.log(error));
   }


}


function funincreaseQuantity(name){
    let quantity = document.getElementById("localQuantity"+name);
    quantity.innerText=parseInt(quantity.innerText)+1;

}

function fundecreaseQuantity(name){
    let quantity = document.getElementById("localQuantity"+name);
    quantity.innerText=parseInt(quantity.innerText)-1;

}