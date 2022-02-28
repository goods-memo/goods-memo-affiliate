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

namespace goodsmemo\option\rakuten;

use goodsmemo\option\AbstractSettingSection;
use goodsmemo\option\PageInfo;
use goodsmemo\option\SettingSection;
use goodsmemo\option\SectionInfo;
use goodsmemo\option\paragraph\URLParagraph;
use goodsmemo\option\paragraph\ItemHTMLParagraph;
use goodsmemo\option\paragraph\ReviewParagraph;
use goodsmemo\option\rakuten\URLParagraphUtils;
use goodsmemo\option\rakuten\CommonRESTParagraph;
use goodsmemo\option\rakuten\CommonRESTParagraphUtils;
use goodsmemo\option\rakuten\ItemHTMLParagraphUtils;
use goodsmemo\option\rakuten\ReviewParagraphUtils;

require_once GOODS_MEMO_DIR . "option/AbstractSettingSection.php";
require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/SettingSection.php";
require_once GOODS_MEMO_DIR . "option/SectionInfo.php";
require_once GOODS_MEMO_DIR . "option/paragraph/URLParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ItemHTMLParagraph.php";
require_once GOODS_MEMO_DIR . "option/paragraph/ReviewParagraph.php";
require_once GOODS_MEMO_DIR . "option/rakuten/URLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/CommonRESTParagraph.php";
require_once GOODS_MEMO_DIR . "option/rakuten/CommonRESTParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/ItemHTMLParagraphUtils.php";
require_once GOODS_MEMO_DIR . "option/rakuten/ReviewParagraphUtils.php";

/**
 * Description of RakutenSettingSection
 *
 * @author Goods Memo
 */
class RakutenSettingSection extends AbstractSettingSection {

	const ID_PREFIX = "rakuten";

	public function initSection(PageInfo $pageInfo) {

		$sectionInfo = new SectionInfo();
		$sectionInfo->setSectionID("rakuten_section_id");
		$sectionInfo->setSectionTitle("楽天の設定");

		add_settings_section(
			$sectionInfo->getSectionID(), // ID
			$sectionInfo->getSectionTitle(), // Title
			array($this, SettingSection::PRINT_SECTION_INFO_FUNCTION_NAME), // Callback
			$pageInfo->getSettingMenuSlug() //設定ページのslug。メニューのslugと同じもの。
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
	}

	public function printSectionInfo() {
		print '楽天アフィリエイトの設定を入力してください。未入力だった場合、初期値を表示します。';
	}

}
