/***************************************************************************/
/*                                                                         */
/*  This obfuscated code was created by Javascript Obfuscator Free Version.*/
/*  Javascript Obfuscator Free Version can be downloaded here              */
/*  http://javascriptobfuscator.com                                        */
/*                                                                         */
/***************************************************************************/
var _$_5430=["value","","filled","add","classList","remove",".label","querySelectorAll","length","click","focus","previousElementSibling","addEventListener","load","input","getElementsByClassName","keyup","slow","fadeOut","delay","#att","POST","no-cache","same-origin","follow","no-referrer","stringify","content","attr","meta[name=\"csrf-token\"]","application/json","json","http://devyour-api.co.id/login","val","#email","#password","display","style","alert-success-auth-verified","getElementById","inline","#alert-success-auth-verified","reload","location","Login","text","#login","disabled","prop","alert-success-auth","#alert-success-auth","Verifying...","preventDefault"];var toggleInputContainer=function(_0xAF39){if(_0xAF39[_$_5430[0]]!= _$_5430[1]){_0xAF39[_$_5430[4]][_$_5430[3]](_$_5430[2])}else {_0xAF39[_$_5430[4]][_$_5430[5]](_$_5430[2])}};var labels=document[_$_5430[7]](_$_5430[6]);for(var i=0;i< labels[_$_5430[8]];i++){labels[i][_$_5430[12]](_$_5430[9],function(){this[_$_5430[11]][_$_5430[10]]()})};window[_$_5430[12]](_$_5430[13],function(){var _0xAF84=document[_$_5430[15]](_$_5430[14]);for(var i=0;i< _0xAF84[_$_5430[8]];i++){_0xAF84[i][_$_5430[12]](_$_5430[16],function(){toggleInputContainer(this)});toggleInputContainer(_0xAF84[i])}});$(_$_5430[20])[_$_5430[19]](10000)[_$_5430[18]](_$_5430[17]);async function Logged(_0xB0B0){const _0xB146= await fetch(_0xB0B0,{method:_$_5430[21],cache:_$_5430[22],credentials:_$_5430[23],redirect:_$_5430[24],referrer:_$_5430[25],body:JSON[_$_5430[26]](dataLogin),headers:{'X-CSRF-TOKEN':$(_$_5430[29])[_$_5430[28]](_$_5430[27]),'Content-Type':_$_5430[30]}});const _0xB0FB= await _0xB146[_$_5430[31]]();return _0xB0FB}async function logInUseRs(){try{const _0xB191=_$_5430[32];let _0xB308=$(_$_5430[34])[_$_5430[33]]();let _0xB353=$(_$_5430[35])[_$_5430[33]]();const _0xB2BD={email:_0xB308,password:_0xB353};const _0xB1DC={method:_$_5430[21],cache:_$_5430[22],credentials:_$_5430[23],redirect:_$_5430[24],referrer:_$_5430[25],body:JSON[_$_5430[26]](_0xB2BD),headers:{'X-CSRF-TOKEN':$(_$_5430[29])[_$_5430[28]](_$_5430[27]),'Content-Type':_$_5430[30]}};const _0xB39E= await fetch(`${_0xB191}`,_0xB1DC);const _0xB272= await _0xB39E[_$_5430[31]]();let _0xB3E9= new Promise((_0xB065,_0xB01A)=>{document[_$_5430[39]](_$_5430[38])[_$_5430[37]][_$_5430[36]]= _$_5430[40],$(_$_5430[41])[_$_5430[19]](6660)[_$_5430[18]](_$_5430[17]),setTimeout(()=>_0xB065(window[_$_5430[43]][_$_5430[42]](true)),7000);$(_$_5430[46])[_$_5430[45]](_$_5430[44])})}catch(error){$(_$_5430[46])[_$_5430[45]](_$_5430[44]);$(_$_5430[46])[_$_5430[48]](_$_5430[47],false);const _0xB227=document[_$_5430[39]](_$_5430[49])[_$_5430[37]][_$_5430[36]]= _$_5430[40];$(_$_5430[50])[_$_5430[19]](10000)[_$_5430[18]](_$_5430[17])}}$(function(){$(_$_5430[46])[_$_5430[9]](function(_0xAFCF){$(_$_5430[46])[_$_5430[45]](_$_5430[51]);$(_$_5430[46])[_$_5430[48]](_$_5430[47],true);_0xAFCF[_$_5430[52]]();return  new Promise((_0xB065,_0xB01A)=>{setTimeout(()=>_0xB065(logInUseRs()),3500)})})})