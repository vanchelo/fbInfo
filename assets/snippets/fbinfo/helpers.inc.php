<?php

if (!function_exists('array_get')) {
	function array_get($array, $key, $default = null) {
		if (empty($key)) {
			return $default;
		}

		if (isset($array[$key])) {
			return $array[$key];
		}

		foreach (explode('.', $key) as $segment) {
			if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
				return $default;
			}

			$array = $array[$segment];
		}

		return $array;
	}
}

function prepare_field($key) {
	return preg_replace('/[^a-z0-9._]+/is', '', (string) $key);
}

if (!function_exists('fileGetContents')) {
	function fileGetContents($url) {
		$url = str_replace(' ', '+', $url);

		if ( ! function_exists('curl_init')) {
			return file_get_contents($url);
		}

		$ch = curl_init();
		curl_setopt_array($ch, [
			CURLOPT_URL => $url,
			CURLOPT_TIMEOUT => 10,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FOLLOWLOCATION => 1,
			CURLOPT_USERAGENT => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36"
		]);
		$response = curl_exec($ch);
		if ($response === false) {
			trigger_error(curl_error($ch));
		}
		curl_close($ch);

		return $response;
	}
}
