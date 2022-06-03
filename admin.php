<?php     
require "db/database.php";
//return format
header('Content-Type: application/json');


if(isset($_POST['bsearch'])){   // check if the search form is submitted

    $arr_result = [];

    if( $_POST['bsearch'] == ""){  // if the input is empty we return the booking for next 2 hours
        // query to select all booking for next 2 hours
        $query = $con->prepare("SELECT * FROM booking WHERE status = 'unassigned' AND CONCAT(date, ' ', time) BETWEEN NOW() AND NOW() + INTERVAL 2 HOUR"); 
        $select = $query->execute();
        while($res= $query->fetch()){  //put the result of the query in an array
            $row_arr = [];
            $row_arr['ref_num'] = $res['ref_num'];
            $row_arr['cname'] = $res['cname'];
            $row_arr['phone'] = $res['phone'];
            $row_arr['sbname'] = $res['sbname'];
            $row_arr['dsbname'] = $res['dsbname'];
            $row_arr['date'] = $res['date'];
            $row_arr['time'] = $res['time'];
            $row_arr['status'] = $res['status'];
            array_push($arr_result , $row_arr);
        }
        //return the result in json format
        echo json_encode($arr_result);
        
    }else{  // if the input contain a ref number we return that specific booking 
        $booknum = $_POST['bsearch'];
        // query to select one booking with ref_num = $booknum
        $query = $con->prepare("SELECT * FROM booking WHERE ref_num = ?"); 
        $select = $query->execute([$booknum]);
        while($res= $query->fetch()){
            $row_arr = [];
            $row_arr['ref_num'] = $res['ref_num'];
            $row_arr['cname'] = $res['cname'];
            $row_arr['phone'] = $res['phone'];
            $row_arr['sbname'] = $res['sbname'];
            $row_arr['dsbname'] = $res['dsbname'];
            $row_arr['date'] = $res['date'];
            $row_arr['time'] = $res['time'];
            $row_arr['status'] = $res['status'];
            array_push($arr_result , $row_arr);
        }
        echo json_encode($arr_result);
    }

}elseif(isset($_POST['refnum'])){   // assign a booking  
    $booknum = $_POST['refnum'];
     
    $arr_result = [];
    //$arr_result['result']= "nothing";
    $query = $con->prepare("UPDATE booking SET status = 'assigned' WHERE ref_num = ?"); 
    $update = $query->execute([$booknum]);

    if($update){  // if success update
        $arr_result['result'] = "success";
        $arr_result['success'] = "&#9989 Booking with reference booking number BRN".$booknum." is assigned";
    }else{  // if update failed
        $arr_result['result'] = "failed";
        $arr_result['failed'] = "&#10060 Something went wrong";
    }
    
    echo json_encode($arr_result);
}