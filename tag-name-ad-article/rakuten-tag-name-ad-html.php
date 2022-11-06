<!-- 
タグ名の広告記事
楽天市場の関連商品
-->

<?php
$firstTagName = gma_getFirstTagName ();
$fitItemNumber = 3;
?>

<?php

if (mb_strlen ( $firstTagName ) > 0 and $fitItemNumber > 0) :
	?>
	
<h2>
楽天市場
「 <?php
	echo $firstTagName;
	?> 」の関連商品
</h2>

<?php
	$shortcodeText = '[goodsmemo_affiliate service="rakuten" keyword="' . $firstTagName . '" number="' . $fitItemNumber . '"]';

	echo apply_shortcodes ( $shortcodeText );
	?>

<?php endif;

?>
