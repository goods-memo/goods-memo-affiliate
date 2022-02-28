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

namespace goodsmemo\rakuten;

use goodsmemo\item\ReviewItem;
use goodsmemo\item\html\HTMLUtils;

require_once GOODS_MEMO_DIR . "item/ReviewItem.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";

/**
 * Description of ReviewResponse
 *
 * @author Goods Memo
 */
class ReviewResponse {

    public static function makeReviewItem($node): ReviewItem {

	$reviewItem = new ReviewItem();

	$itemCaption = HTMLUtils::makePlainText($node->{'itemCaption'});
	$reviewItem->setPlainTextReview($itemCaption);

	$reviewLineArray = ReviewResponse::makeReviewLineArray($node, $itemCaption);
	$reviewItem->setReviewLineArray($reviewLineArray);

	return $reviewItem;
    }

    private static function makeReviewLineArray($node, $itemCaption) {

	$reviewLineArray = array();

	if (empty($node->{'catchcopy'}) || empty($itemCaption)) {
	    return $reviewLineArray;
	}

	$catchcopy = HTMLUtils::makePlainText($node->{'catchcopy'});
	array_push($reviewLineArray, $catchcopy);

	array_push($reviewLineArray, $itemCaption);

	return $reviewLineArray;
    }

}
