<?php
function check_login(){
    if(!isset($_COOKIE['login'])){
        header("Location:/music/index.php/loginmanager");
    }
}
