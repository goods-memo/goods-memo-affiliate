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

namespace goodsmemo\option;

use goodsmemo\option\PageInfo;
use goodsmemo\option\AffiliateOptionUtils;
use goodsmemo\option\amazon\AmazonSettingSection;
use goodsmemo\option\rakuten\RakutenSettingSection;
use goodsmemo\exception\OptionException;

require_once GOODS_MEMO_DIR . "option/PageInfo.php";
require_once GOODS_MEMO_DIR . "option/AffiliateOptionUtils.php";
require_once GOODS_MEMO_DIR . "option/amazon/AmazonSettingSection.php";
require_once GOODS_MEMO_DIR . "option/rakuten/RakutenSettingSection.php";
require_once GOODS_MEMO_DIR . "exception/OptionException.php";

/**
 * Description of AffiliateSettingPage
 *
 * @author Goods Memo
 */
class AffiliateSettingPage {
    /*
     * 参照：設定ページの作成
     * https://wpdocs.osdn.jp/%E8%A8%AD%E5%AE%9A%E3%83%9A%E3%83%BC%E3%82%B8%E3%81%AE%E4%BD%9C%E6%88%90
     * 名前の付け方など、この解説を真似した。
     */

    const SETTING_MENU_SLUG = "goodsmemo-affiliate-setting";
    const OPTION_GROUP = "goodsmemo_option_group";
    const OPTION_NAME_OF_DATABASE = "goodsmemo_option_name"; //注意：goodsmemo-affiliate.phpにも記述した。

    private $sectionArray = array();

    /**
     * Start up
     */
    public function __construct() {

	// 管理画面でプラグインを削除した時に呼び出されるメソッドを登録（このメソッドはスタティックであること）
	//register_uninstall_hook(__FILE__, '\goodsmemo\option\AffiliateSettingPage::uninstall');//クラスのメソッドはエラーとなるらしい。

	$amazonSettingSelection = new AmazonSettingSection();
	array_push($this->sectionArray, $amazonSettingSelection);

	$rakutenSettingSelection = new RakutenSettingSection();
	array_push($this->sectionArray, $rakutenSettingSelection);

	add_action('admin_menu', array($this, 'add_plugin_page'));
	add_action('admin_init', array($this, 'init_page'));
    }

    /**
     * Add options page
     */
    public function add_plugin_page() {
	// This page will be under "Settings" 設定のサブメニューとしてメニューを追加する
	add_options_page(
		'アフィリエイトの設定', //メニューで選択したページのタイトルタグに表示されるテキスト
		'グッズメモ アフィリエイト', //メニューに使用されるテキスト
		'manage_options', //権限 ( 'manage_options' や 'administrator' など)
		AffiliateSettingPage::SETTING_MENU_SLUG, //スラッグ名
		array($this, 'output_affiliate_page')//The function to be called to output the content for this page.
	);
    }

    /**
     * Register and add settings
     */
    public function init_page() {
	register_setting(
		AffiliateSettingPage::OPTION_GROUP, // option group
		AffiliateSettingPage::OPTION_NAME_OF_DATABASE, // option name データベースに保存するオプションの名前
		array($this, 'sanitize') // オプションの値を無害化するコールバック関数。
	);

	$pageInfo = new PageInfo();
	$pageInfo->setSettingMenuSlug(AffiliateSettingPage::SETTING_MENU_SLUG);
	$pageInfo->setOptionGroup(AffiliateSettingPage::OPTION_GROUP);
	$pageInfo->setOptionNameOfDatabase(AffiliateSettingPage::OPTION_NAME_OF_DATABASE);

	foreach ($this->sectionArray as $section) {
	    $section->initSection($pageInfo);
	}
    }

    /**
     * Options page callback
     *
     * Notice: screen_icon の使用はバージョン 3.8.0 から<strong>非推奨</strong>になりました。代替は用意されておりません。 in /app/public/wp-includes/functions.php on line 3856
     * Set class property
     * Holds the values to be used in the fields callbacks
     */
    public function output_affiliate_page() {

	$this->addGoodsMemoOptionStyles();

	try {
	    $optionMap = AffiliateOptionUtils::getAffiliateOption();

	    foreach ($this->sectionArray as $section) {
		$section->setOptionMap($optionMap);
	    }
	} catch (OptionException $ex) {//最初に「アフィリエイトの設定」画面を表示した際、OptionExceptionが通知される。
	    //print $ex;
	}
	?>
	<div class="wrap">
	    <h2>アフィリエイトの設定</h2>
	    <form method="post" action="options.php">
		<?php
		// This prints out all hidden setting fields
		settings_fields(AffiliateSettingPage::OPTION_GROUP);
		do_settings_sections(AffiliateSettingPage::SETTING_MENU_SLUG); //引数：設定セクションを表示したいページのスラッグ。
		submit_button();
		?>
	    </form>
	</div>
	<?php
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $inputedValueMap Contains all settings fields as array keys
     */
    public function sanitize($inputedValueMap) {

	$sanitizedValueMap = array();

	foreach ($this->sectionArray as $section) {
	    $section->sanitizeSectionValue($inputedValueMap, $sanitizedValueMap);
	}

	return $sanitizedValueMap;
    }

    private function addGoodsMemoOptionStyles() {

	$pluginCssURL = plugins_url('gma-optionStyle.css', __FILE__);
	//var_dump($pluginCssURL);

	wp_enqueue_style(
		AffiliateSettingPage::SETTING_MENU_SLUG, //スラッグ名
		$pluginCssURL
	);
    }

    /*
      public static function uninstall() {
      // データベースからオプションを削除する
      delete_option(\goodsmemo\option\AffiliateSettingPage::OPTION_NAME_OF_DATABASE);
      }
     */
}
