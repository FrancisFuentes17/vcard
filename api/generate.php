<?php

session_start();
include("../config.php");

//User Input
$jsonData = file_get_contents("php://input");
$obj = json_decode($jsonData); 

//Response Array
$json = array(
    "status" => "Success",
    "feedback" => ""
);

//Check if JSON String is not empty
if($obj != "") {

    $conn = new mysqli($host,$username,$password,$database);
	mysqli_set_charset($conn, "utf8mb4");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn2 = new mysqli($host2,$username2,$password2,$database2);
	mysqli_set_charset($conn, "utf8mb4");
    if ($conn2->connect_error) {
        die("Connection failed: " . $conn2->connect_error);
    }

    $cardNo = strip_tags(mysqli_real_escape_string($conn, $obj->cardNo));
    $acct = strip_tags(mysqli_real_escape_string($conn, $obj->acct));

    $dataConn = $conn;
    if($acct == "IWC") {
        //Switch connection for IWC Members 
        $dataConn = $conn2; 
    }
    
    $json['cardFront']  = "ims-anec/vcard-front-v2-free.png";
    $json['cardBack'] = "ims-anec/vcard-back-v2-free.png";
    $json['cardNo'] = "";
    $json['qrData'] = "";
    $json['memberName'] = "";
    $json['company'] = "";
    $json['acct'] = $acct;

    if($cardNo != "") {

        //Check if card no. exist
        if($acct != "ANEC") {
            $query = "SELECT MemberName, IWCCardNo, EffectiveDate, o.Classification as company, public_id  FROM planholder ph
            LEFT JOIN office o ON ph.OfficeCode=o.OfficeCode
            WHERE IWCCardNo='".$cardNo."' ";
            $result = $dataConn->query($query);
            if ($result->num_rows > 0) {
                if($row = $result->fetch_assoc()) {
                    $json['memberName'] = $row["MemberName"];
                    $json['company'] = $row["company"];
                    $json['cardNo'] = $row["IWCCardNo"];

                    if($acct == "IMS") {
                        $json['cardFront']  = "ims-anec/vcard-front-v2.png";
                        $json['cardBack'] = "ims-anec/vcard-back-v2.png";
                    } else {
                        $json['cardFront']  = "iwc/iwc-vcard-front-v2.png";
                        $json['cardBack'] = "iwc/iwc-vcard-back-v2.png";
                    }
                    
                    $json['qrData'] = "https://amap.iwcsrvr.com/auth?pid=".$row["public_id"]."&acct=".$acct;
                    
                }
            } else {
                $json['status'] = "Failed";
                $json['feedback'] = "Invalid Card Number ".$cardNo;
            }
        } else {
            $query = "SELECT concat('A-', LPAD(id, 6, 0)) as ANECCardNo, concat(firstName,' ',lastName) as MemberName FROM anec_registered 
            WHERE email like '%".$cardNo."%' AND basic='0' ";
            $result = $dataConn->query($query);
            if ($result->num_rows > 0) {
                if($row = $result->fetch_assoc()) {
                    $json['cardNo'] = $row["MemberName"];
                    $json['company'] = "Basic Membership Card";
                }
            } else {
                $json['status'] = "Failed";
                $json['feedback'] = "Invalid User Id ".$cardNo;
            }

        }
        
    }
    
    //Close Connection
    $dataConn->close();

    //Give Feedback
    exit(json_encode($json));

} else {
    exit("cannot get /generate");
}

?>