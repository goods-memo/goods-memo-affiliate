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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301 USA
 */
namespace goodsmemo\shortcode;

use goodsmemo\amazon\AmazonAffiliate;
use goodsmemo\rakuten\RakutenAffiliate;
use goodsmemo\exception\IllegalArgumentException;
use goodsmemo\exception\OptionException;
use goodsmemo\exception\HttpRequestException;
use goodsmemo\exception\HttpResponseException;

require_once GOODS_MEMO_DIR . "amazon/AmazonAffiliate.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenAffiliate.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";
require_once GOODS_MEMO_DIR . "exception/OptionException.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";
require_once GOODS_MEMO_DIR . "exception/HttpResponseException.php";

/**
 * Description of Shortcode
 *
 * @author Goods Memo
 */
class Shortcode {

	public static function makeAffiliateHTML($atts, $content = null) {

		// ショートコードの名前は英小文字、数字、下線を使う必要があります。特にハイフン（ダッシュ）には注意して、使わないのが賢明です。
		// 注意: 属性名は大文字と小文字が混在可能ですが、パース後はいつも小文字になります。
		// var_dump($atts);
		$attsMap = shortcode_atts ( array ( // 変数名（属性名） => 初期値
				"service" => "",
				"operation" => "",
				"search_index" => "",
				"keyword" => "",
				"number" => ""
		), $atts );
		extract ( $attsMap ); // 例：変数 $service などを作成する

		try {
			if (is_numeric ( $number ) && $number >= 0) { // ゼロ以上とした
				;
			} else {
				throw new IllegalArgumentException ( "無効な表示件数：" . $number );
			}

			if ($number == 0) {

				$message = <<< EOD
				<p class="gma-zero-ads-displayed-message">広告はありません（表示件数の設定{$number}件）。</p>
				EOD;
				return $message;
			}

			$keyword = trim ( $keyword );
			if (empty ( $keyword )) {
				throw new IllegalArgumentException ( "検索キーワードが空です：[" . $keyword . "] number：[" . $number . "]" );
			}

			$affiliateHTML;
			switch ($service) {
				case "amazon" :

					$affiliateHTML = AmazonAffiliate::makeHTML ( $operation, $search_index, $keyword, $number );
					break;

				case "rakuten" :

					$affiliateHTML = RakutenAffiliate::makeHTML ( $operation, $keyword, $number );
					break;

				default :

					throw new IllegalArgumentException ( "無効なサービス名：" . $service );
			}

			return $affiliateHTML;
		} catch ( IllegalArgumentException $ex ) {

			$message = '<p class="gma-error-message">引数の例外：' . $ex->getMessage () . '</p>';
			return $message;
		} catch ( OptionException $ex ) {

			$message = '<p class="gma-error-message">オプションデータベースの例外：' . $ex->getMessage () . '</p>';
			return $message;
		} catch ( HttpRequestException $ex ) {

			$message = '<p class="gma-error-message">HTTPリクエストの例外：' . $ex->getMessage () . '。コード：' . $ex->getCode () . '</p>';
			return $message;
		} catch ( HttpResponseException $ex ) {

			$message = '<p class="gma-error-message">HTTPレスポンスの例外：' . $ex->getMessage () . '</p>';
			return $message;
		} catch ( \Exception $ex ) {
			// \Exceptionをキャッチすれば、WordPressの「サイトに技術的な問題が発生しています。」を防げるかも？？
			$message = '<p class="gma-error-message">例外：' . $ex->getMessage () . '</p>';
			return $message;
		}
	}
}
