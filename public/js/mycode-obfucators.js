const fs = require('fs');

var JavaScriptObfuscator = require('javascript-obfuscator');
fs.readFile('./public/js/transport/transport-obfoc.js', 'UTF-8', function(err, data){
    if(err){
        throw err;
    }
    var obfuscationResult = JavaScriptObfuscator.obfuscate(data)
    fs.writeFile('./public/js/transport/3ps-transports.js', obfuscationResult.getObfuscatedCode(), function(err){
        if(err){
            return console.log(err)
        }
        console.log('file has been saved')
    });
});