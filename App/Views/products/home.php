<?php  include(VIEWS.'template'.DS.'header.php');
    echo "<script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js' integrity='sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p' crossorigin='anonymous'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js' integrity='sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF' crossorigin='anonymous'></script>
    ";
?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Confirm Order</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5>Order List</h5>
    </div>
      <div class="modal-body">
        <form id="cart-form">
        <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">name</div>
      <div class="col-md-3 ms-auto">price</div>
      <div class="col-md-3 ms-auto">quantity</div>
      <div class="col-md-3 ms-auto " >action</div>


    </div>
    
  </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>



<h1 class="text-center  my-5 py-3">View All Products </h1>

<div class="container">
    <div class="row">
        <div class="col-10 mx-auto p-4 border mb-5">
                <?php if(isset($success)): ?>
                    <h3 class="alert alert-success text-center"><?php  echo $success; ?></h3>
                <?php endif; ?>
                <?php if(isset($error)): ?>
                    <h3 class="alert alert-danger text-center"><?php  echo $error; ?></h3>
                <?php endif; ?>

                 
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    All Users
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <?php 
                    foreach($users as $row):  ?>
                        <li><a class="dropdown-item" href="#"><?php echo $row['name']; ?></a></li>
                    <?php  endforeach; ?>
                </ul>
            </div>


            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">image</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">availability</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                    <th scope="col">Actoin</th>
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
                                <a href="<?php url('/products/edit/'.$row['id']) ?>" class="btn btn-info" >Edit</a>
                            </td>
                            
                            <td>
                                <a href="<?php url('/products/delete/'.$row['id']) ?>" class="btn btn-danger" >Delete</a>
                            </td>
                            <td>
                                <a onclick="openOrderDetails('<?php echo $row['id'] ?>')" id="addCart"   class="btn btn-success" >Add To Cart</a>
                            </td>
                        </tr>
                    <?php  endforeach; ?>
                </tbody>
            </table>


        </div>
    </div>
</div>

<script>
 var exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  var button = event.relatedTarget
  // Extract info from data-bs-* attributes
  var recipient = button.getAttribute('data-bs-whatever')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  var modalTitle = exampleModal.querySelector('.modal-title')
  var modalBodyInput = exampleModal.querySelector('.modal-body input')

  modalTitle.textContent = 'New message to ' + recipient
  modalBodyInput.value = recipient
})


function openOrderDetails(id) {
            fetch(`<?php url('/products/cart/${id}') ?>`)
            .then(async (res) => {
                
            let data = await res.json(); 
            console.log(data["quantity"]);
            if(data["quantity"]>1){
                let input = document.getElementById("quantity"+data["name"]);
                if(input){
                    input.value = parseInt(data["quantity"]) ;
                    
                }
            }
            else{
                let row = document.createElement("tr");
                let nameInput = document.createElement("input");
            nameInput.name = "name";
            nameInput.value = data["name"];
            nameInput.id=data["name"];
            nameInput.style.width = "25%";
            nameInput.disabled = true;  
            // Add name input to a table cell and add it to the row
            let nameCell = document.createElement("td");
            nameCell.appendChild(nameInput);
            row.appendChild(nameCell);

            let priceInput = document.createElement("input");
            priceInput.name = "price";
            priceInput.type="number";
            priceInput.id="price"+data["name"];
            // priceInput.className="col-md-3"
            priceInput.style.width = "20%";
            // priceInput.style.marginLeft = "25px";
            priceInput.style.marginTop = "15px";
            priceInput.min=0;
            priceInput.value = data["price"];
            // document.getElementById("cart-form").appendChild(priceInput);

            // Add name input to a table cell and add it to the row
            let nameCellprice = document.createElement("td");
            nameCellprice.appendChild(priceInput);
            row.appendChild(nameCellprice);

            let quantityInput = document.createElement("input");
            quantityInput.name = data["name"];
            quantityInput.type="number";
            quantityInput.id="quantity"+data["name"];
            // quantityInput.className="col-md-3"

            quantityInput.style.width = "20%";
            // quantityInput.style.marginLeft = "40px";
            quantityInput.style.marginTop = "15px";
            quantityInput.min=0;
            quantityInput.value = data["quantity"];
            // document.getElementById("cart-form").appendChild(quantityInput);

            // Add name input to a table cell and add it to the row
            let nameCellquantity = document.createElement("td");
            nameCellquantity.appendChild(quantityInput);
            row.appendChild(nameCellquantity);

            var btn = document.createElement("a");  //<button> element
            btn.id="btn"+data["name"];
            btn.className = "btn btn-danger ";

            // btn.style.marginLeft = "25px";
            var t = document.createTextNode("Delete"); // Create a text node
            btn.appendChild(t);   

            btn.onclick = ()=>{
                deleteCart(data["id"],this);
            }
            // document.getElementById("cart-form").appendChild(btn);//to show on myView

            // Add name input to a table cell and add it to the row
            let nameCellbtn = document.createElement("td");
            nameCellbtn.appendChild(btn);
            row.appendChild(nameCellbtn);
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

</script>
<?php  include(VIEWS.'template'.DS.'footer.php'); ?>
