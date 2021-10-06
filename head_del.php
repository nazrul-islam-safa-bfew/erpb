<?php
date_default_timezone_set('Asia/Dhaka');
$content = file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=sirajganj&appid=dea8a6a3882bf855460284c4054fbfae");
$json = json_decode($content, true);

$txt["description"] = explode(" ",$json["weather"][0]["description"])[0];
$txt["icon"] = $json["weather"][0]["icon"];

$txt["temp"] = round($json["main"]["temp"] - 273.15);
$txt["feels_like"] = round($json["main"]["feels_like"] - 273.15);
// $txt["temp_min"] = round($json["main"]["temp_min"] - 273.15);
// $txt["temp_max"] = round($json["main"]["temp_max"] - 273.15);
// $txt["pressure"] = $json["main"]["pressure"];
// $txt["humidity"] = round($json["main"]["humidity"] - 273.15);

$txt["country"] = $json["sys"]["country"];
$txt["sunrise"] = date("h:ia", $json["sys"]["sunrise"]);
$txt["sunset"] = date("h:ia", $json["sys"]["sunset"]);
$txt["name"] = $json["name"];


$myfile = fopen("weather.txt", "w+") or die("Unable to open file!");
fwrite($myfile, json_encode($txt));
fclose($myfile);
?>