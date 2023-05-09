<!-- 
ブログ記事の終わり
関連商品へ
移動するリンク
-->
<?php
$firstTag = gma_getFirstTag ();
$firstTagName = gma_getTagName ( $firstTag );
$theContent = get_the_content ();
$fitItemNumber = gma_getFitItemNumber ( $theContent );
?>

<?php

if (mb_strlen ( $firstTagName ) > 0 and $fitItemNumber > 0) :
	?>

<aside class="goods_memo_ad">
	
<div class="goods_memo_ad">
「 <span class="marker_pink">
<?php
	echo $firstTagName;
	?>
</span> 」の関連商品を、<a href="#goods_memo_ad_related_product">記事下でお知らせしています</a>。
</div>
	
</aside>
	
<?php endif;

?>