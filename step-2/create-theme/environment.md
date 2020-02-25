## Node.jsの環境

```bash
$ node -v
v13.9.0
```

```bash
$ npm --version
6.9.0
```

### パッケージの管理はyarnを使う。

[yarn][yarn]はnpmコマンドを改良して高速化したもの。

[yarn]:https://www.npmjs.com/package/yarn

```bash
$ npm install yarn -g
```

yarnコマンドはどこでも使えるのでグローバルインストール。

## Webpackの環境
### webpack

webpackパッケージをインストールします。

```bash
$ yarn add webpack webpack-cli --dev
```

| | |
|:---|:---|
| [webpack][webpack] | webpack本体 |
| [webpack-cli][webpack-cli] | webpackのコマンド群 |

[webpack]:https://www.npmjs.com/package/webpack
[webpack-cli]:https://www.npmjs.com/package/webpack-cli

### css

webpackで使うcssローダーをインストールします。

```bash
$ yarn add style-loader css-loader --dev
```

| | |
|:---|:---|
| [css-loader][css-loader] | webpackで使うcssローダー。<br>CSSをjsファイルにバンドルする。<br>( jsファイルにcssを挿入 ) |
| [style-loader][style-loader] | webpackで使うstyleローダー。<br>`<link>`タグにCSSを展開 |

[css-loader]:https://www.npmjs.com/package/css-loader
[style-loader]:https://www.npmjs.com/package/style-loader

### css拡張

webpackで使うcss拡張プラグイン、ローダーをインストールします。

```bash
$ yarn add mini-css-extract-plugin postcss-loader autoprefixer --dev
```

| | |
|:---|:---|
| [mini-css-extract-plugin][mini-css-extract-plugin] | CSSをjsファイルから外出ししてcssファイルに出力する。 |
| [postcss-loader][postcss-loader] | webpackで使うpostcssローダー。<br>CSSにプレフィックスを自動付与する機能がある。 |
| [autoprefixer][autoprefixer] | cssにプレフィックスを付与するプラグイン。<br>postcss-loaderで必要。 |

[mini-css-extract-plugin]:https://www.npmjs.com/package/mini-css-extract-plugin
[postcss-loader]:https://www.npmjs.com/package/postcss-loader
[autoprefixer]:https://www.npmjs.com/package/autoprefixer

### sass

webpackで使うsassローダーをインストールします。

```bash
$ yarn add sass-loader sass --dev
```

| | |
|:---|:---|
| [sass-loader][sass-loader] | webpackで使うsassローダー。<br>sassをcssに変換してcssローダーに渡す。 |
| [sass][sass] | Node.jsでdark sassを使うためのパッケージ。<br>sass-loaderで必要。 |

- sassは[node-sass][node-sass]でも可。
- node-sassはSaas, saasはDart Sassを使う。

[sass-loader]:https://www.npmjs.com/package/sass-loader
[sass]:https://www.npmjs.com/package/sass
[node-sass]:https://www.npmjs.com/package/node-sass

### JavaScript

jsをトランスパイルするbabelをインストールします。

- トランスパイル : JavaScriptを任意のバージョンに変更する。<br>( jsバージョンを気にせずに開発できる。)

```bash
$ yarn add babel-loader @babel/core @babel/preset-env --dev
```

| | |
|:---|:---|
| [@babel/core][@babel/core] | babel本体。 |
| [@babel/preset-env][@babel/preset-env] | babelのプリセット。<br>使いやすいように、あからじめ環境を作ってくれる。 |
| [babel-loader][babel-loader] | webpackで使うbabelのローダー。 |

[@babel/core]:https://www.npmjs.com/package/@babel/core
[@babel/preset-env]:https://www.npmjs.com/package/@babel/preset-env
[babel-loader]:https://www.npmjs.com/package/babel-loader

### その他

```bash
$ npm install nodemon -g
```

| | |
|:---|:---|
| [nodemon][nodemon] | ディレクトリを監視して変更があったらnodeモジュールを再起動。<br>js, css自動生成に使う。 |

[nodemon]:https://www.npmjs.com/package/nodemon

- nodemonはyarnでインストール出来ないのでnpmを使う。
- nodemonはどこでも使えるのでグローバルイントール。