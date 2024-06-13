<?php

$acct = "IMS";
$title = "VCard | IMS-ANEC";
if(isset($_GET['acct'])) {
    if($_GET['acct'] == "IWC") {
        $acct = "IWC";
        $title = "VCard | IMS Wellth Care Inc.";
    }
}

$uid = ""; //ANEC Registered User ID/Email
if(isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $acct = "ANEC";
}

$cardNo = ""; //IMS or IWC Card No
if(isset($_GET['cardNo'])) {
    $cardNo = $_GET['cardNo'];
}

$type = "basic";
if(isset($_GET['type'])) {
    if($_GET['type'] == "classic") {
        $type = "classic";
    } else if($_GET['type'] == "privilege") {
        $type = "privilege";
    }
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="src/css/jquery-confirm.min.css">
    <link rel="stylesheet" href="src/css/bootstrap.min.css" >
    <link rel="stylesheet" href="src/css/styles.css?v=1.0.5">
    <title><?php echo $title; ?></title>
</head>
<body>
    <div class="container">
        <?php if($cardNo == "" && $uid == "") { 
            exit("<div class='error'>Invalid Link</div>");
        } ?>
        <?php include('inc/page_loader.php') ?>
        <div class="vcard"></div>
    </div>
    <script src="src/js/lib/jquery.js"></script>
    <script src="src/js/bootstrap.min.js"></script>
    <script src="src/js/jquery-confirm.min.js"></script>
    <script src="src/js/jquery.validate.min.js"></script>
    <script src="src/js/jquery.flip.min.js"></script>
    <script src="src/js/qrcode.min.js"></script>
    <script src="src/js/vars.js?v=1.0.3"></script>
    <script src="src/js/vcard.js?v=1.0.10"></script>
    <?php if($cardNo != "" || $uid != "") { 

        $cardId = $cardNo;
        if($uid != "") {
            $cardId = $uid;
        }

        echo "<script>generateVCard('".$cardId."','".$acct."')</script>"; 
    } ?>
</body>


