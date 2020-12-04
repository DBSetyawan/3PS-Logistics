module.exports = {
	plugins: [
	  require('postcss-import'),
	  require('tailwindcss')('./resources/css/tailwind.js'),
	  require('postcss-nested'),
	  require('autoprefixer'),
	]
  }