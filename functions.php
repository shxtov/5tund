<?php

	$serverHost = "localhost";
	$serverUsername = "if16";
	$serverPassword = "ifikad16";


//    function sum ($x, $y){
//        return $x + $y;
//    }
//
//
//    echo sum(5467473247,123141248123);
//    echo "<br>";
//    $answer = sum(10,15);
//    echo $answer;
//    echo "<br>";
//
//
//    function hello ($name,$surname){
//        return ("Tere tulemast ".$name." ".$surname."!");
//    }
//
//    echo hello('Vladislav','Sutov');


//functions.php

//alustan sessiooni et kasutada $_SESSION
session_start();


//SIGNUP
$db = "if16_vladsuto_1";

function signup ($email, $password, $bday, $gender, $carpref){
    


    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['db']);
    $stmt = $mysqli->prepare("INSERT INTO user_table (email, password, bday, gender, carpref) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $email, $password, $bday, $gender, $carpref);

    if($stmt->execute()){
        $signupNotice ="Registreerimine õnnestus! Suunan...";
        header('Refresh: 3;login.php');
    }else{
        $signupNotice ="Registreerimine ebaõnnestus!";
    }
    return $signupNotice;
}


function login ($email, $password){

    $loginNotice = "";

    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['db']);
    $stmt = $mysqli->prepare("SELECT id, email, password, created FROM user_table WHERE email=?");
    $stmt->bind_param("s", $email);

    //määran tulpadele muutujad
    $stmt->bind_result($id, $emailFromDatabase, $passwordFromDatabase, $created);
    $stmt->execute();

    //küsin rea andmeid
    if($stmt->fetch()){
        //oli rida siis võrdlen paroole
        $hash = hash("sha512", $password);
        if ($hash == $passwordFromDatabase){
            echo "Kasutaja".$email." logis sisse!";
            $_SESSION["userId"] = $id;
            $_SESSION['email'] = $emailFromDatabase;

            //suunaks uuele lehele
            header("Location: data.php");
        }else{
            $loginNotice = "Parool on vale!";
        }

    }else{
        //ei olnud
        $loginNotice ="Sellist kasutajat ei eksisteeri!";
    }
    return $loginNotice;
}

function campusClothing ($gender, $color){
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['db']);
    $stmt = $mysqli->prepare("INSERT INTO campus_clothing (gender, color) VALUES (?,?)");
    $stmt->bind_param("ss", $gender, $color);

    if($stmt->execute()){
        $campusNotice ="Salvestamine õnnestus!";
    }else{
        $campusNotice = "Salvestamine ebaõnnestus!";
    }
    return $campusNotice;
}

function getAllCampusClothing (){
    $mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS['serverPassword'], $GLOBALS['db']);
    $stmt = $mysqli->prepare("SELECT id, gender, color, created FROM campus_clothing");
    $stmt->bind_result($id, $gender, $color, $created);

    $stmt->execute();

    $result = array();

    //seni kuni on üks rida andmeid saada(10 rida = 10 korda)
    while($stmt->fetch()){
        $person = new StdClass();
        $person->clothingId = $id;
        $person->clothingGender = $gender;
        $person->clothingColor = $color;
        $person->clothingCreated = $created;
        array_push($result, $person);
    }
    
    $stmt->close();
    $mysqli->close();

    return $result;
    
    


}