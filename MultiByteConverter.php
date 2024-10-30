<?php
/*
Copyright 2012 Kiri (email : wordreamz@gmail.com, twitter : @wordream)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*
 * Plugin Name: Multi-byte Converter
 * Plugin URI: http://wordpress.org/extend/plugins/multi-byte-converter/
 * Description: 全角英数字や全角スペースを半角に、記号をルールに沿って置換します。
 * Author: Kiri
 * Version: 1.0.2
 * Author URI: https://twitter.com/#!/wordream
 */

/**
 * 全角英数字、全角スペースを半角に置換する
 * @param unknown_type $contentData
 */
function filter_convert_size($contentData) {

	/*
	 * 全角英数字を半角に置換
	 * K 「半角」カナを「全角」カナに置換
	 * V  濁点つきの文字を1文字に置換
	 * a 「全角」英数字を「半角」英数字に置換
	 * s 「全角」スペースを「半角」スペースに置換
	 */
	$data = mb_convert_kana($contentData, 'KVas');

	return $data;
}

/**
 * 記号をルールに沿って置換
 * @param unknown_type $contentData
 */
function filter_convert_current($contentData) {

	//記号をルールに沿って置換
	/*
	 * 半角括弧を全角括弧に置換
	 * 全角ーを半角-に置換
	 * http:// wwwのスペース混入ミスを修正
	 * 機種依存文字を半角英数表記に修正
	 */
	$from = array('(', ')', '−', 'http:// www', '㎞', '㎜', '㎝');
 	$to = array('（', '）', '-', 'http://www', 'km', 'mm', 'cm');

	//置換
	$data = str_replace($from, $to, $contentData);

	return $data;
}


//タイトルにフィルターを適用
add_filter('the_title', 'filter_convert_size');
add_filter('the_title', 'filter_convert_current');

//記事本文にフィルターを適用
add_filter('the_content', 'filter_convert_size');
add_filter('the_content', 'filter_convert_current');

//カスタムフィールドにフィルターを適用
add_filter('the_meta_key', 'filter_convert_size');
add_filter('the_meta_key', 'filter_convert_current');

?>