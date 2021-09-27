<?php

if($_SESSION['ADMIN_LEVEL']!="เจ้าของร้าน"){
    header("location:dashboard.php");
}