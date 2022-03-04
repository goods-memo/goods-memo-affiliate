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
namespace goodsmemo\option\rakuten;

use goodsmemo\option\field\FieldInfo;
use goodsmemo\option\paragraph\ReviewParagraph;
use goodsmemo\option\rakuten\RakutenSettingSection;

require_once GOODS_MEMO_DIR . "option/field/FieldInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ReviewParagraph.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";

/**
 * Description of ReviewParagraphUtils
 *
 * @author Goods Memo
 */
class ReviewParagraphUtils {
	const EDITORIAL_REVIEW_LENGTH_ID = RakutenSettingSection::ID_PREFIX . "_editorial_review_length_id";
	const ARRAY_OF_STRING_TO_DELETE_ID = RakutenSettingSection::ID_PREFIX . "_array_of_string_to_delete_id";
	const ARRAY_OF_STRING_TO_BREAK_ID = RakutenSettingSection::ID_PREFIX . "_array_of_string_to_break_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$editorialReviewLengthFieldInfo = new FieldInfo ();
		$editorialReviewLengthFieldInfo->setFieldID ( ReviewParagraphUtils::EDITORIAL_REVIEW_LENGTH_ID );
		$editorialReviewLengthFieldInfo->setFieldLabel ( ReviewParagraph::DEFAULT_EDITORIAL_REVIEW_LENGTH_LABEL );
		$editorialReviewLengthFieldInfo->setDefaultFieldValue ( ReviewParagraph::DEFAULT_EDITORIAL_REVIEW_LENGTH_VALUE );
		$editorialReviewLengthFieldInfo->enableMoreThanZeroVerification ();
		array_push ( $fieldInfoArray, $editorialReviewLengthFieldInfo );

		$arrayOfStringToDeleteFieldInfo = new FieldInfo ();
		$arrayOfStringToDeleteFieldInfo->setFieldID ( ReviewParagraphUtils::ARRAY_OF_STRING_TO_DELETE_ID );
		$arrayOfStringToDeleteFieldInfo->setFieldLabel ( ReviewParagraph::DEFAULT_ARRAY_OF_STRING_TO_DELETE_LABEL );
		$arrayOfStringToDeleteFieldInfo->setDefaultFieldValue ( ReviewParagraph::DEFAULT_ARRAY_OF_STRING_TO_DELETE_VALUE );
		array_push ( $fieldInfoArray, $arrayOfStringToDeleteFieldInfo );

		$arrayOfStringToBreakFieldInfo = new FieldInfo ();
		$arrayOfStringToBreakFieldInfo->setFieldID ( ReviewParagraphUtils::ARRAY_OF_STRING_TO_BREAK_ID );
		$arrayOfStringToBreakFieldInfo->setFieldLabel ( ReviewParagraph::DEFAULT_ARRAY_OF_STRING_TO_BREAK_LABEL );
		$arrayOfStringToBreakFieldInfo->setDefaultFieldValue ( ReviewParagraph::DEFAULT_ARRAY_OF_STRING_TO_BREAK_VALUE );
		array_push ( $fieldInfoArray, $arrayOfStringToBreakFieldInfo );

		return $fieldInfoArray;
	}
}
