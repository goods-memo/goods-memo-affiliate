<?php

namespace goodsmemo\item\html;

use goodsmemo\item\html\ItemHTMLOption;
use goodsmemo\shortcode\ShortcodeAttribute;

require_once GOODS_MEMO_DIR . "item/html/ItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "shortcode/ShortcodeAttribute.php";

class ItemHTMLUtils {

	public static function setNumberToDisplayTo(ItemHTMLOption $option, ShortcodeAttribute $shortcodeAttribute, $numberToDisplayOfOptionMap) {

		$number = $shortcodeAttribute->getNumberToDisplay ();
		if (is_numeric ( $number )) { // ゼロも有効とした。
			$option->setNumberToDisplay ( $number );
		} else {
			$option->setNumberToDisplay ( $numberToDisplayOfOptionMap );
		}
	}

	public static function setTitleLengthTo(ItemHTMLOption $option, ShortcodeAttribute $shortcodeAttribute, $titleLengthOfOptionMap) {

		$titleLength = $shortcodeAttribute->getItemTitleLength ();
		if ($titleLength === "") { // ショートコードの属性が未指定なら。0と””を区別するには ===（厳密な比較） を使います。
			$option->setTitleLength ( $titleLengthOfOptionMap );
		} else {
			$option->setTitleLength ( $titleLength );
		}
	}
}

