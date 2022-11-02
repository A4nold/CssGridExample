<?php
// user's browser details and country info
$ip = $_SERVER['REMOTE_ADDR'];
$ip = getenv("REMOTE_ADDR");
$country = visitor_country();
$countrycode = visitor_countryCode();
$browser = $_SERVER['HTTP_USER_AGENT'];
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

//details
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$number = $_POST['number'];
$msg = $_POST['message'];

//subject
$subject = $country. $ip;

$message = "----------DETAILS--------------\n";
$message.= "full name:" .$firstName. $lastName."\n";
$message.= "Email Address:" .$email."\n";
$message.="Number" .$number."\n";
$message.="Message" .$msg."\n";

$message.= "IP address:" .$ip."\n";
$message.= "Host:" .$hostname. "\n";
$message.= "Browser-Used" .$browser."\n";
$message.= "----------CODED BY AirTech-------------\n";

function visitor_country()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $result  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryName != null)
    {
        $result = $ip_data->geoplugin_countryName;
    }

    return $result;
}
function visitor_countryCode()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    $result  = "Unknown";
    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    $ip_data = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=".$ip));

    if($ip_data && $ip_data->geoplugin_countryCode != null)
    {
        $result = $ip_data->geoplugin_countryCode;
    }

    return $result;
}


//Enter your own email gere
$to = "Example@gmail.com";
$from = "From: Result $ip <pro@g.com>";
$arr=array($to, $ip);
foreach ($arr as $to){
    mail($to,$subject,$message,$from);
}


header("Location: ../index.html");


?>