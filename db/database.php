<?php     
    $user = "";
    $pass = "";
    $db_name = "";
    $server ="";
 
    try {
        $con = new PDO('mysql:host='.$server.';dbname='.$db_name.'', $user, $pass);   
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage() ;  
    }