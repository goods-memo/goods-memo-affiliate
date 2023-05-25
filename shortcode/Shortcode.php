<?php

namespace goodsmemo\shortcode;

use goodsmemo\shortcode\ShortcodeAttributeUtils;
use goodsmemo\amazon\AmazonAffiliate;
use goodsmemo\rakuten\RakutenAffiliate;
use goodsmemo\exception\IllegalArgumentException;
use goodsmemo\exception\OptionException;
use goodsmemo\exception\HttpRequestException;
use goodsmemo\exception\HttpResponseException;

require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttributeUtils.php";
require_once GOODS_MEMO_DIR . "amazon/AmazonAffiliate.php";
require_once GOODS_MEMO_DIR . "rakuten/RakutenAffiliate.php";
require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";
require_once GOODS_MEMO_DIR . "exception/OptionException.php";
require_once GOODS_MEMO_DIR . "exception/HttpRequestException.php";
require_once GOODS_MEMO_DIR . "exception/HttpResponseException.php";

class Shortcode {

	public static function makeAffiliateHTML($atts, $content = null) {

		/*
		 * ショートコードの名前は英小文字、数字、下線を使う必要があります。
		 * 特にハイフン（ダッシュ）には注意して、使わないのが賢明です。
		 * 注意: 属性名は大文字と小文字が混在可能ですが、パース後はいつも小文字になります。
		 */
		$attsMap = shortcode_atts ( 
				array ( // 変数名（属性名） => 初期値
				"service" => "","operation" => "","search_index" => "","keyword" => "",
						"number" => "","item_title_length" => "",
						"item_review_length" => ""
				), $atts );
		extract ( $attsMap ); // 例：変数 $service などを作成する

		if ($number == 0) {

			$message = <<< EOD
			<p class="gma-zero-ads-displayed-message">広告はありません（表示件数の設定[{$number}]件）。</p>
			EOD;
			return $message;
		}

		try {
			$shortcodeAttribute = ShortcodeAttributeUtils::makeShortcodeAttribute ( 
					$operation, $search_index, $keyword, $number, $item_title_length,
					$item_review_length );

			$affiliateHTML;
			switch ($service) {
				case "amazon" :

					$affiliateHTML = AmazonAffiliate::makeHTML ( $shortcodeAttribute );
					break;

				case "rakuten" :

					$affiliateHTML = RakutenAffiliate::makeHTML ( $shortcodeAttribute );
					break;

				default :

					throw new IllegalArgumentException ( "無効なサービス名：" . $service );
			}

			return $affiliateHTML;
		} catch ( IllegalArgumentException $ex ) {

			$message = '<p class="gma-error-message">引数の例外：' . $ex->getMessage () . '</p>';
			return $message;
		} catch ( OptionException $ex ) {

			$message = '<p class="gma-error-message">オプションデータベースの例外：' . $ex->getMessage () .
					'</p>';
			return $message;
		} catch ( HttpRequestException $ex ) {

			$message = '<p class="gma-error-message">HTTPリクエストの例外：' . $ex->getMessage () .
					'。コード：' . $ex->getCode () . '</p>';
			return $message;
		} catch ( HttpResponseException $ex ) {

			$message = '<p class="gma-error-message">HTTPレスポンスの例外：' . $ex->getMessage () .
					'</p>';
			return $message;
		} catch ( \Exception $ex ) {
			// \Exceptionをキャッチすれば、WordPressの「サイトに技術的な問題が発生しています。」を防げるかも？？
			$message = '<p class="gma-error-message">例外：' . $ex->getMessage () . '</p>';
			return $message;
		}
	}
}
