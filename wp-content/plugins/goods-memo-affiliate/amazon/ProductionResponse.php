<?php

/*
 * Copyright (C) 2019 Goods Memo.
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

namespace goodsmemo\amazon;

use goodsmemo\item\ProductionItem;
use goodsmemo\item\html\HTMLUtils;

require_once GOODS_MEMO_DIR . "item/ProductionItem.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";
//PA-API v5  SDK
require_once(__DIR__ . '/sdk/vendor/autoload.php'); // change path as needed

/**
 * Description of ProductionResponse
 *
 * @author Goods Memo
 */
class ProductionResponse {

	//str_replace()用 検索文字列と置換文字列
	const MANUFACTURER_LABEL_SEARCH = array("Manufacturer");
	const MANUFACTURER_LABEL_REPLACE = array("製造元");

	public static function makeProductionItem(\Amazon\ProductAdvertisingAPI\v1\com\amazon\paapi5\v1\Item $searchItem): ProductionItem {

		$productionItem = new ProductionItem();

		if ($searchItem->getItemInfo() == NULL) {
			return $productionItem;
		}

		$itemInfo = $searchItem->getItemInfo();

		if ($itemInfo->getClassifications() != NULL
			and $itemInfo->getClassifications()->getBinding() != NULL
			and $itemInfo->getClassifications()->getBinding()->getDisplayValue() != NULL) {

			$bindingValue = $itemInfo->getClassifications()->getBinding()->getDisplayValue();
			$productionItem->setBinding(HTMLUtils::makePlainText($bindingValue));
		}

		if ($itemInfo->getByLineInfo() != NULL) {

			$byLineInfo = $itemInfo->getByLineInfo();

			if ($byLineInfo->getContributors() != NULL) {

				$contributors = $byLineInfo->getContributors(); //Contributor[]
				$contributorArray = array();
				foreach ($contributors as $contributor) {

					if ($contributor == NULL) {
						continue;
					}

					$role = HTMLUtils::makePlainText($contributor->getRole());
					$name = HTMLUtils::makePlainText($contributor->getName());
					$contributorValue = $name . "(" . $role . ")";
					array_push($contributorArray, $contributorValue);

					if (strcmp($role, "著") == 0 and empty($productionItem->getManufacturerLabel())) {
						$productionItem->setManufacturerLabel("出版社");
					}
				}

				$productionItem->setContributorArray($contributorArray);
			}

			if ($byLineInfo->getManufacturer() != NULL
				and $byLineInfo->getManufacturer()->getDisplayValue() != NULL) {

				$manufacturer = $byLineInfo->getManufacturer();   //var_dump($manufacturer);
				if ($manufacturer->getLabel() != NULL and empty($productionItem->getManufacturerLabel())) {

					$manufacturerLabel = HTMLUtils::makePlainText($manufacturer->getLabel());
					$manufacturerLabel = str_replace(ProductionResponse::MANUFACTURER_LABEL_SEARCH,
						ProductionResponse::MANUFACTURER_LABEL_REPLACE, $manufacturerLabel);
					$productionItem->setManufacturerLabel($manufacturerLabel);
				}

				$manufacturerValue = HTMLUtils::makePlainText($manufacturer->getDisplayValue());
				$productionItem->setManufacturer($manufacturerValue);
			}
		}

		return $productionItem;
	}

}
