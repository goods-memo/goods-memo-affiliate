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
namespace goodsmemo\item\html;

use goodsmemo\item\ReviewItem;
use goodsmemo\item\html\ReviewItemHTMLOption;
use goodsmemo\text\TextUtils;

require_once GOODS_MEMO_DIR . "item/ReviewItem.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "text/TextUtils.php";

/**
 * Description of ReviewItemHTMLUtils
 *
 * @author Goods Memo
 */
class ReviewItemHTMLUtils {
	public static function makeReviewItemHTMLOption($optionMap, $editorialReviewLengthID, $arrayOfStringToDeleteID, $arrayOfStringToBreakID): ReviewItemHTMLOption {
		$reviewItemHTMLOption = new ReviewItemHTMLOption ();

		$reviewLength = $optionMap [$editorialReviewLengthID]; // var_dump($reviewLength);
		$reviewItemHTMLOption->setReviewLength ( $reviewLength );

		$arrayOfStringToDelete = json_decode ( $optionMap [$arrayOfStringToDeleteID], true ); // true：連想配列に変換する
		$reviewItemHTMLOption->setArrayOfStringToDelete ( $arrayOfStringToDelete ); // var_dump($arrayOfStringToDelete);

		$arrayOfStringToBreak = json_decode ( $optionMap [$arrayOfStringToBreakID], true ); // true：連想配列に変換する
		$reviewItemHTMLOption->setArrayOfStringToBreak ( $arrayOfStringToBreak );

		return $reviewItemHTMLOption;
	}
	public static function makeFitReviewText(ReviewItem $reviewItem, ReviewItemHTMLOption $reviewItemHTMLOption) {
		// 「ちょうどいい」の単語で「fit」を選んだ。
		$reviewLength = $reviewItemHTMLOption->getReviewLength ();

		$reviewText;

		$reviewLineArray = $reviewItem->getReviewLineArray ();
		if (count ( $reviewLineArray ) > 0) {

			$reviewText = ReviewItemHTMLUtils::makeFitReviewLinesText ( $reviewLineArray, $reviewLength );
		} else {

			$plainTextReview = $reviewItem->getPlainTextReview ();
			// HTML終了タグがないので、文字列を途中で切断できる。平文なので、HTML文法エラーとならない。
			$reviewText = TextUtils::mb_strimwidth ( $plainTextReview, 0, $reviewLength, "…" ); // $reviewLengthは、文字幅（見た目の長さ）を示す。
		}

		$arrayOfStringToDelete = $reviewItemHTMLOption->getArrayOfStringToDelete ();
		$reviewText = ReviewItemHTMLUtils::deleteStringFrom ( $reviewText, $arrayOfStringToDelete ); // 表示したくない文字列を削除する。

		$arrayOfStringToBreak = $reviewItemHTMLOption->getArrayOfStringToBreak ();
		$reviewText = ReviewItemHTMLUtils::addLineBreakTo ( $reviewText, $arrayOfStringToBreak ); // 文字列の手前に、改行タグを追加する。

		return $reviewText;
	}
	private static function makeFitReviewLinesText($reviewLineArray, $reviewLength) {
		$fitReviewLinesText = "";
		$BR_TAG = "<br>";

		$lineCount = count ( $reviewLineArray );
		$lastIndex = $lineCount - 1;

		for($i = 0; $i < $lineCount; $i ++) {

			$fitReviewLinesText .= $reviewLineArray [$i];

			// $BR_TAGを加えた長さで判定する。例：mb_strimwidthの数え間違い例：<br>…… が <br…… という風に切断されていた。
			$stringWidth = mb_strwidth ( $fitReviewLinesText . $BR_TAG, "UTF-8" ); // 文字幅（見た目の長さ） //var_dump($stringWidth);
			if ($stringWidth >= $reviewLength) {

				$fitReviewLinesText = TextUtils::mb_strimwidth ( $fitReviewLinesText, 0, $reviewLength, "…" );
				break;
			}

			if ($i < $lastIndex) {
				$fitReviewLinesText .= $BR_TAG;
			}
		}

		return $fitReviewLinesText;
	}
	private static function deleteStringFrom($reviewText, $arrayOfStringToDelete) {

		// 一行で処理できた。メソッドにする必要はなかった。
		$newReviewText = str_replace ( $arrayOfStringToDelete, "", $reviewText );
		return $newReviewText;
	}
	private static function addLineBreakTo($reviewText, $arrayOfStringToBreak) {
		$LINE_BREAK_TAG = "<br>";
		$NON_SENTENCE_CHARACTERS = ' 　' . implode ( $arrayOfStringToBreak ); // 例："「半角空白」「全角空白」●◆" //「●箇条書き」の本文でない文字たち

		$newReviewText = $reviewText;

		$count = count ( $arrayOfStringToBreak );
		for($i = 0; $i < $count; $i ++) {

			$stringToBreak = $arrayOfStringToBreak [$i]; // 例：●

			// 例：'/●([^ ●◆]+?)/u'
			// ●の後に、「半角空白」または「全角空白」または「●」または「◆」でない文字列。この文字列は、「●箇条書き」の本文のこと。
			// +? 最短一致 //UTF-8でpreg系を使う場合は、パターン修飾子として"u"を指定する。
			$pattern = '/' . $stringToBreak . '([^' . $NON_SENTENCE_CHARACTERS . ']+?)/u'; // var_dump($pattern);

			$replace = $LINE_BREAK_TAG . $stringToBreak . '\1'; // 例：<br>●\1 \1は本文。// var_dump($replace);
			$newReviewText = preg_replace ( $pattern, $replace, $newReviewText );
		}

		if (TextUtils::startsWith ( $newReviewText, $LINE_BREAK_TAG )) { // 先頭の<br>を取り除く。
			$startIndex = mb_strlen ( $LINE_BREAK_TAG, "UTF-8" );
			$newReviewText = mb_substr ( $newReviewText, $startIndex, NULL, "UTF-8" ); // var_dump($newReviewText);
		}

		// 例：'#<br>[\s ]*?<br>#u'
		// ここでは正規表現の区切り文字（デリミタ）を/の代わりに#を使った。以前スラッシュ文字がある<br />を使って処理していたから。
		$pattern = '#' . $LINE_BREAK_TAG . '[\s　]*?' . $LINE_BREAK_TAG . '#u'; // *? 最短一致 //var_dump($pattern);
		$newReviewText = preg_replace ( $pattern, $LINE_BREAK_TAG, $newReviewText ); // 例：<br>空白文字<br>を<br>に置換する。

		return $newReviewText;
	}
}
