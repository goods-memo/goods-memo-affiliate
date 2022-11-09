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

	/* */
if (! function_exists ( 'gma_getTagURL' )) :

	function gma_getTagURL($tagObject) {

		$tagURL = '';

		if (isset ( $tagObject )) {
			$tagURL = esc_url ( get_term_link ( $tagObject ) );
		}

		return $tagURL;
	}
endif;

	/*
 * echo 'gma_getTagURL()='.gma_getTagURL($firstTag);
 */

	/* */
if (! function_exists ( 'gma_createTagAdArticleURL' )) :

	function gma_createTagAdArticleURL($tagObject) {

		// 例：http://localhost/wp_test/tag/beautiful-skin-water/
		$tagURL = gma_getTagURL ( $tagObject );

		// 例：http://localhost/wp_test/advertisement/beautiful-skin-water/
		$adArticleURL = str_replace ( '/tag/', '/advertisement/', $tagURL );
		return $adArticleURL;
	}
endif;

	/*
 * $tagAdArticleURL=gma_createTagAdArticleURL($firstTag);
 * echo 'gma_createTagAdArticleURL()='.$tagAdArticleURL;
 */

	/* タグ名の広告記事の存在を確認する */
if (! function_exists ( 'gma_existsTagAdArticle' )) :

	function gma_existsTagAdArticle($tagAdArticleURL) {

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $tagAdArticleURL );
		curl_setopt ( $ch, CURLOPT_HEADER, true ); // HTTP レスポンスのヘッダの内容を取得する
		/* curl_exec()を実行時、返り値を文字列で返す。curl_exec() を実行すると、デフォルトではレスポンスを標準出力に出力する */
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_NOBODY, true ); // リクエストメソッドがHEADになります。レスポンスヘッダのみが返される
		$content = curl_exec ( $ch );

		if (curl_errno ( $ch )) {
			$httpCode = - 1;
		} else {
			// 取得した情報からHTTPステータスコードを取り出します。
			$httpCode = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		}
		echo '<!-- CURLINFO_HTTP_CODE=' . $httpCode . ' -->';

		curl_close ( $ch );

		if ($httpCode == 200) {
			// タグ名の広告記事ページがあります;
			return TRUE;
		} else {
			// タグ名の広告記事ページがありませんでした
			return FALSE;
		}
	}

endif;

	/*
 * echo 'gma_existsTagAdArticle()='.gma_existsTagAdArticle($tagAdArticleURL);
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

