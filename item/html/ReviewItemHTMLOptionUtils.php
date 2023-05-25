<?php

namespace goodsmemo\item\html;

use goodsmemo\text\TextUtils;
use goodsmemo\item\html\ReviewItemHTMLOption;

require_once GOODS_MEMO_DIR . "text/TextUtils.php";
require_once GOODS_MEMO_DIR . "item/html/ReviewItemHTMLOption.php";

class ReviewItemHTMLOptionUtils
{
    public static function makeReviewItemHTMLOption(
        $optionMap,
        $reviewLength,
        $editorialReviewLengthID,
        $stringToDeleteID,
        $stringToBreakID
    ): ReviewItemHTMLOption {

        $reviewItemHTMLOption = new ReviewItemHTMLOption();

        if ($reviewLength === "") { // ショートコードの属性が未指定なら。0と””を区別するには ===（厳密な比較） を使います。
            $reviewItemHTMLOption->setReviewLength($optionMap[$editorialReviewLengthID]);
        } else {
            $reviewItemHTMLOption->setReviewLength($reviewLength);
        }

        $stringToDeleteJSONArray = TextUtils::decodeJSONTextToArray(
            $optionMap[$stringToDeleteID]
        );
        $reviewItemHTMLOption->setStringToDeleteJSONArray($stringToDeleteJSONArray);

        $stringToBreakJSONObjectText = htmlspecialchars_decode($optionMap[$stringToBreakID]);
        $stringToBreakJSONArray = TextUtils::decodeJSONTextToArray($stringToBreakJSONObjectText);
        $reviewItemHTMLOption->setStringToBreakJSONArray($stringToBreakJSONArray);

        $SENTENCE_SYMBOLS = ReviewItemHTMLOptionUtils::makeSentenceSymbols($stringToBreakJSONArray);
        $reviewItemHTMLOption->setLatestSentenceSymbols($SENTENCE_SYMBOLS);

        return $reviewItemHTMLOption;
    }

    private static function makeSentenceSymbols($stringToBreakJSONArray)
    {
        // 例："●■◆★。"「●箇条書き」の記号文字たち、または句点
        $SENTENCE_SYMBOLS = "";

        $stringToBreakArray = array_keys($stringToBreakJSONArray);
        foreach ($stringToBreakArray as $stringToBreak) {
            $stringToBreakLength = mb_strlen($stringToBreak, "UTF-8");
            if ($stringToBreakLength == 1) {

                $SENTENCE_SYMBOLS .= $stringToBreak;
            }
        }

        return $SENTENCE_SYMBOLS;
    }
}
