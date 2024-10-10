<?php 


function myAuto($class) {
    include "classes/" . $class . ".class.php";
}

spl_autoload_register("myAuto");
