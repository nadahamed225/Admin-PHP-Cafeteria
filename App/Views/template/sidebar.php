
<sidebar class="row g-0">
    <div class="logo text-center d-md-block d-none"><h2>CAFFEE</h2></div>

    <ul class="text-center mt-3">
    <li class="row g-0" id="home" >
    <a  href="<?php url('products/home'); ?>">
    <i class="fa fa-home"></i>
    <p>Home</p>
    </a>
    </li>

    <li class="row g-0" id="categories">
     <a href="<?php url('categories/index'); ?>">
     <i class="fa-solid fa-briefcase"></i> 
     <p>Categories</p>
    </a>
    </li>

    <li class="row g-0" id="products"><a href="<?php url('products/index'); ?>">
    <i class="fa-solid fa-cart-shopping"></i>
    <p>Products</p>
    </a></li>
    <li class="row g-0 " id="users"><a href="<?php url('users/index'); ?>">
    <i class="fa fa-users"></i><p>Users</p></li>

    <li class="row g-0" id="checks"><a href="<?php url('checks/index'); ?>">
    <i class="fa-solid fa-cart-shopping"></i>
        <p>Checks</p></a></li>

    <li class="row g-0" id="orders"><a href="<?php url('orders/index'); ?>"> 
    <i class="fa-solid fa-cart-shopping"></i>
    <p>orders</p></a></li>
   </ul>

</sidebar>


<script>
let arr=['orders','users','checks','products','categories'];
 $url=(window.location.pathname).split('/');
 $action=$url[2];
 $url=$url[1];
 
  
    if($action=='home')
    {
        let link=document.getElementById('home');
        link.classList.add('active');
    }else
    {
   for(let i=0;i<arr.length;i++)
   {
    if(arr[i]==$url)
    {
        let link=document.getElementById(arr[i]);
        link.classList.add('active');
    }
 }
 }
 
</script>