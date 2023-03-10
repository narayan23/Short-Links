<?php
include('db.php');
$input=file_get_contents('php://input');
$data=json_decode($input);
$uname=$data->message->from->first_name;
$chat_id=$data->message->chat->id;
$text=$data->message->text;
$token='6049229496:AAErp2QkCEU57S4sWJFuBV9l   _gkmOcfczmo'

if($text=='/start'){
	$msg="Welcome $uname. %0APlease enter your url";
}else{
	$randstr=str_shuffle("abcdefghijklmnopqrstuvwxlmnopqrstuvwxyz");
	$alias=substr($randstr,0,5);
	$url = urlencode($text);
	$json = file_get_contents("https://cutt.ly/api/api.php?key=478bb57a844977f0bb15e46ce26e02299b3be&short=$url&name=$alias");
	$data = json_decode ($json, true);
	if(isset($data['url']['status'])){
		$arr=["","the shortened link comes from the domain that shortens the link, i.e. the link has already been shortened","the entered link is not a link","the preferred link name is already taken","Invalid API key","the link has not passed the validation. Includes invalid characters","The link provided is from a blocked domain"];
		if($data['url']['status']==7){
			$msg="Here are your short link %0A".$data['url']['shortLink'];
		}else{
			$msg=$arr[$data['url']['status']];
		}
	}
}
$url="https://api.telegram.org/botTOKEN/sendMessage?text=$msg&chat_id=$chat_id&parse_mode=html";
file_get_contents($url);
?>