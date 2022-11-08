<!-- 
ブログ記事下
タグ名の関連商品・リンク
-->

<?php
if (gma_existsTagNameAdArticle ()) :
	?>

<div class="tag_name_ad_article_link_block">
<a href="<?php

	$tagNameAdArticleURL = gma_createTagNameAdArticleURL ();
	echo $tagNameAdArticleURL?>" class="tag_name_ad_article_link">「<?php

	$firstTagName = gma_getFirstTagName ();
	echo $firstTagName;
	?>」の<br>関連商品はこちら</a>

</div>
<?php
	return;
	?>
<?php endif;

?>

<!-- 
ブログ記事下
タグ名の関連商品
-->
<?php
$firstTagName = gma_getFirstTagName ();
$fitItemNumber = gma_getFitItemNumber ();
?>

<?php

if (mb_strlen ( $firstTagName ) > 0 and $fitItemNumber > 0) :
	?>

<aside class="goods_memo_ad">

<h4>
【広告】「 <span class="marker_pink"><?php

	echo $firstTagName;
	?></span> 」の関連商品
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
	$shortcodeText = '[goodsmemo_affiliate service="rakuten" keyword="' . $firstTagName . '" number="' .
			$fitItemNumber . '"]';

	echo apply_shortcodes ( $shortcodeText );
	?>

</aside>

<?php endif;

?>