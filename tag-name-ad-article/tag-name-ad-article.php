<?php
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
 * print_r ( gma_getFirstTag() );
 */

	/* */
if (! function_exists ( 'gma_getFirstTagName' )) :

	function gma_getFirstTagName() {

		$tagName = '';

		$tagObject = gma_getFirstTag ();

		if (isset ( $tagObject )) {
			$tagName = $tagObject->name;
		}

		return $tagName;
	}
endif;

	/*
 * echo 'gma_getFirstTagName()='.gma_getFirstTagName();
 */

	/* */
if (! function_exists ( 'gma_getFirstTagURL' )) :

	function gma_getFirstTagURL() {

		$tagURL = '';

		$tagObject = gma_getFirstTag ();

		if (isset ( $tagObject )) {
			$tagURL = esc_url ( get_term_link ( $tagObject ) );
		}

		return $tagURL;
	}
endif;

	/*
 * echo 'gma_getFirstTagURL()='.gma_getFirstTagURL();
 */

	/* */
if (! function_exists ( 'gma_createTagNameAdArticleURL' )) :

	function gma_createTagNameAdArticleURL() {

		// 例：http://localhost/wp_test/tag/beautiful-skin-water/
		$firstTagNameURL = gma_getFirstTagURL ();

		// 例：http://localhost/wp_test/advertisement/beautiful-skin-water/
		$adArticleURL = str_replace ( '/tag/', '/advertisement/', $firstTagNameURL );
		return $adArticleURL;
	}
endif;

	/*
 * echo 'gma_createTagNameAdArticleURL()='.gma_createTagNameAdArticleURL();
 */

	/* タグ名の広告記事の存在を確認する */
if (! function_exists ( 'gma_existsTagNameAdArticle' )) :

	function gma_existsTagNameAdArticle() {

		$tagNameAdArticleURL = gma_createTagNameAdArticleURL ();

		$headers = @get_headers ( $tagNameAdArticleURL );
		// ステータスコード 200番台、300番台について、調べる
		if (preg_match ( '/[2][0-9][0-9]|[3][0-9][0-9]/', $headers [0] )) {
			// タグ名の広告記事ページがあります;
			return TRUE;
		} else {
			// タグ名の広告記事ページがありませんでした
			return FALSE;
		}
	}

endif;

	/*
 * echo 'gma_existsTagNameAdArticle()='.gma_existsTagNameAdArticle();
 */

	/* 商品個数を取得する */
if (! function_exists ( 'gma_getFitItemNumber' )) :

	function gma_getFitItemNumber() {

		// fit：ちょうど良い
		$fitItemNumber = - 1;

		$postContent = strip_tags ( get_the_content () ); // 本文からHTMLやPHPタグを除去
		$postContentLength = mb_strlen ( $postContent );
		if ($postContentLength >= 3000) { // 本文が3000文字以上
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

