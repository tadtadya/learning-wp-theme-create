<?php

namespace Mine;

/**
 * オートローダクラス
 *
 * クラスのオートローダを管理するクラス
 *
 * ● クラスのオートローダについて
 *   クラスのインスタンスを生成する場合、クラスが定義されたphpファイルをrequireする
 *   必要がありません。
 *   いきなりnew ***() をコールすると自動的にクラスファイルがロードされます。
 *   (インタフェースもオートローディングします。)
 *
 * 仕様：
 *   仕様の基本はpsr0に準拠しますが、WordPress用に若干の変更を加えます。
 *
 * 注意点：
 *   1. ディレクトリ構成とnamespaceを小文字に変換した構成が一致しないと "Class undefined" が発生
 *      します。
 *
 *   2. ***_Interfaceはインタフェースとして認識するのでクラス名としては使用できません。
 *      仮に使用した場合は動作の保証はできません。
 *
 * 参考:http://php.net/manual/ja/language.oop5.autoload.php
 *
 * @author tadtadya <tadtad.ya@gmail.com>
 * @copyright ただ屋ぁのブログ All Rights Reserved
 */
if ( ! class_exists( 'Mine\Autoloader' ) ) {
	class Autoloader {
		private static $instance;

		/**
		 * コンストラクタ
		 *
		 * 本クラスのインスタンスは1つしか作成できません。（シングルトン）
		 * なので、new 演算子は使用できません。
		 * インスタンスの取得には、Autoloader::get_instance()を使用してください。
		 */
		protected function __construct() {
		}

		/**
		 * 本クラスのインスタンス取得
		 *
		 * @return Autoloader
		 */
		public static function get_instance() {
			if ( empty( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * ロード判定
		 *
		 * @param string $class_name
		 *            クラス名
		 * @return bool
		 */
		private function is_load( $class_name ) {
			if ( preg_match( '/_Interface$/', $class_name ) ) {
				if ( interface_exists( $class_name, false ) ) {
					return false;
				}
			} else {
				if ( class_exists( $class_name, false ) ) {
					return false;
				}
			}
			return true;
		}

		/**
		 * トップレベルのネームスペースを除外
		 *
		 * @param string $class_name
		 *            クラス名
		 * @return string
		 */
		private function exclude_top_nmsp( $class_name ) {
			if ( $pos = strpos( $class_name, '\\' ) ) {
				$class_name = substr_replace( $class_name, '', 0, $pos + 1 );
			}

			return $class_name;
		}

		/**
		 * クラス名を分解する
		 *
		 * クラス名をクラスとディレクトリ(ネームスペース)に分解する。
		 *
		 * @param string $class_name
		 *            クラス名
		 * @return array
		 */
		private function explode_class_name( $class_name ) {
			// class名からphpファイル名抽出
			$file_name = '';
			$namespace = '';

			if ( $pos = strrpos( $class_name, '\\' ) ) {
				// namespaceがある場合
				$file_name = substr( strrchr( $class_name, '\\' ), 1 );

				// class名からnamespace抽出
				$namespace = substr_replace( $class_name, '', $pos + 1 );

			} else {
				// namespaceがない場合
				$file_name = $class_name;

			}

			// namespaceからpsr0に従ってディレクトリ作成
			$dir_name = '';
			if ( ! empty( $namespace ) ) {
				$search = [ '\\', '_' ];
				$dir_name = str_replace( $search, '/', $namespace );

			}

			return [
				'file_name' => $file_name,
				'dir_name' => $dir_name,
			];
		}

		/**
		 * パスの整形
		 *
		 * @param string $path
		 *            パス
		 * @return string
		 */
		private function shape_path( $path ) {
			$result = $path;
			if ( ! preg_match( '/\/$/', $path ) ) {
				$result .= '/';
			}
			return $result;
		}

		/**
		 * phpファイルをrequireする
		 *
		 * @param string $file
		 *            phpファイル
		 */
		private function require_file( $file ) {
			if ( file_exists( $file ) ) {
				require_once $file;
			}
		}

		/**
		 * WordPress用
		 *
		 * 仕様：
		 *   WordPressに合わせるため若干psr0と異なります。
		 *     1. クラスのphpファイル名はWordPressの規約に準拠(class-***-***.php)
		 *     2. ディレクトリ名はネームスペースを小文字にしたもの。
		 *
		 * 注意点：
		 *   1. WordPressのphpコーディング規約に則ったクラス名、クラスが定義された
		 *      phpファイル名である必要があります。
		 *      規約に則っていない場合、オートロードを実行しないか、require_once()でエラーが
		 *      発生します。
		 *
		 *   2. インターフェースは、インタフェース名が***_Interfaceで、そのphpファイル名が
		 *      class-***-interface.phpに対応しています。それ以外の場合は動作の保証は
		 *      できません。
		 *
		 *   3. トップレベルのネームスペースに対応するディレクトリの有無が指定できます。
		 *      ( それ以外はディレクトリ構成とネームスペースは一致しないといけない。)
		 *
		 * 参考:http://php.net/manual/ja/language.oop5.autoload.php
		 *
		 * @param string $class_name
		 *            クラス名
		 * @param string $base_path
		 *            基本パス(ネームスペースを含まないディレクトリのパス)
		 * @param bool $top
		 *            トップレベルのネームスペースのディレクトリ有無
		 *            true : ディレクトリあり。デフォルト。
		 *            false: ディレクトリなし。
		 */
		public function wordpress( $class_name, $base_path, $top = true ) {
			if ( ! $this->is_load( $class_name ) ) {
				return;
			}

			// トップレベルのネームスペース除外
			if ( ! $top ) {
				$class_name = $this->exclude_top_nmsp( $class_name );
			}

			// クラスとネームスペース取得
			$tmp = $this->explode_class_name( $class_name );

			// WordPressのクラスファイルの命名規則に従ってphpファイル名作成
			$php_file = 'class-' . $tmp['file_name'] . '.php';
			$php_file = str_replace( '_', '-', mb_strtolower( $php_file ) );
			$php_dir = mb_strtolower( $tmp['dir_name'] );

			// phpのクラスファイルをロード
			$php_file = $this->shape_path( $base_path ) . $php_dir . $php_file;
			$this->require_file( $php_file );
		}
	}
}
