const fs = require('fs');

const json_text = fs.readFileSync('cleanup.json', 'utf-8');
const entryKey = JSON.parse(json_text);

function deleteFile(file) {
  fs.unlink(file, (err) => {
    if (err) throw err;
    console.log('delete ' + file + ' ... OK');
  });
}

function isExistFile(file) {
  try {
    fs.statSync(file);
    return true
  } catch(err) {
    if(err.code === 'ENOENT') return false
  }
}

const outDir = './dist/';
for(let key in entryKey) {
  const js = outDir + key + '.js';
  const css = outDir + key+ '.css';
  if (isExistFile(js) && isExistFile(css)) {
    deleteFile(js);
  }
}

deleteFile('cleanup.json');