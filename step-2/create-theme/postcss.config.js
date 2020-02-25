module.exports = {
  plugins: [
    require('autoprefixer')({
      grid: true,
      /* .browserslistrcに移動
      browsers: ['last 2 versions']
      */
      /*
      browsers: ['IE 11', 'last 2 versions']
      */
    })
  ],
};