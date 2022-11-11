<!-- 
タグ名の関連商品
楽天市場の商品
-->

<?php
$firstTag = gma_getFirstTag ();
$firstTagName = gma_getTagName ( $firstTag );
$fitItemNumber = 3;
?>

<?php

if (mb_strlen ( $firstTagName ) > 0 and $fitItemNumber > 0) :
	?>
	
<h2>
楽天市場
「<?php
	echo $firstTagName;
	?>」の関連商品
</h2>

<?php
	$shortcodeText = '[goodsmemo_affiliate service="rakuten" keyword="' . $firstTagName . '" number="' .
			$fitItemNumber . '" item_title_length="100" item_review_length="600"]';

	echo apply_shortcodes ( $shortcodeText );
	?>

<?php endif;

?>
