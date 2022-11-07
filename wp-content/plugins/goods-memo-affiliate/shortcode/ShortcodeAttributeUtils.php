<?php

namespace goodsmemo\shortcode;

use goodsmemo\exception\IllegalArgumentException;

require_once GOODS_MEMO_DIR . "exception/IllegalArgumentException.php";

class ShortcodeAttributeUtils {

	public static function makeShortcodeAttribute($operation, $searchIndex, $keyword, $numberToDisplay, $itemTitleLength, $itemReviewLength): ShortcodeAttribute {

		ShortcodeAttributeUtils::isZeroOrMore ( $numberToDisplay, "無効な表示件数" );

		if (trim ( $keyword ) === "") { // 0と””を区別するには ===（厳密な比較） を使います。
			throw new IllegalArgumentException ( "検索キーワードが空です：[" . $keyword . "] number：[" . $numberToDisplay . "]" );
		}

		if (trim ( $itemTitleLength ) === "") { // 0と””を区別するには ===（厳密な比較） を使います。
			; // 任意指定の属性なので、正しい
		} else {
			ShortcodeAttributeUtils::isZeroOrMore ( $itemTitleLength, "無効な商品名の表示文字数" );
		}

		if (trim ( $itemReviewLength ) === "") { // 0と””を区別するには ===（厳密な比較） を使います。
			; // 任意指定の属性なので、正しい
		} else {
			ShortcodeAttributeUtils::isZeroOrMore ( $itemReviewLength, "無効な商品説明の表示文字数" );
		}

		$shortcodeAttribute = new ShortcodeAttribute ();
		$shortcodeAttribute->setOperation ( $operation );
		$shortcodeAttribute->setSearchIndex ( $searchIndex );
		$shortcodeAttribute->setKeyword ( $keyword );
		$shortcodeAttribute->setNumberToDisplay ( $numberToDisplay );
		$shortcodeAttribute->setItemTitleLength ( $itemTitleLength );
		$shortcodeAttribute->setItemReviewLength ( $itemReviewLength );

		return $shortcodeAttribute;
	}

	private static function isZeroOrMore($valueText, string $errorMessage) {

		if (is_numeric ( $valueText ) && $valueText >= 0) { // ゼロ以上とした
			; // is関数だから、本来は return true;。以下で例外通知しているので、何もしないことにした。
		} else {
			throw new IllegalArgumentException ( $errorMessage . "：" . $valueText ); // 本来は、return false;
		}
	}
}

