<?php 

// define routes 
function url($url='')
{
    // if(isset($_SESSION["email"]))
        echo BURL.$url;
}

// redirect
function redirect($url)
{
    // if(isset($_SESSION["email"]))
        return  BURL.$url;
}

