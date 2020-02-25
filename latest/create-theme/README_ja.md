# learning-wp-theme-create Step2

開発環境を準備して作業が開始できるところまでのソースコードです。

## ソースコードの環境

### 要件

ソースコードのダウンロードした環境にNode.jsが必要です。

### プロジェクト環境の展開

コードをダウンロード後、プロジェクトの環境構築を行います。

1回だけ実行します。

#### Node.jsにパッケージ追加

Node.jsの環境に、ファイル監視のnodemonとパッケージ管理コマンドyarnを追加します。

```bash
$ npm install nodemon -g
```

```bash
$ npm install yarn -g
```

#### プロジェクトにパッケージ追加

プロジェクトにNode.jsのローカルパッケージを追加します。


create-themeディレクトリ下のpackage.jsonファイルがあるディレクトリで作業してください。

インストールするローカルパッケージのリストが設定済みなので、個別インストールは不要。

( パッケージリストからまとめてインストールします。)

```bash
$ yarn install
```

( node_modulesディレクトリが作られる。)

## ツールの使い方

js, cssファイル生成はwebpackツールで行い、手動とファイル監視による自動生成の2通りがあります。

プロジェクトのルートディレクトリ( package.jsonがあるところ )で実行してください。

手動

```
$ yarn build
```

自動

```
$ yarn watch
```

自動では、src配下のファイルを編集・保存したり、ディレクトリ作成・削除など、変更を加えると自動的にwebpackがcss, jsファイルをdistへ出力します。

プロンプトは常時起動しているので、終了は Ctrl + C を使って下さい。

## ソースコードの構成

```
create-theme
  ├ dist
  |   └ themes
  |       └ mine
  |           | phpコードの置き場所。
  |           | webpackのcss,jsファイル出力先。
  |           | Webサーバーにアップロードする実行ファイル群。
  |           |
  |           ├ css
  |           |   sass(scss)から変換したcssファイル
  |           |
  |           ├ js
  |           |   整形済みjsファイル
  |           |
  |           ├ lib
  |           |   └ classes
  |           |       phpクラスファイル
  |           |
  |           ├ templates
  |           |   テンプレート(phpファイル)
  |           |
  |           ├ functions.php
  |           |
  |           ├ index.phpなどWordPressのphpファイル。
  |           |
  |           └ style.css
  └ src
      | 編集するjs, scssファイルの置き場所。
      |
      └ themes
          └ mine
              ├ js
              |   jsファイル
              |
              └ sass
                  scssファイル
```

## コードのリリース

Webサーバーにリリースするコードはdistディレクトリに出力されます。

```
create-theme
  └ dist
      └ themes
          └ mine
```

テーマディレクトリ(mine)をそのままWebサーバーのWordPressテーマの配置場所にアップロードしてください。

mineは任意です。ご自身のテーマ名をつけてください。

(あわせてsrc配下のテーマ名も変更。)

## ソースコードの編集

### cssの編集

cssはsass(scss)で作成しコンパイルします。直接cssファイルは編集しません。

webpackは、プレフィックスの付与・縮小を自動で行います。

### jsの編集

webpackがトランスパイル・縮小を行うので、NextJSで書くこともできます。

### 対応ブラウザについて

cssのプレフィックス付与、jsのトランスパイルの対応ブラウザ・バージョンはまとめて設定しているので個々の設定は不要です。

.browserslistrcに定義されています。

```
last 2 version
```

適宜、[.browserslistrc](./.browserslistrc)を編集してください。

### phpの編集

#### オブジェクト指向の採用

phpはオブジェクト指向（クラスファイル）で作成し、WordPressのファイル、テンプレートファイル以外はすべてクラスファイルです。

#### MVCモデルを目指す

WordPressでは採用されてませんが、phpクラスはMVCモデルの構成に近づけます。

( index.php, single.phpなどをviewと位置づける。)

#### クラスのオートロード

クラスのautoload機能を実装済みです。クラスファイルのrequireは必要ありません。

use演算子を使えば自動的にクラスファイルをロードします。

#### psr0とWordPressの規約

クラスやインタフェースの規約はpsr0に準拠します。しかし、WordPressの規約に合わせて若干の修正を行いました。

- クラスファイルのディレクトリ構成とnamespaceは一致しないといけない。ただし、ディレクトリはぜんぶ小文字。
- namespaceは必ず"MINE\\"からはじめる。
- クラスファイルはclass-\*\*\*.php, インタフェースファイルはclass-\*\*\*-interface.php
- インターフェース名は\*\*\*_Interface

ファイル命名規則はWordPress規約、それ以外はpsr0です。そして、オリジナルでディレクトリ名は全小文字にしました。

(namespaceの先頭はwpテーマ名の大文字です。mine -> MINE)

#### クラスファイルのサンプル

|||
|:---|:---|
| namespace | MINE\PUBLISH\CONTROLLER |
| class | Single |
| class | Single_Post |
| class | Single_HTTP |
| interface | Single_Interface |
| interface | Single_HTTP_Interface |

##### ファイル構成

```
create-theme
  └ dist/themes/mine/lib
      └ classes
          └ publish
              └ controller
                  ├ class-single.php
                  ├ class-single-post.php
                  ├ class-single-http.php
                  ├ class-single-interface.php
                  └ class-single-http-interface.php
```

namespaceのMINEはディレクトリ構成から外してます。

( MINEはclassesディレクトリに対応 )

##### Usage

```
create-theme
  └ dist/themes/mine/templates
      └ sample.php
```

```
use MINE\PUBLISH\CONTROLLER\Single;
new Single();
```

これで開発環境ができました。環境を自分で作りたいという人はこちらをどうぞ。

[ENVIRONMENT.md](./ENVIRONMENT.md)