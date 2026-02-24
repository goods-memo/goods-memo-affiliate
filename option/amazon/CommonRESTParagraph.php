<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\paragraph\AbstractParagraph;
use goodsmemo\option\paragraph\AbstractTextParagraph;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\field\TextField;

require_once GOODS_MEMO_DIR . "option/paragraph/AbstractParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/AbstractTextParagraph.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/field/TextField.php";

class CommonRESTParagraph extends AbstractParagraph
{

	use AbstractTextParagraph;

	public function initParagraph(PageInfo $pageInfo, SectionInfo $sectionInfo, $fieldInfoArray)
	{

		parent::setOptionGroup($pageInfo->getOptionGroup());
		parent::setSectionTitle($sectionInfo->getSectionTitle());
		parent::setFieldInfoArray($fieldInfoArray);

		$paaAccessKeyTextField = new TextField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[0]);
		parent::addField($pageInfo, $sectionInfo, $paaAccessKeyTextField);

		$paaSecretKeyTextField = new TextField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[1]);
		parent::addField($pageInfo, $sectionInfo, $paaSecretKeyTextField);

		$paaAssociateTagTextField = new TextField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[2]);
		parent::addField($pageInfo, $sectionInfo, $paaAssociateTagTextField);

		$paaRegionTextField = new TextField($pageInfo->getOptionNameOfDatabase(), $fieldInfoArray[3]);
		parent::addField($pageInfo, $sectionInfo, $paaRegionTextField);
	}

	public function sanitizeParagraphValue($inputedValueMap, &$sanitizedValueMap)
	{
		//sanitizedValueMap：変更するため、配列の参照渡しとする。

		$this->validateExistence($inputedValueMap);
		parent::sanitizeParagraphValue($inputedValueMap, $sanitizedValueMap);
	}
}
