! function (t) {
    var e = {};

    function n(o) {
        if (e[o]) return e[o].exports;
        var i = e[o] = {
            i: o,
            l: !1,
            exports: {}
        };
        return t[o].call(i.exports, i, i.exports, n), i.l = !0, i.exports
    }
    n.m = t, n.c = e, n.d = function (t, e, o) {
        n.o(t, e) || Object.defineProperty(t, e, {
            enumerable: !0,
            get: o
        })
    }, n.r = function (t) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(t, "__esModule", {
            value: !0
        })
    }, n.t = function (t, e) {
        if (1 & e && (t = n(t)), 8 & e) return t;
        if (4 & e && "object" == typeof t && t && t.__esModule) return t;
        var o = Object.create(null);
        if (n.r(o), Object.defineProperty(o, "default", {
                enumerable: !0,
                value: t
            }), 2 & e && "string" != typeof t)
            for (var i in t) n.d(o, i, function (e) {
                return t[e]
            }.bind(null, i));
        return o
    }, n.n = function (t) {
        var e = t && t.__esModule ? function () {
            return t.default
        } : function () {
            return t
        };
        return n.d(e, "a", e), e
    }, n.o = function (t, e) {
        return Object.prototype.hasOwnProperty.call(t, e)
    }, n.p = "/", n(n.s = 4)
}({
    4: function (t, e, n) {
        t.exports = n(5)
    },
    5: function (t, e) {
        var n = document.querySelector(".notify-alert, .smiley-alert, .connectify-alert"),
            o = document.querySelector(".drake-alert");
        n && (document.querySelector(".notify-alert button, .smiley-alert button, .connectify-alert button").addEventListener("click", (function (t) {
            t.stopPropagation(), t.preventDefault(), n.classList.remove(notify.animatedIn), setTimeout((function () {
                n.classList.add(notify.animatedOut)
            }), 200)
        })), setTimeout((function () {
            n.classList.remove(notify.animatedIn)
        }), 200), setTimeout((function () {
            n.classList.contains(notify.animatedOut) || n.classList.add(notify.animatedOut)
        }), notify.timeout));
        o && setTimeout((function () {
            o.classList.contains(notify.animatedOut) || o.classList.add(notify.animatedOut)
        }), notify.timeout)
    }
});