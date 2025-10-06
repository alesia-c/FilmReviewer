<?php
// ky funksion kontrollon nese email-i i dhene nga perdoruesi ekziston ne database
function emailExists($email){

    include "connect.php";

    $sql = $db_connection->prepare("SELECT * FROM users WHERE email = ?");
    $sql -> bind_param("s", $email);
    $sql -> execute();
    $result = $sql->get_result();

    if($result -> num_rows === 0){
        return false;
    }
    else{
        return true;
    }

}