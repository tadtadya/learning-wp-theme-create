# wordpress-db-import-bash
wordpressのDBデータをインポートファイルですべて書き換えるbashスクリプトです。
[English](https://github.com/tadtadya/db-import-bash-for-wp/blob/master/README.md)

## 要件
- [MySQL](https://www.mysql.com/jp/) or [MarriaDB](https://mariadb.org/)
- bashスクリプトが実行できる環境。
- [WordPress](https://ja.wordpress.org/) + [wp-cli](https://wp-cli.org/ja/)

## Overview
WordPressのDB内容を指定したインポートファイルですべて入れ替えます。処理は以下の手順で行います。

1. DBのバックアップ作成
1. 指定DBのすべてのテーブル削除
1. インポートファイルでDBのリストア
1. wp-cliを使ってDBデータのドメインを一括置換

## 準備
スクリプト内の設定内容を自分の環境に合わせて編集します。

| 変数 | 設定内容 |
|:---|:---|
| db_name | WordPressのデータベース名 |
| db_user | DBの接続ユーザー名 |
| db_pass | DBの接続パスワード |
| db_bkfile | DBのバックアップファイル名 デフォルト: wp_db_bkup_yyyymmdd_HHMMSS.sql |
| old_domain | 変更前ドメイン |
| new_domain | 変更後ドメイン |

### 注意点
- すべてbashの変数です。bashスクリプトの変数の使い方に合わせてください。
- 変数の値の正当性チェックを行いません。スクリプトを実行する前に、テストをするなどして十分に内容を確認してください。

## Usage

```bash
$ ./wp_db_renew.sh import.sql
```

### ドメインを変更しない時
ドメインの変更をしないときは最後の2行を変更します。

```vim
#eval ${cmd7} && eval ${cmd8} && eval ${cmd9} && \

#eval ${cmd10} && eval ${cmd11} && eval ${cmd12}

eval ${cmd7} && eval ${cmd8} && eval ${cmd9}
```
