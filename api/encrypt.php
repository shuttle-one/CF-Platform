<!--/* Copyright (C) 2020 ShuttleOne - All Rights Reserved */-->
<?php


function encrypt($text) {
	$method = 'ENCRYPT';
	$kkey = 'SECRET_KEY';
	    
	$encrypted = bin2hex(openssl_encrypt($text, $method, $kkey));
	return '/data/'.$encrypted;
}

?>