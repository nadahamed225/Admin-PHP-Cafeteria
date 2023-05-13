function orderDetails(idOrder)
{
fetch(`/checks/orderDetails/${idOrder}`)
.then(async (res) => {
let data = await res.json(); 
console.log(data);

let d=`order${idOrder}`;
console.log(d);

let elem=document.getElementById(d);
let contentOrder="";
for( let x in data)
{

    contentOrder+=
       `
        <div class="col-12 mt-2 mb-2">
        <div class="row">
        <div class="col-lg-3 col-12">
        <img  src="data:image/jpeg;base64,${data[x].picture}"/>
        </div>
        <div class="col-lg-3 col-12">${data[x].name}</div>
        <div class="col-lg-3 col-12">
        ${data[x].quantity} Qt
        </div>
        <div class="col-lg-3 col-12">${data[x].price*data[x].quantity} $</div>
    
        </div>
        </div>
        `

}

  elem.innerHTML=contentOrder;


}
);

}



function userOrder(idUser)
{

fetch(`/checks/ordersUser/${idUser}`)
.then(async (res) => {
let data = await res.json(); 
console.log(data);

let d=`user${idUser}`;
console.log(d);

let elem=document.getElementById(d);
let content="";
for( let x in data)
{
    console.log(x);
  

        content+=`
        <div class="card">
        <div class="card-header" id="headingOrder${data[x].id}">
        <h2 class="mb-0">
         <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOrder${data[x].id}" aria-expanded="false" aria-controls="collapseOrder${data[x].id}"
         type="button" onClick="orderDetails(${data[x].id})">
             <div class="col-5">${data[x].date}</div>
             <div class="col-4">${data[x].totalprice}$</div>
             <div class="col-3">
             <span class="fa-stack fa-2x">
             <i class="fas fa-circle fa-stack-2x"></i>
             <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
           </span>
           </div>
          
         </button>
        </h2>
        </div>
 
     <div id="collapseOrder${data[x].id}" class="collapse" aria-labelledby="headingOrder${data[x].id}"          data-parent="#subaccordion${idUser}">
       <div class="card-body" id="order${data[x].id}">
        
 
         </div>
 
       </div>
     </div>
        
        `
}

elem.innerHTML=content;


}
);

}

