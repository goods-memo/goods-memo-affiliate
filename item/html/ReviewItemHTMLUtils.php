<?php

namespace goodsmemo\item\html;

use goodsmemo\item\ReviewItem;
use goodsmemo\item\html\ReviewItemHTMLOption;
use goodsmemo\text\TextUtils;

require_once GOODS_MEMO_DIR . "item/ReviewItem.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOption.php";
require_once GOODS_MEMO_DIR . "text/TextUtils.php";

class ReviewItemHTMLUtils
{

	// 「ちょうどいい」の単語で「fit」を選んだ。
	public static function makeFitReviewText(
		ReviewItem $reviewItem,
		ReviewItemHTMLOption $reviewItemHTMLOption
	) {

		$reviewLength = $reviewItemHTMLOption->getReviewLength();

		$reviewText;

		$reviewLineArray = $reviewItem->getReviewLineArray();
		if (count($reviewLineArray) > 0) {

			$reviewText = ReviewItemHTMLUtils::makeFitReviewLinesText(
				$reviewLineArray,
				$reviewLength
			);
		} else {

			$plainTextReview = $reviewItem->getPlainTextReview();
			// HTML終了タグがないので、文字列を途中で切断できる。平文なので、HTML文法エラーとならない。
			$reviewText = TextUtils::mb_strimwidth($plainTextReview, 0, $reviewLength, "…"); // $reviewLengthは、文字幅（見た目の長さ）を示す。
		}

		$stringToDeleteJSONArray = $reviewItemHTMLOption->getStringToDeleteJSONArray();
		$reviewText = str_replace($stringToDeleteJSONArray, "", $reviewText); // 表示したくない文字列を削除する。

		$stringToBreakJSONArray = $reviewItemHTMLOption->getStringToBreakJSONArray();
		// 文字列の前または後ろに、改行タグを追加する。
		$SENTENCE_SYMBOLS = $reviewItemHTMLOption->getLatestSentenceSymbols();
		$reviewText = ReviewItemHTMLUtils::makeReviewTextWithLineBreakAdded(
			$reviewText,
			$stringToBreakJSONArray,
			$SENTENCE_SYMBOLS
		);

		return $reviewText;
	}

	private static function makeFitReviewLinesText($reviewLineArray, $reviewLength)
	{

		$fitReviewLinesText = "";
		$BR_TAG = "<br>";

		$lineCount = count($reviewLineArray);
		$lastIndex = $lineCount - 1;

		for ($i = 0; $i < $lineCount; $i++) {

			$fitReviewLinesText .= $reviewLineArray[$i];

			// $BR_TAGを加えた長さで判定する。例：mb_strimwidthの数え間違い例：<br>…… が <br…… という風に切断されていた。
			$stringWidth = mb_strwidth($fitReviewLinesText . $BR_TAG, "UTF-8"); // 文字幅（見た目の長さ） //var_dump($stringWidth);
			if ($stringWidth >= $reviewLength) {

				$fitReviewLinesText = TextUtils::mb_strimwidth(
					$fitReviewLinesText,
					0,
					$reviewLength,
					"…"
				);
				break;
			}

			if ($i < $lastIndex) {
				$fitReviewLinesText .= $BR_TAG;
			}
		}

		return $fitReviewLinesText;
	}

	//レビュー文字列を改行を追加した状態で作成する。
	//＜付帯状況＞を表すwith。with＋名詞＋状況を表す語句で、「名詞が～の状態で」
	private static function makeReviewTextWithLineBreakAdded($reviewText, $stringToBreakJSONArray, $SENTENCE_SYMBOLS)
	{

		$LINE_BREAK_TAG = "<br>";

		$NON_SENTENCE_CHARACTERS_PATTERN;
		// $SENTENCE_SYMBOLSの例："●■◆★。"「●箇条書き」の記号文字たち、または句点
		if ($SENTENCE_SYMBOLS) {
			$NON_SENTENCE_CHARACTERS_PATTERN = '[^' . $SENTENCE_SYMBOLS . ']+?';
		} else {
			$NON_SENTENCE_CHARACTERS_PATTERN = '.*?';
		}

		$newReviewText = $reviewText;

		foreach ($stringToBreakJSONArray as $stringToBreak => $replaceText) {

			// 例：'/●([^●◆。]+?)/u'
			// 例：●●●の場合、●●<br>●と置き換える。
			// ●の後に、「●」または「◆」または「。」でない文字列。
			// この文字列は、「●箇条書き」の本文、または句点のこと。
			// +? 最短一致。UTF-8でpreg系を使う場合は、パターン修飾子として"u"を指定する。
			$pattern = '/' . $stringToBreak . '(' . $NON_SENTENCE_CHARACTERS_PATTERN . ')/u';

			$replace = $replaceText . '\1'; // 例：<br>●\1。\1は箇条書きの本文。
			$newReviewText = preg_replace($pattern, $replace, $newReviewText);
		}

		if (TextUtils::startsWith($newReviewText, $LINE_BREAK_TAG)) { // 先頭の<br>を取り除く。
			$startIndex = mb_strlen($LINE_BREAK_TAG, "UTF-8");
			$newReviewText = mb_substr($newReviewText, $startIndex, NULL, "UTF-8");
		}

		// 例：'#<br>[\s ]*?<br>#u'
		// ここでは正規表現の区切り文字（デリミタ）を/の代わりに#を使った。
		// 以前スラッシュ文字がある<br />を使って処理していたから。
		// *? 最短一致
		$pattern = '#' . $LINE_BREAK_TAG . '[\s　]*?' . $LINE_BREAK_TAG . '#u';
		// 例：<br>空白文字<br>を<br>に置換する。
		$newReviewText = preg_replace($pattern, $LINE_BREAK_TAG, $newReviewText);

		return $newReviewText;
	}
}
