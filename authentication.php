<?php
    session_start();
    include("dbcon.php");

    if(isset($_SESSION["verified_user_id"])){
        $uid = $_SESSION["verified_user_id"];
        $idTokenString = $_SESSION["idTokenString"];

        try {
            $verifiedIdToken = $auth->verifyIdToken($idTokenString);
        } catch (InvalidToken $e) {
           // echo 'The token is invalid: '.$e->getMessage();
            $_SESSION['expiry_status']="Token Expired/Invalid. Login Again.";
            header("Location: logout.php");
            exit();
        } catch (\InvalidArgumentException $e) {
            echo 'The token could not be parsed: '.$e->getMessage();
            $_SESSION['expiry_status']="Token Expired/Invalid. Login Again.";
            header("Location: logout.php");
            exit();
        }
    }else{
        $_SESSION['status']="Login to access to this page";
        header("Location: login.php");
        exit();
    }
?>