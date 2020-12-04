var _$_4033 = ["value", "", "filled", "add", "classList", "remove", ".label", "querySelectorAll", "length", "click", "focus", "previousElementSibling", "addEventListener", "load", "input", "getElementsByClassName", "keyup", "slow", "fadeOut", "delay", "#att", "POST", "no-cache", "same-origin", "follow", "no-referrer", "stringify", "content", "attr", "meta[name=\"csrf-token\"]", "application/json", "json", "http://devyour-api.co.id/login", "val", "#email", "#password", "display", "style", "alert-success-auth-verified", "getElementById", "inline", "#alert-success-auth-verified", "reload", "location", "Masuk", "text", "#login", "disabled", "prop", "alert-success-auth", "#alert-success-auth", "Verifying...", "preventDefault", "Silahkan tunggu anda sedang dialihkan...", "#types", "href", "http://devyour-api.co.id/tracking/shipment"];
var toggleInputContainer = function (_0x3076) {
    if (_0x3076[_$_4033[0]] != _$_4033[1]) {
        _0x3076[_$_4033[4]][_$_4033[3]](_$_4033[2])
    } else {
        _0x3076[_$_4033[4]][_$_4033[5]](_$_4033[2])
    }
};
var labels = document[_$_4033[7]](_$_4033[6]);
for (var i = 0; i < labels[_$_4033[8]]; i++) {
    labels[i][_$_4033[12]](_$_4033[9], function () {
        this[_$_4033[11]][_$_4033[10]]()
    })
};
window[_$_4033[12]](_$_4033[13], function () {
    var _0x30BB = document[_$_4033[15]](_$_4033[14]);
    for (var i = 0; i < _0x30BB[_$_4033[8]]; i++) {
        _0x30BB[i][_$_4033[12]](_$_4033[16], function () {
            toggleInputContainer(this)
        });
        toggleInputContainer(_0x30BB[i])
    }
});
$(_$_4033[20])[_$_4033[19]](10000)[_$_4033[18]](_$_4033[17]);
async function Logged(_0x31CF) {
    const _0x3259 = await fetch(_0x31CF, {
        method: _$_4033[21],
        cache: _$_4033[22],
        credentials: _$_4033[23],
        redirect: _$_4033[24],
        referrer: _$_4033[25],
        body: JSON[_$_4033[26]](dataLogin),
        headers: {
            'X-CSRF-TOKEN': $(_$_4033[29])[_$_4033[28]](_$_4033[27]),
            'Content-Type': _$_4033[30]
        }
    });
    const _0x3214 = await _0x3259[_$_4033[31]]();
    return _0x3214
}
async function logInUseRs() {
    try {
        const _0x329E = _$_4033[32];
        let _0x33F7 = $(_$_4033[34])[_$_4033[33]]();
        let _0x343C = $(_$_4033[35])[_$_4033[33]]();
        const _0x33B2 = {
            email: _0x33F7,
            password: _0x343C
        };
        const _0x32E3 = {
            method: _$_4033[21],
            cache: _$_4033[22],
            credentials: _$_4033[23],
            redirect: _$_4033[24],
            referrer: _$_4033[25],
            body: JSON[_$_4033[26]](_0x33B2),
            headers: {
                'X-CSRF-TOKEN': $(_$_4033[29])[_$_4033[28]](_$_4033[27]),
                'Content-Type': _$_4033[30]
            }
        };
        const _0x3481 = await fetch(`${_0x329E}`, _0x32E3);
        const _0x336D = await _0x3481[_$_4033[31]]();
        let _0x34C6 = new Promise((_0x318A, _0x3145) => {
            document[_$_4033[39]](_$_4033[38])[_$_4033[37]][_$_4033[36]] = _$_4033[40], $(_$_4033[41])[_$_4033[19]](6660)[_$_4033[18]](_$_4033[17]), setTimeout(() => _0x318A(window[_$_4033[43]][_$_4033[42]](true)), 7000);
            $(_$_4033[46])[_$_4033[45]](_$_4033[44])
        })
    } catch (error) {
        $(_$_4033[46])[_$_4033[45]](_$_4033[44]);
        $(_$_4033[46])[_$_4033[48]](_$_4033[47], false);
        const _0x3328 = document[_$_4033[39]](_$_4033[49])[_$_4033[37]][_$_4033[36]] = _$_4033[40];
        $(_$_4033[50])[_$_4033[19]](10000)[_$_4033[18]](_$_4033[17])
    }
}
$(function () {
    $(_$_4033[46])[_$_4033[9]](function (_0x3100) {
        $(_$_4033[46])[_$_4033[45]](_$_4033[51]);
        $(_$_4033[46])[_$_4033[48]](_$_4033[47], true);
        _0x3100[_$_4033[52]]();
        return new Promise((_0x318A, _0x3145) => {
            setTimeout(() => _0x318A(logInUseRs()), 3500)
        })
    })
});
$(function () {
    $(_$_4033[54])[_$_4033[9]](function (_0x3100) {
        $(_$_4033[54])[_$_4033[45]](_$_4033[53]);
        _0x3100[_$_4033[52]]();
        return new Promise((_0x318A, _0x3145) => {
            setTimeout(() => _0x318A(window[_$_4033[43]][_$_4033[55]] = _$_4033[56]), 4000)
        })
    })
})