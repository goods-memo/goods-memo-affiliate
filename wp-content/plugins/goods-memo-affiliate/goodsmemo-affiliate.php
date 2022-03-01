<?php

/*
  Plugin Name: Goods Memo Affiliate
  Plugin URI:
  Description: アフィリエイトの商品を表示します。
  Version: 0.1.0
  Author:Goods Memo
  Author URI: https://www.goods-memo.net/goods-memo-affiliate/
  License: GPL v2 or later
 */

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


define("GOODS_MEMO_DIR", __DIR__ . "/");
define("GOODS_MEMO_PREFIX", "goodsmemo");

function goodsmemo_affiliate_uninstall() {
	// データベースからオプションを削除する
	delete_option("goodsmemo_option_name");
}

register_uninstall_hook(__FILE__, "goodsmemo_affiliate_uninstall");

function addGoodsMemoAffiliateStyles() {

	$styleSheetUniqueName = GOODS_MEMO_PREFIX . "-affiliateStyles";
	$pluginCssURL = plugins_url('gma-style.css', __FILE__);
	//var_dump($pluginCssURL);

	wp_register_style($styleSheetUniqueName, $pluginCssURL);
	wp_enqueue_style($styleSheetUniqueName);
}

if (is_admin()) {

	//ダッシュボードまたは管理画面を表示中
	require_once(GOODS_MEMO_DIR . "option/AffiliateSettingPage.php");
	$settingPage = new goodsmemo\option\AffiliateSettingPage();
} else {
	//テーマを使って表示中
	require_once(GOODS_MEMO_DIR . "shortcode/Shortcode.php");

	//テスト環境にて、ショートコードの属性の値が壊れていた場合があった。
	//例：keyword="ダイエット"が、$attsにて、keyword=「class="marker_pink">ダイエット</span></span>」という値になった。
	//add_shortcode(GOODS_MEMO_PREFIX . "_affiliate", "\goodsmemo\shortcode\Shortcode::makeAffiliateHTML");
	//
    //以下の書き方にしてみる。参考：http://wpdocs.osdn.jp/%E9%96%A2%E6%95%B0%E3%83%AA%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9/add_shortcode
	add_shortcode(GOODS_MEMO_PREFIX . "_affiliate", array('goodsmemo\shortcode\Shortcode', 'makeAffiliateHTML'));

	//ヘッダにCSSを追加する
	add_action('wp_enqueue_scripts', 'addGoodsMemoAffiliateStyles');
}

/*
 * デバッグの例：
 * var_dump($val);
 * print_r($val);
 */
?>