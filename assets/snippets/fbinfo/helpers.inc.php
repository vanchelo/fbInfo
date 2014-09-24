<?php

function fileGetContents($url) {
	$url = str_replace(' ', '+', $url);

	if (!function_exists('curl_init')) {
		return file_get_contents($url);
	}

	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_TIMEOUT => 2,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_FOLLOWLOCATION => 0,
		CURLOPT_USERAGENT => "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13 GTB7.1"
	));
	$response = curl_exec($ch);
	if ($response === false) {
		trigger_error(curl_error($ch));
	}
	curl_close($ch);

	return $response;
}
