<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\field\TextFieldInfo;
use goodsmemo\option\amazon\AmazonSettingSection;

require_once GOODS_MEMO_DIR . "option/field/TextFieldInfo.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";

class CommonRESTParagraphUtils
{
	const PAA_ACCESS_KEY_ID = AmazonSettingSection::ID_PREFIX . "_paa_access_key_id";
	const PAA_SECRET_KEY_ID = AmazonSettingSection::ID_PREFIX . "_paa_secret_key_id";
	const PAA_ASSOCIATE_TAG_ID = AmazonSettingSection::ID_PREFIX . "_paa_associate_tag_id";
	const PAA_REGION_ID = AmazonSettingSection::ID_PREFIX . "_paa_region_id";

	public static function makeFieldInfoArray()
	{

		$fieldInfoArray = array();

		$paaAccessKeyFieldInfo = new TextFieldInfo();
		$paaAccessKeyFieldInfo->setFieldID(CommonRESTParagraphUtils::PAA_ACCESS_KEY_ID);
		$paaAccessKeyFieldInfo->setFieldLabel('Product Advertising API アクセスキー');
		$paaAccessKeyFieldInfo->setExistenceVerificationEnabled(false);
		array_push($fieldInfoArray, $paaAccessKeyFieldInfo);

		$paaSecretKeyFieldInfo = new TextFieldInfo();
		$paaSecretKeyFieldInfo->setFieldID(CommonRESTParagraphUtils::PAA_SECRET_KEY_ID);
		$paaSecretKeyFieldInfo->setFieldLabel('Product Advertising API シークレットキー');
		$paaSecretKeyFieldInfo->setExistenceVerificationEnabled(false);
		array_push($fieldInfoArray, $paaSecretKeyFieldInfo);

		$paaAssociateTagFieldInfo = new TextFieldInfo();
		$paaAssociateTagFieldInfo->setFieldID(CommonRESTParagraphUtils::PAA_ASSOCIATE_TAG_ID);
		$paaAssociateTagFieldInfo->setFieldLabel('Product Advertising API アソシエイトタグ');
		$paaAssociateTagFieldInfo->setExistenceVerificationEnabled(false);
		array_push($fieldInfoArray, $paaAssociateTagFieldInfo);

		$paaRegionFieldInfo = new TextFieldInfo();
		$paaRegionFieldInfo->setFieldID(CommonRESTParagraphUtils::PAA_REGION_ID);
		$paaRegionFieldInfo->setFieldLabel('Product Advertising API リージョン（例：Japanの場合 us-west-2）');
		$paaRegionFieldInfo->setDefaultFieldValue("us-west-2");
		array_push($fieldInfoArray, $paaRegionFieldInfo);

		return $fieldInfoArray;
	}
}
