<?php
/*
 * 上の「php開始タグ」のコピーについて、
 * function.phpにすでにあるなら、コピーしないこと。
 */

/*
 * ワードプレスの記事編集画面を表示する際、PHP Code Snippetsプラグインが、
 * gma_getFirstTag() 関数の定義を2度呼び出した。
 * function_exists()で対応する。
 */

/* 一番目のタグオブジェクトを取得する */
if (! function_exists ( 'gma_getFirstTag' )) :

	function gma_getFirstTag() {

		$tagObject = NULL;

		$taxonomy = 'post_tag';
		$terms = get_the_terms ( get_the_ID (), $taxonomy );

		if (! empty ( $terms )) {
			if (! is_wp_error ( $terms )) {

				$termCount = count ( $terms );
				if ($termCount >= 1) {

					$tagObject = $terms [0];
				}
			}
		}

		return $tagObject;
	}

endif;

	/*
 * $firstTag = gma_getFirstTag();
 * print_r ($firstTag );
 */

	/* */
if (! function_exists ( 'gma_getTagName' )) :

	function gma_getTagName($tagObject) {

		$tagName = '';

		if (isset ( $tagObject )) {
			$tagName = $tagObject->name;
		}

		return $tagName;
	}
endif;

	/*
 * echo 'gma_getTagName()='.gma_getTagName($firstTag);
 */

	/* 商品個数を取得する */
if (! function_exists ( 'gma_getFitItemNumber' )) :

	function gma_getFitItemNumber($theContent) {

		// fit：ちょうど良い
		$fitItemNumber = - 1;

		$postContent = strip_tags ( $theContent ); // 本文からHTMLやPHPタグを除去
		$postContentLength = mb_strlen ( $postContent );
		if ($postContentLength >= 5000) { // 本文が5000文字以上
			$fitItemNumber = 2;
		} else if ($postContentLength >= 300) {
			$fitItemNumber = 1;
		} else {
			$fitItemNumber = 0;
		}

		return $fitItemNumber;
	}
endif;

	/*
 * echo 'gma_getFitItemNumber()='.gma_getFitItemNumber();
 */

	/* 「H2 【まとめ記事】へのリンク」の存在確認 */
if (! function_exists ( 'gma_existsH2LinkToSummaryArticle' )) :

	function gma_existsH2LinkToSummaryArticle($theContent) {

		// <h2：h2タグの開始を表します。
		// \s+：1つ以上の空白文字を表します。​
		// .*：0文字以上の任意の文字に一致します。​
		// パターンのデリミタの後の "i" は、大小文字を区別しない検索を示す。
		$pattern = '/<h2\s+.*id="LinkSummary".*>/i';

		if (preg_match ( $pattern, $theContent )) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

endif;
