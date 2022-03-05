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
namespace goodsmemo\option\amazon;

use goodsmemo\option\field\TextareaFieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextareaFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

/**
 * Description of RESTParagraphUtils
 *
 * @author Goods Memo
 */
class RESTParagraphUtils {
	const ITEM_SEARCH_OPERATION = "ItemSearch"; // TODO Choice部品
	const ALL_SEARCH_INDEX = "All"; // TODO Choice部品
	                                //
	const SEARCH_ITEMS_RESOURCES_ID = AmazonSettingSection::ID_PREFIX . "_search_items_resources_id";

	public static function makeFieldInfoArray() {

		$fieldInfoArray = array ();

		$searchItemsResourcesFieldInfo = new TextareaFieldInfo ();
		$searchItemsResourcesFieldInfo->setFieldID ( RESTParagraphUtils::SEARCH_ITEMS_RESOURCES_ID );
		$searchItemsResourcesFieldInfo->setFieldLabel ( "SearchItems の Resources Parameter（開発用：JSON配列。空の配列[]）" );
		// 参考：Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\SearchItemsResource;
		/*
		 * $searchItemsResources = [
		 * "Images.Primary.Large", //例：Image Large
		 * "Images.Primary.Medium", //例：Image Medium
		 * "Images.Primary.Small", //例：Image Small
		 * //
		 * "ItemInfo.ByLineInfo", //例：Contributors(Author)
		 * "ItemInfo.Classifications", //例：Binding
		 * "ItemInfo.Features", //例：Features
		 * "ItemInfo.ProductInfo", //例：IsAdultProduct
		 * "ItemInfo.Title", //例：Title
		 * //
		 * "Offers.Listings.MerchantInfo", //例：shop名
		 * "Offers.Listings.Price", //例：Price
		 * "Offers.Summaries.LowestPrice"//例：LowestPrice
		 * ];
		 */
		// JSON ではダブルクォーテーションのみ使える。
		$searchItemsResources = '[
			"Images.Primary.Large",
			"Images.Primary.Medium",
			"Images.Primary.Small",
			"ItemInfo.ByLineInfo",
			"ItemInfo.Classifications",
			"ItemInfo.Features",
			"ItemInfo.ProductInfo",
			"ItemInfo.Title",
			"Offers.Listings.MerchantInfo",
			"Offers.Listings.Price",
			"Offers.Summaries.LowestPrice"
		]';
		$searchItemsResourcesFieldInfo->setDefaultFieldValue ( $searchItemsResources );
		array_push ( $fieldInfoArray, $searchItemsResourcesFieldInfo );

		return $fieldInfoArray;
	}
}
