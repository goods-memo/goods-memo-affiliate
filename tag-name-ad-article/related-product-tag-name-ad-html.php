<?php
$theContent = get_the_content ();
$existsH2LinkToSummaryArticle = gma_existsH2LinkToSummaryArticle ( $theContent );
?>

<!-- 
「H2 【まとめ記事】へのリンク」が存在する場合、残す。
そうでない場合、削除する。
-->
<?php

if ($existsH2LinkToSummaryArticle) {
	?>
<!-- 
ブログ記事内
「H2 【まとめ記事】へのリンク」の上
タグ名の関連商品
-->
<?php
} else {
	return;
}
?>

<!-- 
「H2 【まとめ記事】へのリンク」が無い場合、残す。
そうでない場合、削除する。
-->
<?php

if ($existsH2LinkToSummaryArticle == FALSE) {
	?>
<!-- 
ブログ記事下
タグ名の関連商品
-->
<?php
} else {
	return;
}
?>

<?php
$firstTag = gma_getFirstTag ();
$firstTagName = gma_getTagName ( $firstTag );
$fitItemNumber = gma_getFitItemNumber ( $theContent );
?>

<?php

if (mb_strlen ( $firstTagName ) > 0 and $fitItemNumber > 0) :
	?>

<aside id="goods_memo_ad_related_product" class="goods_memo_ad">

<h4>
【広告】「 <span class="marker_pink">
<?php
	echo $firstTagName;
	?>
</span> 」の関連商品
</h4>

<p class="goods_memo_ad">
&bull; Amazon.co.jp
</p>

<?php
	$shortcodeText = '[goodsmemo_affiliate service="amazon" keyword="' . $firstTagName . '" number="' .
			$fitItemNumber . '"]';

	echo apply_shortcodes ( $shortcodeText );
	?>

<p class="goods_memo_ad">
&bull; 楽天市場
</p>

<?php
	$shortcodeText = '[goodsmemo_affiliate service="rakuten" keyword="' . $firstTagName .
			'" number="' . $fitItemNumber . '"]';

	echo apply_shortcodes ( $shortcodeText );
	?>

</aside>

<?php endif;

?>