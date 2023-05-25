<?php

namespace goodsmemo\item\html;

class HTMLUtils {

	public static function makePlainText($text) {

		$output = trim ( $text );
		$output = strip_tags ( $output ); // HTML および PHP タグを取り除きます。
		$plainText = esc_html ( $output ); // HTMLエスケープ。例：「<」を「&lt;」、「&」を「&amp;」に書き換える。

		return ( string ) $plainText;
	}
}
