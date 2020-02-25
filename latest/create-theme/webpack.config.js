const MODE = process.env.NODE_ENV;

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const fs = require('fs');
const path = require('path');

// ソースマップ利用有無(productionのときは利用しない)
const isSourceMap = (MODE === 'development');


function getFileList(dir, ext) {
  const filenames = fs.readdirSync(dir);
  let ans = new Array();
  for(let filename of filenames) {
    let filepath = './' + path.posix.join(dir, filename);

    const stats = fs.statSync(filepath);

    pattern = new RegExp( "\." + ext + "$" );
    if (stats.isFile() && filename.match(pattern)) {
      ans.push(filepath);
    } else if (stats.isDirectory()) {
      ans = ans.concat(getFileList(filepath, ext));
    }
  }
  return ans;
}

const srcDir = './src';

function createEntryKey() {
  let exclude = [
    "webpack.config.js$",
    "postcss.config.js",
    "cleanup.js$",
    "_[a-zA-Z_\-]*\.scss$",
  ];

  let entry = getFileList(srcDir, 'js');
  entry = entry.concat(getFileList(srcDir, 'scss'));

  entry = entry.filter(function(item) {
    let ans = true;
    exclude.forEach(function(val) {
      pattern = new RegExp( val );
      if ( item.match(pattern) ) {
        ans = false;
      }
    });
    return ans;
  });

  let ext = ["js", "scss"];
  let replace = [
    ["/sass/", "/css/"],
  ];

  let ret = {};
  for (let val of entry) {
    let key = val;
    key = val.substring((srcDir + '/').length);
    for(let exVal of ext) {
      let pattern = new RegExp( "\." + exVal + "$" );
      key = key.replace( pattern, "" );
    }
    for(let rep of replace) {
      key = key.replace( rep[0], rep[1] );
    }
    ret[key] = val;
  }
  return ret;
}
const entryKey = createEntryKey();
console.log("createEntryKey:\n", entryKey);

fs.writeFile("cleanup.json", JSON.stringify(entryKey), 'utf-8', (err) => {
  if (err) throw err;
  console.log('output cleanup.json OK.');
});

module.exports = {
  // モード値を production に設定すると最適化された状態で、
  // development に設定するとソースマップ有効でJSファイルが出力される
  mode: MODE,
  entry: entryKey,

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /(node_modules)/,
        use: [{
          loader: 'babel-loader',
        }],
      },
      {
        test: /\.scss$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader",
            options: {
              url: true, // CSS内のurl()メソッドを取り込む
              sourceMap: isSourceMap, // ソースマップの利用
              importLoaders: 2 // 0 => no loaders (default); 1 => postcss-loader; 2 => postcss-loader, sass-loader
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              sourceMap: isSourceMap,
            },
          },
          {
            loader: "sass-loader",
            options: {
              sourceMap: isSourceMap
            }
          }
        ]
      }
    ],
  },
  plugins: [
    new MiniCssExtractPlugin(),
  ],
};
