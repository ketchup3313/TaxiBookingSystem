<?php     
require "db/database.php";
//return format
header('Content-Type: application/json');

$returndata = [];
// get the form inputs
$cname = $_POST['cname'];
$phone = $_POST['phone'];
$unumber = $_POST['unumber'];
$snumber = $_POST['snumber'];
$stname = $_POST['stname'];
$sbname = $_POST['sbname'];
$dsbname = $_POST['dsbname'];
$date = $_POST['date'];
$time= $_POST['time'];

// set the current date
$now = date("Y-m-d h:i:s");
$status = "unassigned";
//generate a ref number
$ref_num = random5();

// insert booking in db
$query = $con->prepare("INSERT INTO booking (ref_num ,cname,phone,unumber,snumber,stname,sbname,dsbname,date,time , datetime, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
$insert = $query->execute([ $ref_num, $cname ,$phone ,$unumber ,$snumber, $stname, $sbname, $dsbname, $date, $time , $now, $status]);

if($insert){  // booking added successfully
    $returndata['success'] = "&#9989 Thank you for your booking! </br>Your booking reference number is BRN".$ref_num.".  </br>
    You will be picked up in front of your provided address at ".$time." on ".$date.".
	****Please do take a screenshot or copy the reference number.****" ;
}else{
    $returndata['success']= "something went wrong adding your booking";
}
// return the result in json format
echo json_encode($returndata);




//function to generate 5 random numbers
function random5() {
    $number = "";
    for($i=0; $i<5; $i++) {
      $min = ($i == 0) ? 1:0;
      $number .= mt_rand($min,9);
    }
    return $number;
  }