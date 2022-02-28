<?php

/*
 * Copyright (C) 2018 Goods Memo.
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

namespace goodsmemo\network;

use goodsmemo\exception\HttpRequestException;

require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";

/**
 * Description of HTTPRequest
 *
 * @author Goods Memo
 */
class HTTPRequest {

	public static function getContents($url, $timeout = 15, $retryCount = 3) {
		//$timeout = 5 の場合、テスト用ページでタイムアウトエラーになった。
		//例：cURL error 28: Operation timed out after 0 milliseconds with 0 out of 0 bytes received.

		$args = array('timeout' => $timeout);
		$lastResponseCode;
		$lastErrorMessage;

		for ($i = 0; $i < $retryCount; $i++) {

			if ($i >= 1) {
				sleep(1); //再試行の待ち時間（１秒）
			}

			/*
			 * WordPressのwp_remote_get関数を使う。
			 * PHPのfile_get_contents関数より、エラー処理をしやすいから。
			 */
			$response = wp_remote_get($url, $args);
			if (is_wp_error($response)) {
				$lastResponseCode = -1; //$errorCode = $response->get_error_code(); // WP_Error() の第一引数 //レスポンスコードでない
				$lastErrorMessage = $response->get_error_message(); // WP_Error() の第二引数
				continue;
			}

			$lastResponseCode = $response["response"]["code"];
			//$lastResponseCode = 500;//$lastResponseCode = 503;
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

	public static function makeQueryString($parameterMap) {

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
