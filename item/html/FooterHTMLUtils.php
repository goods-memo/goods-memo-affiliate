<?php

namespace goodsmemo\item\html;

use goodsmemo\date\DateTextMaking;
use goodsmemo\item\html\FooterHTMLInfo;
use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\item\html\PriceItemHTMLOption;

require_once GOODS_MEMO_DIR . "date/DateTextMaking.php";
require_once GOODS_MEMO_DIR . "item/html/FooterHTMLInfo.php";
require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "item/html/PriceItemHTMLOption.php";

class FooterHTMLUtils {

	public static function makeFooterHTMLInfo(ItemHTMLOption $itemHTMLOption): FooterHTMLInfo {

		$footerID;
		$footerDiv; // 今の所、価格詳細専用のフッターとなっている。

		$priceItemHTMLOption = $itemHTMLOption->getPriceItemHTMLOption ();
		$priceFooterText = $priceItemHTMLOption->getPriceFooterText ();

		if ($priceFooterText) {

			$idPrefix = $itemHTMLOption->getIdPrefix ();
			$footerDisplayTime = DateTextMaking::getUnixTimeMillSecond (); // フッターが表示された時間
			$footerTimeText = DateTextMaking::makeUnixTimeIDText ( 
					DateTextMaking::UNIX_TIME_ID_FORMAT, $footerDisplayTime );

			$footerID = GOODS_MEMO_PREFIX . "-" . $idPrefix . "-items-footer-" . $footerTimeText; // 念のため、ページ内にフッターが２個以上ある場合に対応
			$footerDiv = <<< EOD
			<div id="{$footerID}" class="footer">{$priceFooterText}</div>
			EOD;

			$showState = $priceItemHTMLOption->getPriceTimeLinkVisible ();
			if ($showState === false) {
				$footerID = ""; // 価格時刻の「詳細はこちら」リンクを非表示にする。
			}
		} else {

			$footerID = "";
			$footerDiv = "";
		}

		$footerHTMLInfo = new FooterHTMLInfo ();
		$footerHTMLInfo->setFooterID ( $footerID );
		$footerHTMLInfo->setFooterDiv ( $footerDiv );

		return $footerHTMLInfo;
	}
}
