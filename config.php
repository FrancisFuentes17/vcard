<?php

//Application
$appName = "IMS ANEC - VCard Generator";
$appVersion = "1.0.4";

//DB Credential 2
$host = "legacy-db.ims.com.ph";
$database = "imswellness";
$username = "francisfuentes";
$password = "hLOnjHRz7d1pcEg";

//DB Credential 2
$host2 = "203.82.44.198";
$database2 = "iwc_prod";
$username2 = "ims_medi";
$password2 = "iwcmedi";

//Date & Time
date_default_timezone_set("Asia/Manila");
$currentDate = date("Y-m-d");
$currentTime = date("H:i:s");

//SMTP
$smtpHost = ""; 
$smtpUser = ""; //Email or API
$smtpPassword = "";
$smtpPort = "";
$smtpBCCEmail = ""; //Make it blank if you dont want to send copy
$smtpSending = false;

//Debug
$debugMode = true;

//Maintenance
$maintenanceMode = false;

?>