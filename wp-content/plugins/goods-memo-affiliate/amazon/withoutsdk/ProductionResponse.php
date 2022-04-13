<?php

namespace goodsmemo\amazon\withoutsdk;

use goodsmemo\item\ProductionItem;
use goodsmemo\item\html\HTMLUtils;

require_once GOODS_MEMO_DIR . "item/ProductionItem.php";
require_once GOODS_MEMO_DIR . "item/html/HTMLUtils.php";

class ProductionResponse {
	// str_replace()用 検索文字列と置換文字列
	const MANUFACTURER_LABEL_SEARCH = array (
			"Manufacturer"
	);
	const MANUFACTURER_LABEL_REPLACE = array (
			"製造元"
	);

	public static function makeProductionItem($searchItem): ProductionItem {

		$productionItem = new ProductionItem ();

		if (isset ( $searchItem->ItemInfo )) {
			;
		} else {
			return $productionItem;
		}

		$itemInfo = $searchItem->ItemInfo;

		if (isset ( $itemInfo->Classifications ) and isset ( $itemInfo->Classifications->Binding ) and isset ( $itemInfo->Classifications->Binding->DisplayValue )) {

			$bindingValue = $itemInfo->Classifications->Binding->DisplayValue;
			$productionItem->setBinding ( HTMLUtils::makePlainText ( $bindingValue ) );
		}

		if (isset ( $itemInfo->ByLineInfo )) {

			$byLineInfo = $itemInfo->ByLineInfo;

			if (isset ( $byLineInfo->Contributors )) {

				$contributors = $byLineInfo->Contributors; // Contributor[]
				$contributorArray = array ();
				foreach ( $contributors as $contributor ) {

					if (isset ( $contributor ) and isset ( $contributor->Role ) and isset ( $contributor->Name )) {
						;
					} else {
						continue;
					}

					$role = HTMLUtils::makePlainText ( $contributor->Role );
					$name = HTMLUtils::makePlainText ( $contributor->Name );
					$contributorValue = $name . "(" . $role . ")";
					array_push ( $contributorArray, $contributorValue );

					if (strcmp ( $role, "著" ) == 0 and empty ( $productionItem->getManufacturerLabel () )) {
						$productionItem->setManufacturerLabel ( "出版社" );
					}
				}

				$productionItem->setContributorArray ( $contributorArray );
			}

			if (isset ( $byLineInfo->Manufacturer ) and isset ( $byLineInfo->Manufacturer->DisplayValue )) {

				$manufacturer = $byLineInfo->Manufacturer;
				if (isset ( $manufacturer->Label ) and empty ( $productionItem->getManufacturerLabel () )) {

					$manufacturerLabel = HTMLUtils::makePlainText ( $manufacturer->Label );
					$manufacturerLabel = str_replace ( ProductionResponse::MANUFACTURER_LABEL_SEARCH, ProductionResponse::MANUFACTURER_LABEL_REPLACE, $manufacturerLabel );
					$productionItem->setManufacturerLabel ( $manufacturerLabel );
				}

				$manufacturerValue = HTMLUtils::makePlainText ( $manufacturer->DisplayValue );
				$productionItem->setManufacturer ( $manufacturerValue );
			}
		}

		return $productionItem;
	}
}