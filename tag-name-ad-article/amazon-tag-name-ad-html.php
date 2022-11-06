<!-- 
タグ名の広告記事
アマゾンの関連商品
-->

<?php
$firstTagName = gma_getFirstTagName ();
$fitItemNumber = 3;
?>

<?php

if (mb_strlen ( $firstTagName ) > 0 and $fitItemNumber > 0) :
	?>
	
<h2>
Amazon.co.jp
「 <?php
	echo $firstTagName;
	?> 」の関連商品
</h2>

<?php
	$shortcodeText = '[goodsmemo_affiliate service="amazon" keyword="' . $firstTagName . '" number="' . $fitItemNumber . '"]';

	echo apply_shortcodes ( $shortcodeText );
	?>

<?php endif;

?>
