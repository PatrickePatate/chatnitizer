<!doctype html>
<html lang=fr>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<?php
require("Chatnitizer.php");

//NUMBER
$chatnitizer = new Chatnitizer("number","245fes");
echo $chatnitizer->toString()."<br />";

// INPUT
$chatnitizer = new Chatnitizer("input","www.testÅÅ.com");
echo $chatnitizer->toString()."<br />";

// STRING
$chatnitizer = new Chatnitizer("string","<a href=''>www.testÅÅ.com</a>");
echo $chatnitizer->toString()."<br />";

// INPUT WITHOUT HTML
$chatnitizer = new Chatnitizer("removehtml|input","<a href=''>www.testÅÅ.com</a>");
echo $chatnitizer->toString()."<br />";

// URL
$chatnitizer = new Chatnitizer("removehtml|url","<a href=''>https://www.testÅÅ.com</a>");
echo $chatnitizer->toString()."<br />";

// EMAIL
$chatnitizer = new Chatnitizer("email","#@%^%#$@#$@#.com");
var_dump($chatnitizer->toString())."<br />";
?>

</body>
</html>
