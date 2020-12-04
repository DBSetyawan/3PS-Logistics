const _0x29cb = ['show', 'position:absolute;right:10px;top:50%;transform:translate(0,-50%);padding:\x202px\x207px;font-size:12px;cursor:pointer;', 'removeClass', 'addClass', 'each', 'attr', 'hasClass', '#passeye-toggle-', 'type', 'keyup\x20paste', '<input/>', 'val', 'btn-outline-primary', '#passeye-', 'css', '<div/>', 'btn\x20btn-primary\x20btn-sm', 'input[type=\x27password\x27][data-eye]', 'text', 'passeye-toggle-'];
(function (_0x53c153, _0x29cb7a) {
    const _0x5c37d3 = function (_0x1ef137) {
        while (--_0x1ef137) {
            _0x53c153['push'](_0x53c153['shift']());
        }
    };
    _0x5c37d3(++_0x29cb7a);
}(_0x29cb, 0x1c4));
const _0x5c37 = function (_0x53c153, _0x29cb7a) {
    _0x53c153 = _0x53c153 - 0x0;
    let _0x5c37d3 = _0x29cb[_0x53c153];
    return _0x5c37d3;
};
$(function () {
    $(_0x5c37('0x5'))[_0x5c37('0xc')](function (_0x4eb4f5) {
        let _0x5d3963 = $(this);
        _0x5d3963['wrap']($('<div/>', {
            'style': 'position:relative'
        }));
        _0x5d3963[_0x5c37('0x2')]({
            'paddingRight': 0x3c
        });
        _0x5d3963['after']($(_0x5c37('0x3'), {
            'html': 'Show',
            'class': _0x5c37('0x4'),
            'id': _0x5c37('0x7') + _0x4eb4f5,
            'style': _0x5c37('0x9')
        }));
        _0x5d3963['after']($(_0x5c37('0x12'), {
            'type': 'hidden',
            'id': 'passeye-' + _0x4eb4f5
        }));
        _0x5d3963['on'](_0x5c37('0x11'), function () {
            $(_0x5c37('0x1') + _0x4eb4f5)[_0x5c37('0x13')]($(this)['val']());
        });
        $(_0x5c37('0xf') + _0x4eb4f5)['on']('click', function () {
            if (_0x5d3963[_0x5c37('0xe')](_0x5c37('0x8'))) {
                _0x5d3963['attr'](_0x5c37('0x10'), 'password');
                _0x5d3963[_0x5c37('0xa')](_0x5c37('0x8'));
                $(this)[_0x5c37('0xa')](_0x5c37('0x0'));
            } else {
                _0x5d3963[_0x5c37('0xd')](_0x5c37('0x10'), _0x5c37('0x6'));
                _0x5d3963[_0x5c37('0x13')]($('#passeye-' + _0x4eb4f5)[_0x5c37('0x13')]());
                _0x5d3963[_0x5c37('0xb')](_0x5c37('0x8'));
                $(this)[_0x5c37('0xb')]('btn-outline-primary');
            }
        });
    });
});