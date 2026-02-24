<?php

namespace goodsmemo\option\amazon;

use goodsmemo\option\AbstractSettingSection;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SettingSection;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\paragraph\URLParagraph;
use goodsmemo\option\paragraph\ItemHTMLParagraph;
use goodsmemo\option\paragraph\ReviewParagraph;
use goodsmemo\option\amazon\URLParagraphUtils;
use goodsmemo\option\amazon\CommonRESTParagraph;
use goodsmemo\option\amazon\CommonRESTParagraphUtils;
use goodsmemo\option\amazon\ItemHTMLParagraphUtils;
use goodsmemo\option\amazon\ReviewParagraphUtils;
use goodsmemo\option\amazon\ProductTypeParagraph;
use goodsmemo\option\amazon\ProductTypeParagraphUtils;
use goodsmemo\option\amazon\RESTParagraph;
use goodsmemo\option\amazon\RESTParagraphUtils;
use goodsmemo\option\amazon\DisplayHTMLPAAPINotAvailableParagraph;
use goodsmemo\option\amazon\DisplayHTMLPAAPINotAvailableParagraphUtils;

require_once GOODS_MEMO_DIR . "option/AbstractSettingSection.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SettingSection.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/URLParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ItemHTMLParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ReviewParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/URLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/CommonRESTParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/CommonRESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ItemHTMLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ReviewParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/ProductTypeParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/ProductTypeParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/RESTParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/RESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/DisplayHTMLPAAPINotAvailableParagraph.php";
require_once GOODS_MEMO_DIR . "option/amazon/DisplayHTMLPAAPINotAvailableParagraphUtils.php";

class AmazonSettingSection extends AbstractSettingSection
{
	const ID_PREFIX = "amazon";

	public function initSection(PageInfo $pageInfo)
	{

		$sectionInfo = new SectionInfo();
		$sectionInfo->setSectionID("amazon_section_id");
		$sectionInfo->setSectionTitle("アマゾンの設定");

		add_settings_section(
			$sectionInfo->getSectionID(), // ID
			$sectionInfo->getSectionTitle(), // Title
			array(
				$this,
				SettingSection::PRINT_SECTION_INFO_FUNCTION_NAME
			), // Callback
			$pageInfo->getSettingPageSlug()
		);

		$urlParagraph = new URLParagraph();
		$urlFieldInfoArray = URLParagraphUtils::makeFieldInfoArray();
		$urlParagraph->initParagraph($pageInfo, $sectionInfo, $urlFieldInfoArray);
		parent::addParagraph($urlParagraph);

		$commonRESTParagraph = new CommonRESTParagraph();
		$commonRESTFieldInfoArray = CommonRESTParagraphUtils::makeFieldInfoArray();
		$commonRESTParagraph->initParagraph($pageInfo, $sectionInfo, $commonRESTFieldInfoArray);
		parent::addParagraph($commonRESTParagraph);

		$itemHTMLParagraph = new ItemHTMLParagraph();
		$itemHTMLFieldInfoArray = ItemHTMLParagraphUtils::makeFieldInfoArray();
		$itemHTMLParagraph->initParagraph($pageInfo, $sectionInfo, $itemHTMLFieldInfoArray);
		parent::addParagraph($itemHTMLParagraph);

		$reviewParagraph = new ReviewParagraph();
		$reviewFieldInfoArray = ReviewParagraphUtils::makeFieldInfoArray();
		$reviewParagraph->initParagraph($pageInfo, $sectionInfo, $reviewFieldInfoArray);
		parent::addParagraph($reviewParagraph);

		$productTypeParagraph = new ProductTypeParagraph();
		$productTypeFieldInfoArray = ProductTypeParagraphUtils::makeFieldInfoArray();
		$productTypeParagraph->initParagraph($pageInfo, $sectionInfo, $productTypeFieldInfoArray);
		parent::addParagraph($productTypeParagraph);

		$restParagraph = new RESTParagraph();
		$restFieldInfoArray = RESTParagraphUtils::makeFieldInfoArray();
		$restParagraph->initParagraph($pageInfo, $sectionInfo, $restFieldInfoArray);
		parent::addParagraph($restParagraph);

		$displayHTMLParagraph = new DisplayHTMLPAAPINotAvailableParagraph();
		$displayHTMLFieldInfoArray = DisplayHTMLPAAPINotAvailableParagraphUtils::makeFieldInfoArray();
		$displayHTMLParagraph->initParagraph($pageInfo, $sectionInfo, $displayHTMLFieldInfoArray);
		parent::addParagraph($displayHTMLParagraph);
	}

	public function printSectionInfo()
	{

		print 'アマゾンアフィリエイトの設定を入力してください。未入力で初期値がある場合、初期値を表示します。';
	}
}
