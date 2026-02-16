<?php

namespace goodsmemo\network;

use goodsmemo\exception\HttpRequestException;

require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";

class HTTPRequest
{

	public static function getContents($url, $requestArguments, $requestCount = 2)
	{
		$lastResponseCode = "";
		$lastErrorMessage = "";

		for ($i = 0; $i < $requestCount; $i++) {

			if ($i >= 1) {
				sleep(1); // 再試行の待ち時間（１秒）
			}

			/*
			 * WordPressのwp_remote_get関数を使う。
			 * PHPのfile_get_contents関数より、エラー処理をしやすいから。
			 */
			$response = wp_remote_get($url, $requestArguments);
			if (is_wp_error($response)) {
				$lastResponseCode = -1; // $errorCode = $response->get_error_code(); // WP_Error() の第一引数 //レスポンスコードでない
				$lastErrorMessage = $response->get_error_message(); // WP_Error() の第二引数
				continue;
			}

			$lastResponseCode = $response["response"]["code"];
			// $lastResponseCode = 500;//$lastResponseCode = 503;
			if ($lastResponseCode == 200) {
				$contents = $response['body'];
				return $contents;
			} else {
				$scheme = parse_url($url, PHP_URL_SCHEME);
				$host = parse_url($url, PHP_URL_HOST);
				$path = parse_url($url, PHP_URL_PATH);
				$lastErrorMessage = "HTTPリクエストの失敗：URL=[" . $scheme . "://" . $host . $path . "]";
			}
		}

		throw new HttpRequestException($lastErrorMessage, $lastResponseCode);
	}

	public static function makeQueryString($parameterMap)
	{

		ksort($parameterMap);

		$encodedParameterArray = array();
		foreach ($parameterMap as $key => $value) {

			$oneParameter = rawurlencode($key) . "=" . rawurlencode($value);
			array_push($encodedParameterArray, $oneParameter);
		}

		$queryString = join("&", $encodedParameterArray);
		return $queryString;
	}
}
