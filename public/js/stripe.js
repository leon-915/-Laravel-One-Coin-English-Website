! function (e) {
    function t(r) {
        if (n[r]) return n[r].exports;
        var o = n[r] = {
            i: r,
            l: !1,
            exports: {}
        };
        return e[r].call(o.exports, o, o.exports, t), o.l = !0, o.exports
    }
    var n = {};
    t.m = e, t.c = n, t.d = function (e, n, r) {
        t.o(e, n) || Object.defineProperty(e, n, {
            configurable: !1,
            enumerable: !0,
            get: r
        })
    }, t.n = function (e) {
        var n = e && e.__esModule ? function () {
            return e.default
        } : function () {
            return e
        };
        return t.d(n, "a", n), n
    }, t.o = function (e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, t.p = "", t(t.s = 0)
}([function (e, t, n) {
    e.exports = n(1)
}, function (e, t, n) {
    "use strict";

    function r(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function o(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function i(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function a(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function s(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function c(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function u(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function l(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function p(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function f(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function d(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function h(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function _(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function m(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function y(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function v(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function b(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function g(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function w(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function E(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function k(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function S(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function O(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function P(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function A(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function T(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function I(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function j(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function C(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function R(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function M(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function N(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function q(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function L(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function D(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function x(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function F(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function B(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function U(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function z(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function H(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function Y(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function W(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function G(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function V(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function K(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function $(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function J(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function Q(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function Z(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function X(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function ee(e, t) {
        if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
        return !t || "object" != typeof t && "function" != typeof t ? e : t
    }

    function te(e, t) {
        if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
        e.prototype = Object.create(t && t.prototype, {
            constructor: {
                value: e,
                enumerable: !1,
                writable: !0,
                configurable: !0
            }
        }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
    }

    function ne(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function re(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function oe(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function ie(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function ae(e, t, n) {
        return t in e ? Object.defineProperty(e, t, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : e[t] = n, e
    }

    function se(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function ce(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function ue(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function le(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }

    function pe(e, t) {
        var n = {};
        for (var r in e) t.indexOf(r) >= 0 || Object.prototype.hasOwnProperty.call(e, r) && (n[r] = e[r]);
        return n
    }

    function fe(e, t) {
        if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
    }

    function de(e) {
        if (Array.isArray(e)) {
            for (var t = 0, n = Array(e.length); t < e.length; t++) n[t] = e[t];
            return n
        }
        return Array.from(e)
    }
    Object.defineProperty(t, "__esModule", {
        value: !0
    });
    var he, _e, me, ye, ve, be, ge = function (e) {
            function t(e) {
                r(this, t);
                var n = o(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this, e));
                return window.__stripeElementsController && window.__stripeElementsController.reportIntegrationError(e), n.name = "IntegrationError", Object.defineProperty(n, "message", {
                    value: n.message,
                    enumerable: !0
                }), n
            }
            return i(t, e), t
        }(Error),
        we = ge,
        Ee = function (e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : "absurd";
            throw new Error(t)
        },
        ke = n(2),
        Se = n.n(ke),
        Oe = window.Promise ? Promise : Se.a,
        Pe = Oe,
        Ae = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Te = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Ie = function (e, t) {
            for (var n = 0; n < e.length; n++)
                if (t(e[n])) return e[n]
        },
        je = function (e, t) {
            for (var n = 0; n < e.length; n++)
                if (t(e[n])) return n;
            return -1
        },
        Ce = function (e) {
            return e && "object" === (void 0 === e ? "undefined" : Te(e)) && (e.constructor === Array || e.constructor === Object)
        },
        Re = function (e) {
            return Ce(e) ? Array.isArray(e) ? e.slice(0, e.length) : Ae({}, e) : e
        },
        Me = function e(t) {
            return function () {
                for (var n = arguments.length, r = Array(n), o = 0; o < n; o++) r[o] = arguments[o];
                if (Array.isArray(r[0]) && t) return Re(r[0]);
                var i = Array.isArray(r[0]) ? [] : {};
                return r.forEach(function (n) {
                    n && Object.keys(n).forEach(function (r) {
                        var o = i[r],
                            a = n[r],
                            s = Ce(o) && !(t && Array.isArray(o));
                        "object" === (void 0 === a ? "undefined" : Te(a)) && s ? i[r] = e(t)(o, Re(a)) : void 0 !== a ? i[r] = Ce(a) ? e(t)(a) : Re(a) : void 0 !== o && (i[r] = o)
                    })
                }), i
            }
        },
        Ne = (Me(!1), Me(!0)),
        qe = function (e, t) {
            for (var n = {}, r = 0; r < t.length; r++) n[t[r]] = !0;
            for (var o = [], i = 0; i < e.length; i++) n[e[i]] && o.push(e[i]);
            return o
        },
        Le = function (e, t) {
            var n = 0,
                r = function r(o) {
                    for (var i = Date.now() + 50; n < e.length && Date.now() < i;) t(e[n]), n++;
                    n === e.length ? o() : setTimeout(function () {
                        return r(o)
                    })
                };
            return new Pe(function (e) {
                return r(e)
            })
        },
        De = ["aed", "afn", "all", "amd", "ang", "aoa", "ars", "aud", "awg", "azn", "bam", "bbd", "bdt", "bgn", "bhd", "bif", "bmd", "bnd", "bob", "brl", "bsd", "btn", "bwp", "byr", "bzd", "cad", "cdf", "chf", "clf", "clp", "cny", "cop", "crc", "cuc", "cup", "cve", "czk", "djf", "dkk", "dop", "dzd", "egp", "ern", "etb", "eur", "fjd", "fkp", "gbp", "gel", "ghs", "gip", "gmd", "gnf", "gtq", "gyd", "hkd", "hnl", "hrk", "htg", "huf", "idr", "ils", "inr", "iqd", "irr", "isk", "jmd", "jod", "jpy", "kes", "kgs", "khr", "kmf", "kpw", "krw", "kwd", "kyd", "kzt", "lak", "lbp", "lkr", "lrd", "lsl", "ltl", "lvl", "lyd", "mad", "mdl", "mga", "mkd", "mmk", "mnt", "mop", "mro", "mur", "mvr", "mwk", "mxn", "myr", "mzn", "nad", "ngn", "nio", "nok", "npr", "nzd", "omr", "pab", "pen", "pgk", "php", "pkr", "pln", "pyg", "qar", "ron", "rsd", "rub", "rwf", "sar", "sbd", "scr", "sdg", "sek", "sgd", "shp", "skk", "sll", "sos", "srd", "ssp", "std", "svc", "syp", "szl", "thb", "tjs", "tmt", "tnd", "top", "try", "ttd", "twd", "tzs", "uah", "ugx", "usd", "uyu", "uzs", "vef", "vnd", "vuv", "wst", "xaf", "xag", "xau", "xcd", "xdr", "xof", "xpf", "yer", "zar", "zmk", "zmw", "btc", "jep", "eek", "ghc", "mtl", "tmm", "yen", "zwd", "zwl", "zwn", "zwr"],
        xe = De,
        Fe = {
            AE: "AE",
            AT: "AT",
            AU: "AU",
            BE: "BE",
            BR: "BR",
            CA: "CA",
            CH: "CH",
            DE: "DE",
            DK: "DK",
            EE: "EE",
            ES: "ES",
            FI: "FI",
            FR: "FR",
            GB: "GB",
            GR: "GR",
            HK: "HK",
            IE: "IE",
            IN: "IN",
            IT: "IT",
            JP: "JP",
            LT: "LT",
            LU: "LU",
            LV: "LV",
            MX: "MX",
            MY: "MY",
            NL: "NL",
            NO: "NO",
            NZ: "NZ",
            PH: "PH",
            PL: "PL",
            PT: "PT",
            RO: "RO",
            SE: "SE",
            SG: "SG",
            SI: "SI",
            SK: "SK",
            US: "US"
        },
        Be = Object.keys(Fe),
        Ue = {
            live: "live",
            test: "test",
            unknown: "unknown"
        },
        ze = function (e) {
            return /^pk_test_/.test(e) ? Ue.test : /^pk_live_/.test(e) ? Ue.live : Ue.unknown
        },
        He = function (e) {
            if (e === Ue.unknown) throw new we("It looks like you're using an older Stripe key. In order to use this API, you'll need to use a modern API key, which is prefixed with 'pk_live_' or 'pk_test_'.\n    You can roll your publishable key here: https://dashboard.stripe.com/account/apikeys")
        },
        Ye = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        We = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Ge = function (e, t, n) {
            return "Invalid value for " + n.label + ": " + (n.path.join(".") || "value") + " should be " + e + ". You specified: " + t + "."
        },
        Ve = function (e) {
            return {
                type: "valid",
                value: e,
                warnings: arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : []
            }
        },
        Ke = function (e) {
            return {
                error: e,
                errorType: "full",
                type: "error"
            }
        },
        $e = function (e, t, n) {
            var r = new we(Ge(e, t, n));
            return Ke(r)
        },
        Je = function (e, t, n) {
            return {
                expected: e,
                actual: String(t),
                options: n,
                errorType: "mismatch",
                type: "error"
            }
        },
        Qe = function (e) {
            return function (t, n) {
                return void 0 === t ? Ve(t) : e(t, n)
            }
        },
        Ze = function (e, t) {
            return function (n, r) {
                var o = function (e) {
                        var t = e.options.path.join(".") || "value";
                        return {
                            error: t + " should be " + e.expected,
                            actual: t + " as " + e.actual
                        }
                    },
                    i = function (e, t, n) {
                        return Ke(new we("Invalid value for " + e + ": " + t + ". You specified " + n + "."))
                    },
                    a = e(n, r),
                    s = t(n, r);
                if ("error" === a.type && "error" === s.type) {
                    if ("mismatch" === a.errorType && "mismatch" === s.errorType) {
                        var c = o(a),
                            u = c.error,
                            l = c.actual,
                            p = o(s),
                            f = p.error,
                            d = p.actual;
                        return i(r.label, u === f ? u : u + " or " + f, l === d ? l : l + " and " + d)
                    }
                    if ("mismatch" === a.errorType) {
                        var h = o(a),
                            _ = h.error,
                            m = h.actual;
                        return i(r.label, _, m)
                    }
                    if ("mismatch" === s.errorType) {
                        var y = o(s),
                            v = y.error,
                            b = y.actual;
                        return i(r.label, v, b)
                    }
                    return Ke(a.error)
                }
                return "valid" === a.type ? a : s
            }
        },
        Xe = function (e, t) {
            return function (n, r) {
                var o = Ie(e, function (e) {
                    return e === n
                });
                if (void 0 === o) {
                    var i = t ? "a recognized string." : "one of the following strings: " + e.join(", ");
                    return Je(i, n, r)
                }
                return Ve(o)
            }
        },
        et = function (e) {
            return function (t, n) {
                return "string" == typeof t && 0 === t.indexOf(e) ? Ve(t) : Je("a string starting with " + e, t, n)
            }
        },
        tt = function () {
            for (var e = arguments.length, t = Array(e), n = 0; n < e; n++) t[n] = arguments[n];
            return Xe(t, !1)
        },
        nt = function () {
            for (var e = arguments.length, t = Array(e), n = 0; n < e; n++) t[n] = arguments[n];
            return Xe(t, !0)
        },
        rt = tt.apply(void 0, s(Be)),
        ot = tt.apply(void 0, s(xe)),
        it = (tt.apply(void 0, s(Object.keys(Ue))), function (e, t) {
            return "string" == typeof e ? Ve(e) : Je("a string", e, t)
        }),
        at = function (e, t) {
            return function (n, r) {
                return void 0 === n ? Ve(t()) : e(n, r)
            }
        },
        st = function (e, t) {
            return "boolean" == typeof e ? Ve(e) : Je("a boolean", e, t)
        },
        ct = function (e, t) {
            return "number" == typeof e ? Ve(e) : Je("a number", e, t)
        },
        ut = function (e) {
            return function (t, n) {
                return "number" == typeof t && t > e ? Ve(t) : Je("a number greater than " + e, t, n)
            }
        },
        lt = function (e) {
            return function (t, n) {
                return "number" == typeof t && t === parseInt(t, 10) && (!e || t >= 0) ? Ve(t) : Je(e ? "a positive amount in the currency's subunit" : "an amount in the currency's subunit", t, n)
            }
        },
        pt = function (e, t) {
            return lt(!1)(e, t)
        },
        ft = function (e, t) {
            return lt(!0)(e, t)
        },
        dt = function (e, t) {
            return e && "object" === (void 0 === e ? "undefined" : We(e)) ? Ve(e) : Je("an object", e, t)
        },
        ht = function (e) {
            return function (t, n) {
                if (Array.isArray(t)) {
                    return t.map(function (t, r) {
                        return e(t, Ye({}, n, {
                            path: [].concat(s(n.path), [String(r)])
                        }))
                    }).reduce(function (e, t) {
                        return "error" === e.type ? e : "error" === t.type ? t : Ve([].concat(s(e.value), [t.value]), [].concat(s(e.warnings), s(t.warnings)))
                    }, Ve([]))
                }
                return Je("array", t, n)
            }
        },
        _t = function (e) {
            return function (t) {
                return function (n, r) {
                    if (Array.isArray(n)) {
                        var o = t(n, r);
                        if ("valid" === o.type)
                            for (var i = {}, a = 0; a < o.value.length; a += 1) {
                                var s = o.value[a];
                                if ("object" === (void 0 === s ? "undefined" : We(s)) && s && "string" == typeof s[e]) {
                                    var c = s[e];
                                    if (i[c]) return Ke(new we("Duplicate value for " + e + ": " + c + ". The property '" + e + "' of '" + r.path.join(".") + "' has to be unique."));
                                    i[c] = !0
                                }
                            }
                        return o
                    }
                    return Je("array", n, r)
                }
            }
        },
        mt = function (e) {
            return function (t, n) {
                return void 0 === t ? Ve(void 0) : Je("used in " + e + " instead", t, n)
            }
        },
        yt = function (e) {
            return function (t) {
                return function (n, r) {
                    if (n && "object" === (void 0 === n ? "undefined" : We(n)) && !Array.isArray(n)) {
                        var o = n,
                            i = Ie(Object.keys(o), function (e) {
                                return !t[e]
                            });
                        if (i && e) return Ke(new we("Invalid " + r.label + " parameter: " + [].concat(s(r.path), [i]).join(".") + " is not an accepted parameter."));
                        var c = Ve({});
                        return i && (c = Object.keys(o).reduce(function (e, n) {
                            return t[n] ? e : Ve(e.value, [].concat(s(e.warnings), ["Unrecognized " + r.label + " parameter: " + [].concat(s(r.path), [n]).join(".") + " is not a recognized parameter. This may cause issues with your integration in the future."]))
                        }, c)), Object.keys(t).reduce(function (e, n) {
                            if ("error" === e.type) return e;
                            var i = t[n],
                                c = i(o[n], Ye({}, r, {
                                    path: [].concat(s(r.path), [n])
                                }));
                            return "valid" === c.type && void 0 !== c.value ? Ve(Ye({}, e.value, a({}, n, c.value)), [].concat(s(e.warnings), s(c.warnings))) : "valid" === c.type ? Ve(e.value, [].concat(s(e.warnings), s(c.warnings))) : c
                        }, c)
                    }
                    return Je("an object", n, r)
                }
            }
        },
        vt = yt(!0),
        bt = yt(!1),
        gt = function (e, t, n, r) {
            var o = r || {},
                i = e(t, {
                    origin: o.origin || "",
                    element: o.element || "",
                    label: n,
                    path: []
                });
            return "valid" === i.type ? i : "full" === i.errorType ? i : {
                type: "error",
                errorType: "full",
                error: new we(Ge(i.expected, i.actual, i.options))
            }
        },
        wt = function (e, t, n, r) {
            var o = gt(e, t, n, r);
            switch (o.type) {
                case "valid":
                    return {
                        value: o.value, warnings: o.warnings
                    };
                case "error":
                    throw o.error;
                default:
                    return Ee(o)
            }
        },
        Et = /^(http(s)?):\/\//,
        kt = function (e) {
            return Et.test(e)
        },
        St = function (e) {
            if (!kt(e)) return null;
            var t = document.createElement("a");
            t.href = e;
            var n = t.protocol,
                r = t.host,
                o = /:80$/,
                i = /:443$/;
            return "http:" === n && o.test(r) ? r = r.replace(o, "") : "https:" === n && i.test(r) && (r = r.replace(i, "")), {
                host: r,
                protocol: n,
                origin: n + "//" + r
            }
        },
        Ot = function (e) {
            var t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : null,
                n = St(e);
            return !!n && n.host !== (t || window.location.host)
        },
        Pt = function (e, t) {
            if ("/" === t[0]) {
                var n = St(e);
                return n ? "" + n.origin + t : t
            }
            return "" + e.replace(/\/[^\/]*$/, "/") + t
        },
        At = {
            CARD_ELEMENT: "CARD_ELEMENT",
            CONTROLLER: "CONTROLLER",
            METRICS_CONTROLLER: "METRICS_CONTROLLER",
            PAYMENT_REQUEST_ELEMENT: "PAYMENT_REQUEST_ELEMENT",
            PAYMENT_REQUEST_BROWSER: "PAYMENT_REQUEST_BROWSER",
            PAYMENT_REQUEST_GOOGLE_PAY: "PAYMENT_REQUEST_GOOGLE_PAY",
            IBAN_ELEMENT: "IBAN_ELEMENT",
            IDEAL_BANK_ELEMENT: "IDEAL_BANK_ELEMENT",
            AUTHORIZE_WITH_URL: "AUTHORIZE_WITH_URL",
            CARDINAL_3DS2: "CARDINAL_3DS2",
            STRIPE_3DS2: "STRIPE_3DS2"
        },
        Tt = At,
        It = function (e) {
            return "https://js.stripe.com/v3/" + (e || "")
        },
        jt = function (e) {
            switch (e) {
                case "CARD_ELEMENT":
                    return It("elements-inner-card-ecbc4b77ce21340a57efd2bffeb92ffc.html");
                case "CONTROLLER":
                    return It("controller-f8c77612f7b1b0bc0ad59207aa8ee36e.html");
                case "METRICS_CONTROLLER":
                    return "https://js.stripe.com/v2/m/outer.html";
                case "PAYMENT_REQUEST_ELEMENT":
                    return It("elements-inner-payment-request-b0a40f54b998607585c53feb14fefb68.html");
                case "PAYMENT_REQUEST_BROWSER":
                    return It("payment-request-inner-browser-736d4f152656480b5b497ab32f82866c.html");
                case "PAYMENT_REQUEST_GOOGLE_PAY":
                    return It("payment-request-inner-google-pay-141237f4d73b87f233c81249b39b0fed.html");
                case "IBAN_ELEMENT":
                    return It("elements-inner-iban-93b803f9796639d177b20a97d37d35fd.html");
                case "IDEAL_BANK_ELEMENT":
                    return It("elements-inner-ideal-bank-c91e7f4f0be20f2a4ff2de2ce6007cbc.html");
                case "AUTHORIZE_WITH_URL":
                    return It("authorize-with-url-inner-8d37c9a0c7b4e725f07462b0a737d508.html");
                case "CARDINAL_3DS2":
                    return It("cardinal-inner-bbc94b3983539d89f968dc15fc147a37.html");
                case "STRIPE_3DS2":
                    return It("three-ds-2-inner-5f1b0c5e2436f31b8a100b045f28ccdd.html");
                default:
                    return Ee(e)
            }
        },
        Ct = jt,
        Rt = {
            card: "card",
            cardNumber: "cardNumber",
            cardExpiry: "cardExpiry",
            cardCvc: "cardCvc",
            postalCode: "postalCode",
            iban: "iban",
            idealBank: "idealBank",
            paymentRequestButton: "paymentRequestButton",
            auBankAccount: "auBankAccount",
            idealBankSecondary: "idealBankSecondary",
            auBankAccountNumber: "auBankAccountNumber",
            auBsb: "auBsb"
        },
        Mt = Rt,
        Nt = {
            PAYMENT_INTENT: "PAYMENT_INTENT",
            SETUP_INTENT: "SETUP_INTENT"
        },
        qt = Nt,
        Lt = [Mt.card, Mt.cardNumber, Mt.cardExpiry, Mt.cardCvc, Mt.postalCode],
        Dt = Lt,
        xt = St("https://js.stripe.com/v3/"),
        Ft = xt ? xt.origin : "",
        Bt = {
            family: "font-family",
            src: "src",
            unicodeRange: "unicode-range",
            style: "font-style",
            variant: "font-variant",
            stretch: "font-stretch",
            weight: "font-weight",
            display: "font-display"
        },
        Ut = Object.keys(Bt).reduce(function (e, t) {
            return e[Bt[t]] = t, e
        }, {}),
        zt = [Mt.idealBank, Mt.idealBankSecondary],
        Ht = 0,
        Yt = function (e) {
            return "" + e + Ht++
        },
        Wt = function e() {
            var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "";
            return t ? (parseInt(t, 10) ^ 16 * Math.random() >> parseInt(t, 10) / 4).toString(16) : "00000000-0000-4000-8000-000000000000".replace(/[08]/g, e)
        },
        Gt = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Vt = function e(t, n) {
            var r = [];
            return Object.keys(t).forEach(function (o) {
                var i = t[o],
                    a = n ? n + "[" + o + "]" : o;
                if (i && "object" === (void 0 === i ? "undefined" : Gt(i))) {
                    var s = e(i, a);
                    "" !== s && (r = [].concat(c(r), [s]))
                } else void 0 !== i && null !== i && (r = [].concat(c(r), [a + "=" + encodeURIComponent(String(i))]))
            }), r.join("&").replace(/%20/g, "+")
        },
        Kt = Vt,
        $t = n(6),
        Jt = n.n($t),
        Qt = function () {
            function e(e, t) {
                var n = [],
                    r = !0,
                    o = !1,
                    i = void 0;
                try {
                    for (var a, s = e[Symbol.iterator](); !(r = (a = s.next()).done) && (n.push(a.value), !t || n.length !== t); r = !0);
                } catch (e) {
                    o = !0, i = e
                } finally {
                    try {
                        !r && s.return && s.return()
                    } finally {
                        if (o) throw i
                    }
                }
                return n
            }
            return function (t, n) {
                if (Array.isArray(t)) return t;
                if (Symbol.iterator in Object(t)) return e(t, n);
                throw new TypeError("Invalid attempt to destructure non-iterable instance")
            }
        }(),
        Zt = function (e, t) {
            var n = {};
            t.forEach(function (e) {
                var t = Qt(e, 2),
                    r = t[0],
                    o = t[1];
                r.split(/\s+/).forEach(function (e) {
                    e && (n[e] = n[e] || o)
                })
            }), e.className = Jt()(e.className, n)
        },
        Xt = function (e, t) {
            e.style.cssText = Object.keys(t).map(function (e) {
                return e + ": " + t[e] + " !important;"
            }).join(" ")
        },
        en = function (e) {
            try {
                return window.parent.frames[e]
            } catch (e) {
                return null
            }
        },
        tn = function (e) {
            if (!document.body) throw new we("Stripe.js requires that your page has a <body> element.");
            return e(document.body)
        },
        nn = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        rn = function (e) {
            var t = e.frameId,
                n = e.controllerId,
                r = e.type,
                o = Ft,
                i = void 0;
            "controller" === r ? i = en(t) : "group" === r ? i = en(n) : "outer" === r ? i = window.frames[t] : "inner" === r && (o = "*", i = window.parent), i && i.postMessage(JSON.stringify(nn({}, e, {
                __stripeJsV3: !0
            })), o)
        },
        on = function (e) {
            try {
                var t = "string" == typeof e ? JSON.parse(e) : e;
                return t.__stripeJsV3 ? t : null
            } catch (e) {
                return null
            }
        },
        an = (n(7), function (e, t) {
            var n = e._isUserError || "IntegrationError" === e.name;
            throw t && !n && t.report("fatal.uncaught_error", {
                iframe: !1,
                name: e.name,
                element: "outer",
                message: e.message || e.description,
                fileName: e.fileName,
                lineNumber: e.lineNumber,
                columnNumber: e.columnNumber,
                stack: e.stack && e.stack.substring(0, 1e3)
            }), e
        }),
        sn = function (e, t) {
            return function (n) {
                try {
                    return e.call(this, n)
                } catch (e) {
                    return an(e, t || this && this._controller)
                }
            }
        },
        cn = function (e, t) {
            return function (n, r) {
                try {
                    return e.call(this, n, r)
                } catch (e) {
                    return an(e, t || this && this._controller)
                }
            }
        },
        un = function (e, t) {
            return function (n, r, o) {
                try {
                    return e.call(this, n, r, o)
                } catch (e) {
                    return an(e, t || this && this._controller)
                }
            }
        },
        ln = function (e, t) {
            return function () {
                try {
                    for (var n = arguments.length, r = Array(n), o = 0; o < n; o++) r[o] = arguments[o];
                    return e.call.apply(e, [this].concat(r))
                } catch (e) {
                    return an(e, t || this && this._controller)
                }
            }
        },
        pn = function e() {
            var t = this;
            u(this, e), this._emit = function (e) {
                for (var n = arguments.length, r = Array(n > 1 ? n - 1 : 0), o = 1; o < n; o++) r[o - 1] = arguments[o];
                return (t._callbacks[e] || []).forEach(function (e) {
                    var t = e.fn;
                    if (t._isUserCallback) try {
                        t.apply(void 0, r)
                    } catch (e) {
                        throw e._isUserError = !0, e
                    } else t.apply(void 0, r)
                }), t
            }, this._once = function (e, n) {
                var r = function r() {
                    t._off(e, r), n.apply(void 0, arguments)
                };
                return t._on(e, r, n)
            }, this._removeAllListeners = function () {
                return t._callbacks = {}, t
            }, this._on = function (e, n, r) {
                return t._callbacks[e] = t._callbacks[e] || [], t._callbacks[e].push({
                    original: r,
                    fn: n
                }), t
            }, this._validateUserOn = function (e, t) {}, this._userOn = function (e, n) {
                if ("string" != typeof e) throw new we("When adding an event listener, the first argument should be a string event name.");
                if ("function" != typeof n) throw new we("When adding an event listener, the second argument should be a function callback.");
                return t._validateUserOn(e, n), n._isUserCallback = !0, t._on(e, n)
            }, this._hasRegisteredListener = function (e) {
                return t._callbacks[e] && t._callbacks[e].length > 0
            }, this._off = function (e, n) {
                if (n) {
                    for (var r = t._callbacks[e], o = void 0, i = 0; i < r.length; i++)
                        if (o = r[i], o.fn === n || o.original === n) {
                            r.splice(i, 1);
                            break
                        }
                } else delete t._callbacks[e];
                return t
            }, this._callbacks = {};
            var n = cn(this._userOn),
                r = cn(this._off),
                o = cn(this._once),
                i = sn(this._hasRegisteredListener),
                a = sn(this._removeAllListeners),
                s = ln(this._emit);
            this.on = this.addListener = this.addEventListener = n, this.off = this.removeListener = this.removeEventListener = r, this.once = o, this.hasRegisteredListener = i, this.removeAllListeners = a, this.emit = s
        },
        fn = pn,
        dn = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        hn = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        _n = function (e) {
            function t(e, n, r) {
                p(this, t);
                var o = f(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
                return o.type = e, o.loaded = !1, o._controllerId = n, o._persistentMessages = [], o._queuedMessages = [], o._requests = {}, o.id = o._generateId(), o._iframe = o._createIFrame(r), o._on("load", function () {
                    o.loaded = !0, o._ensureMounted(), o.loaded && (o._persistentMessages.forEach(function (e) {
                        return o._send(e)
                    }), o._queuedMessages.forEach(function (e) {
                        return o._send(e)
                    }), o._queuedMessages = [])
                }), o
            }
            return d(t, e), hn(t, [{
                key: "_generateId",
                value: function () {
                    return Yt("__privateStripeFrame")
                }
            }, {
                key: "send",
                value: function (e) {
                    this._send({
                        message: e,
                        type: "outer",
                        frameId: this.id,
                        controllerId: this._controllerId
                    })
                }
            }, {
                key: "sendPersistent",
                value: function (e) {
                    this._ensureMounted();
                    var t = {
                        message: e,
                        type: "outer",
                        frameId: this.id,
                        controllerId: this._controllerId
                    };
                    this._persistentMessages = [].concat(l(this._persistentMessages), [t]), this.loaded && rn(t)
                }
            }, {
                key: "action",
                value: function (e) {
                    var t = this,
                        n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {},
                        r = Yt(e);
                    return new Pe(function (o, i) {
                        t._requests[r] = {
                            resolve: o,
                            reject: i
                        }, t._send({
                            message: {
                                action: "stripe-frame-action",
                                payload: {
                                    type: e,
                                    nonce: r,
                                    options: n
                                }
                            },
                            type: "outer",
                            frameId: t.id,
                            controllerId: t._controllerId
                        })
                    })
                }
            }, {
                key: "resolve",
                value: function (e, t) {
                    this._requests[e] && this._requests[e].resolve(t)
                }
            }, {
                key: "_send",
                value: function (e) {
                    this._ensureMounted(), this.loaded ? rn(e) : this._queuedMessages = [].concat(l(this._queuedMessages), [e])
                }
            }, {
                key: "appendTo",
                value: function (e) {
                    e.appendChild(this._iframe)
                }
            }, {
                key: "unmount",
                value: function () {
                    this.loaded = !1, this._emit("unload")
                }
            }, {
                key: "destroy",
                value: function () {
                    this.unmount();
                    var e = this._iframe.parentElement;
                    e && e.removeChild(this._iframe), this._emit("destroy")
                }
            }, {
                key: "_ensureMounted",
                value: function () {
                    this._isMounted() || this.unmount()
                }
            }, {
                key: "_isMounted",
                value: function () {
                    return !!document.body && document.body.contains(this._iframe)
                }
            }, {
                key: "_createIFrame",
                value: function (e) {
                    var t = window.location.href.toString(),
                        n = St(t),
                        r = n ? n.origin : "",
                        o = e.queryString && "string" == typeof e.queryString ? e.queryString : Kt(dn({}, e, {
                            origin: r,
                            referrer: t,
                            controllerId: this._controllerId
                        })),
                        i = document.createElement("iframe");
                    return i.setAttribute("frameborder", "0"), i.setAttribute("allowTransparency", "true"), i.setAttribute("scrolling", "no"), i.setAttribute("name", this.id), i.setAttribute("allowpaymentrequest", "true"), i.src = Ct(this.type) + "#" + o, i
                }
            }]), t
        }(fn),
        mn = _n,
        yn = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        vn = function e(t, n, r) {
            null === t && (t = Function.prototype);
            var o = Object.getOwnPropertyDescriptor(t, n);
            if (void 0 === o) {
                var i = Object.getPrototypeOf(t);
                return null === i ? void 0 : e(i, n, r)
            }
            if ("value" in o) return o.value;
            var a = o.get;
            if (void 0 !== a) return a.call(r)
        },
        bn = {
            border: "none",
            margin: "0",
            padding: "0",
            width: "1px",
            "min-width": "100%",
            overflow: "hidden",
            display: "block",
            visibility: "hidden",
            position: "fixed",
            height: "1px",
            "pointer-events": "none",
            "user-select": "none"
        },
        gn = function (e) {
            function t(e, n, r) {
                h(this, t);
                var o = _(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this, e, n, r));
                if (o.autoload = r.autoload || !1, "complete" === document.readyState) o._ensureMounted();
                else {
                    var i = o._ensureMounted.bind(o);
                    document.addEventListener("DOMContentLoaded", i), window.addEventListener("load", i), setTimeout(i, 5e3)
                }
                return o
            }
            return m(t, e), yn(t, [{
                key: "_ensureMounted",
                value: function () {
                    vn(t.prototype.__proto__ || Object.getPrototypeOf(t.prototype), "_ensureMounted", this).call(this), this._isMounted() || this._autoMount()
                }
            }, {
                key: "_autoMount",
                value: function () {
                    if (document.body) this.appendTo(document.body);
                    else if ("complete" === document.readyState || "interactive" === document.readyState) throw new we("Stripe.js requires that your page has a <body> element.");
                    this.autoload && (this.loaded = !0)
                }
            }, {
                key: "_createIFrame",
                value: function (e) {
                    var n = vn(t.prototype.__proto__ || Object.getPrototypeOf(t.prototype), "_createIFrame", this).call(this, e);
                    return n.setAttribute("aria-hidden", "true"), n.setAttribute("allowpaymentrequest", "true"), n.setAttribute("tabIndex", "-1"), Xt(n, bn), n
                }
            }]), t
        }(mn),
        wn = gn,
        En = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        kn = function (e) {
            function t() {
                return y(this, t), v(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments))
            }
            return b(t, e), En(t, [{
                key: "_generateId",
                value: function () {
                    return this._controllerId
                }
            }]), t
        }(wn),
        Sn = kn,
        On = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        Pn = function e(t, n, r) {
            null === t && (t = Function.prototype);
            var o = Object.getOwnPropertyDescriptor(t, n);
            if (void 0 === o) {
                var i = Object.getPrototypeOf(t);
                return null === i ? void 0 : e(i, n, r)
            }
            if ("value" in o) return o.value;
            var a = o.get;
            if (void 0 !== a) return a.call(r)
        },
        An = {
            border: "none",
            margin: "0",
            padding: "0",
            width: "1px",
            "min-width": "100%",
            overflow: "hidden",
            display: "block",
            "user-select": "none"
        },
        Tn = function (e) {
            function t() {
                return g(this, t), w(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments))
            }
            return E(t, e), On(t, [{
                key: "update",
                value: function (e) {
                    this.send({
                        action: "stripe-user-update",
                        payload: e
                    })
                }
            }, {
                key: "updateStyle",
                value: function (e) {
                    var t = this;
                    Object.keys(e).forEach(function (n) {
                        t._iframe.style[n] = e[n]
                    })
                }
            }, {
                key: "focus",
                value: function () {
                    this.loaded && this.send({
                        action: "stripe-user-focus",
                        payload: {}
                    })
                }
            }, {
                key: "blur",
                value: function () {
                    this.loaded && (this._iframe.contentWindow.blur(), this._iframe.blur())
                }
            }, {
                key: "clear",
                value: function () {
                    this.send({
                        action: "stripe-user-clear",
                        payload: {}
                    })
                }
            }, {
                key: "_createIFrame",
                value: function (e) {
                    var n = Pn(t.prototype.__proto__ || Object.getPrototypeOf(t.prototype), "_createIFrame", this).call(this, e);
                    return n.setAttribute("title", "Secure payment input frame"), Xt(n, An), n
                }
            }]), t
        }(mn),
        In = Tn,
        jn = function (e, t) {
            var n = !1;
            return function () {
                if (n) throw new we(t);
                n = !0;
                try {
                    return e.apply(void 0, arguments).then(function (e) {
                        return n = !1, e
                    }, function (e) {
                        throw n = !1, e
                    })
                } catch (e) {
                    throw n = !1, e
                }
            }
        },
        Cn = function (e) {
            var t = e;
            return function () {
                t && (t.apply(void 0, arguments), t = null)
            }
        },
        Rn = function () {
            return tn(function (e) {
                var t = e.style,
                    n = t.position,
                    r = t.top,
                    o = t.left,
                    i = t.bottom,
                    a = t.right,
                    s = t.overflow,
                    c = window,
                    u = c.pageXOffset,
                    l = c.pageYOffset,
                    p = document.documentElement ? window.innerWidth - document.documentElement.offsetWidth : 0,
                    f = document.documentElement ? window.innerHeight - document.documentElement.offsetHeight : 0;
                return e.style.position = "fixed", e.style.overflow = "hidden", e.style.top = -l + "px", e.style.left = -u + "px", e.style.right = p + "px", e.style.bottom = f + "px", Cn(function () {
                    e.style.position = n, e.style.top = r, e.style.left = o, e.style.bottom = i, e.style.right = a, e.style.overflow = s, window.scrollTo(u, l)
                })
            })
        },
        Mn = function (e, t) {
            var n = Array.prototype.slice.call(document.querySelectorAll("a[href], area[href], input:not([disabled]),\n  select:not([disabled]), textarea:not([disabled]), button:not([disabled]),\n  object, embed, *[tabindex], *[contenteditable]")).filter(function (e) {
                var t = e.getAttribute("tabindex"),
                    n = !t || parseInt(t, 10) >= 0,
                    r = e.getBoundingClientRect(),
                    o = r.width > 0 && r.height > 0;
                return n && o
            });
            return n[je(n, function (t) {
                return t === e || e.contains(t)
            }) + ("previous" === t ? -1 : 1)]
        },
        Nn = function (e) {
            var t = [],
                n = Le(document.querySelectorAll("*"), function (n) {
                    var r = n.getAttribute("tabindex") || "";
                    e !== n && (n.tabIndex = -1), t.push({
                        element: n,
                        tabIndex: r
                    })
                });
            return Cn(function () {
                n.then(function () {
                    return Le(t, function (e) {
                        var t = e.element,
                            n = e.tabIndex;
                        "" === n ? t.removeAttribute("tabindex") : t.setAttribute("tabindex", n)
                    })
                })
            })
        },
        qn = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Ln = {
            display: "block",
            position: "fixed",
            "z-index": "2147483647",
            background: "rgba(0,0,0,0)",
            transition: "background 300ms cubic-bezier(0.4, 0, 0.2, 1)",
            "will-change": "background",
            top: "0",
            left: "0",
            right: "0",
            bottom: "0"
        },
        Dn = qn({}, Ln, {
            background: "rgba(0,0,0,0.5)"
        }),
        xn = function e(t) {
            var n = this,
                r = t.lockScrolling,
                o = t.lockFocus,
                i = t.lockFocusOn;
            k(this, e), this.domElement = document.createElement("div"), this._runOnHide = [], this.mount = function () {
                tn(function (e) {
                    n.domElement.style.display = "none", e.contains(n.domElement) || e.insertBefore(n.domElement, e.firstChild)
                })
            }, this.show = function () {
                if (Xt(n.domElement, Ln), n._lockScrolling) {
                    var e = Rn();
                    n._runOnHide.push(e)
                }
                if (n._lockFocus) {
                    var t = Nn(n._lockFocusOn);
                    n._runOnHide.push(t)
                }
            }, this.fadeIn = function () {
                setTimeout(function () {
                    Xt(n.domElement, Dn)
                })
            }, this.fadeOut = function () {
                return new Pe(function (e) {
                    Xt(n.domElement, Ln), setTimeout(e, 500), n.domElement.addEventListener("transitionend", e)
                }).then(function () {
                    for (; n._runOnHide.length;) n._runOnHide.pop()()
                })
            }, this.unmount = function () {
                tn(function (e) {
                    e.removeChild(n.domElement)
                })
            }, this._lockScrolling = !!r, this._lockFocus = !!o, this._lockFocusOn = i || null
        },
        Fn = xn,
        Bn = function e(t, n, r) {
            null === t && (t = Function.prototype);
            var o = Object.getOwnPropertyDescriptor(t, n);
            if (void 0 === o) {
                var i = Object.getPrototypeOf(t);
                return null === i ? void 0 : e(i, n, r)
            }
            if ("value" in o) return o.value;
            var a = o.get;
            if (void 0 !== a) return a.call(r)
        },
        Un = {
            position: "absolute",
            left: "0",
            top: "0",
            height: "100%",
            width: "100%"
        },
        zn = function (e) {
            function t(e, n, r) {
                S(this, t);
                var o = O(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this, e, n, r));
                return o._autoMount = function () {
                    o.appendTo(o._backdrop.domElement), o._backdrop.mount()
                }, o.show = function () {
                    o._backdrop.show(), Xt(o._iframe, Un)
                }, o.fadeInBackdrop = function () {
                    o._backdrop.fadeIn()
                }, o._backdropFadeoutPromise = null, o.fadeOutBackdrop = function () {
                    return o._backdropFadeoutPromise || (o._backdropFadeoutPromise = o._backdrop.fadeOut()), o._backdropFadeoutPromise
                }, o.destroy = function () {
                    return o.fadeOutBackdrop().then(function () {
                        o._backdrop.unmount(), Bn(t.prototype.__proto__ || Object.getPrototypeOf(t.prototype), "destroy", o).call(o)
                    })
                }, o._backdrop = new Fn({
                    lockScrolling: !0,
                    lockFocus: !0,
                    lockFocusOn: o._iframe
                }), o._autoMount(), o
            }
            return P(t, e), t
        }(mn),
        Hn = zn,
        Yn = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Wn = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        Gn = function e(t, n, r) {
            null === t && (t = Function.prototype);
            var o = Object.getOwnPropertyDescriptor(t, n);
            if (void 0 === o) {
                var i = Object.getPrototypeOf(t);
                return null === i ? void 0 : e(i, n, r)
            }
            if ("value" in o) return o.value;
            var a = o.get;
            if (void 0 !== a) return a.call(r)
        },
        Vn = {
            display: "block",
            position: "absolute",
            "z-index": "1000",
            width: "1px",
            "min-width": "100%",
            margin: "2px 0 0 0",
            padding: "0",
            border: "none",
            overflow: "hidden"
        },
        Kn = function (e) {
            function t() {
                return A(this, t), T(this, (t.__proto__ || Object.getPrototypeOf(t)).apply(this, arguments))
            }
            return I(t, e), Wn(t, [{
                key: "updateStyle",
                value: function (e) {
                    var t = this;
                    Object.keys(e).forEach(function (n) {
                        t._iframe.style[n] = e[n]
                    })
                }
            }, {
                key: "update",
                value: function (e) {
                    this.send({
                        action: "stripe-user-update",
                        payload: e
                    })
                }
            }, {
                key: "_createIFrame",
                value: function (e) {
                    var n = Gn(t.prototype.__proto__ || Object.getPrototypeOf(t.prototype), "_createIFrame", this).call(this, Yn({}, e, {
                        isSecondaryFrame: !0
                    }));
                    return Xt(n, Vn), n.style.height = "0", n
                }
            }]), t
        }(mn),
        $n = Kn,
        Jn = function (e) {
            var t = St(e),
                n = t ? t.host : "";
            return "stripe.com" === n || !!n.match(/\.stripe\.(com|me)$/)
        },
        Qn = function (e, t) {
            var n = St(e),
                r = St(t);
            return !(!n || !r) && n.origin === r.origin
        },
        Zn = function (e) {
            return Qn(e, "https://js.stripe.com/v3/")
        },
        Xn = function (e) {
            return Zn(e) || Jn(e)
        },
        er = ["button", "checkbox", "file", "hidden", "image", "submit", "radio", "reset"],
        tr = function (e) {
            var t = e.tagName;
            if (e.isContentEditable || "TEXTAREA" === t) return !0;
            if ("INPUT" !== t) return !1;
            var n = e.getAttribute("type");
            return -1 === er.indexOf(n)
        },
        nr = tr,
        rr = function (e) {
            return /Edge\//i.test(e)
        },
        or = function (e) {
            return /(MSIE ([0-9]{1,}[.0-9]{0,})|Trident\/)/i.test(e)
        },
        ir = function (e) {
            return /SamsungBrowser/.test(e)
        },
        ar = function (e) {
            return /iPad|iPhone/i.test(e) && !or(e)
        },
        sr = function (e) {
            return /Android/i.test(e) && !or(e)
        },
        cr = window.navigator.userAgent,
        ur = rr(cr),
        lr = (function (e) {
            /Edge\/((1[0-6]\.)|0\.)/i.test(e)
        }(cr), or(cr)),
        pr = function (e) {
            return /MSIE 9/i.test(e)
        }(cr),
        fr = (function (e) {
            /MSIE ([0-9]{1,}[.0-9]{0,})/i.test(e)
        }(cr), ar(cr)),
        dr = (function (e) {
            ar(e) || sr(e)
        }(cr), sr(cr), function (e) {
            /Android 4\./i.test(e) && !/Chrome/i.test(e) && sr(e)
        }(cr), function (e) {
            return /^((?!chrome|android).)*safari/i.test(e) && !ir(e)
        }(cr)),
        hr = (function (e) {
            /Firefox\//i.test(e)
        }(cr), function (e) {
            /Firefox\/(50|51|[0-4]?\d)([^\d]|$)/i.test(e)
        }(cr), ir(cr)),
        _r = (function (e) {
            /Chrome\/(6[6-9]|[7-9]\d+|[1-9]\d{2,})/i.test(e)
        }(cr), function (e) {
            return /AppleWebKit/i.test(e) && !/Chrome/i.test(e) && !rr(e) && !or(e)
        }(cr)),
        mr = function (e) {
            return /Chrome/i.test(e) && !rr(e)
        }(cr),
        yr = (he = {}, j(he, Mt.card, {
            unique: !0,
            conflict: [Mt.cardNumber, Mt.cardExpiry, Mt.cardCvc, Mt.postalCode],
            beta: !1
        }), j(he, Mt.cardNumber, {
            unique: !0,
            conflict: [Mt.card],
            beta: !1
        }), j(he, Mt.cardExpiry, {
            unique: !0,
            conflict: [Mt.card],
            beta: !1
        }), j(he, Mt.cardCvc, {
            unique: !0,
            conflict: [Mt.card],
            beta: !1
        }), j(he, Mt.postalCode, {
            unique: !0,
            conflict: [Mt.card],
            beta: !1
        }), j(he, Mt.paymentRequestButton, {
            unique: !0,
            conflict: [],
            beta: !1
        }), j(he, Mt.iban, {
            unique: !0,
            conflict: [],
            beta: !1
        }), j(he, Mt.idealBank, {
            unique: !0,
            conflict: [],
            beta: !1
        }), he),
        vr = yr,
        br = (_e = {}, C(_e, Mt.card, Tt.CARD_ELEMENT), C(_e, Mt.cardNumber, Tt.CARD_ELEMENT), C(_e, Mt.cardExpiry, Tt.CARD_ELEMENT), C(_e, Mt.cardCvc, Tt.CARD_ELEMENT), C(_e, Mt.postalCode, Tt.CARD_ELEMENT), C(_e, Mt.paymentRequestButton, Tt.PAYMENT_REQUEST_ELEMENT), C(_e, Mt.iban, Tt.IBAN_ELEMENT), C(_e, Mt.idealBank, Tt.IDEAL_BANK_ELEMENT), _e),
        gr = br,
        wr = ["brand"],
        Er = ["country", "bankName"],
        kr = ["bankName", "branchName"],
        Sr = (me = {}, R(me, Mt.card, wr), R(me, Mt.cardNumber, wr), R(me, Mt.iban, Er), R(me, Mt.auBankAccount, kr), me),
        Or = R({}, Mt.idealBank, {
            secondary: Mt.idealBankSecondary
        }),
        Pr = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Ar = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Tr = !1,
        Ir = function (e, t) {
            return document.activeElement === e._iframe || e._iframe.parentElement && document.activeElement === t
        },
        jr = function e(t) {
            N(this, e), Cr.call(this);
            var n = t.apiKey,
                r = t.stripeAccount,
                o = t.stripeJsId,
                i = t.locale;
            this._id = Yt("__privateStripeController"), this._stripeJsId = o, this._apiKey = n, this._stripeAccount = r, this._controllerFrame = new Sn(Tt.CONTROLLER, this._id, Ar({}, t)), this._frames = {}, this._requests = {}, this._setupPostMessage(), this._handleMessage = sn(this._handleMessage, this), this.action.fetchLocale({
                locale: i || "auto"
            })
        },
        Cr = function () {
            var e = this;
            this._sendCAReq = function (t) {
                var n = Yt(t.tag);
                return new Pe(function (r, o) {
                    e._requests[n] = {
                        resolve: r,
                        reject: o
                    }, e._controllerFrame.send({
                        action: "stripe-safe-controller-action-request",
                        payload: {
                            nonce: n,
                            caReq: t
                        }
                    })
                })
            }, this.livemode = function () {
                var t = e._apiKey;
                return /^pk_test_/.test(t) ? "testmode" : /^pk_live_/.test(t) ? "livemode" : "unknown"
            }, this.action = {
                retrievePaymentIntent: function (t) {
                    return e._sendCAReq({
                        tag: "RETRIEVE_PAYMENT_INTENT",
                        value: t
                    })
                },
                confirmPaymentIntent: function (t) {
                    return e._sendCAReq({
                        tag: "CONFIRM_PAYMENT_INTENT",
                        value: t
                    })
                },
                confirmSetupIntent: function (t) {
                    return e._sendCAReq({
                        tag: "CONFIRM_SETUP_INTENT",
                        value: t
                    })
                },
                retrieveSetupIntent: function (t) {
                    return e._sendCAReq({
                        tag: "RETRIEVE_SETUP_INTENT",
                        value: t
                    })
                },
                fetchLocale: function (t) {
                    return e._sendCAReq({
                        tag: "FETCH_LOCALE",
                        value: t
                    })
                },
                updateCSSFonts: function (t) {
                    return e._sendCAReq({
                        tag: "UPDATE_CSS_FONTS",
                        value: t
                    })
                },
                createApplePaySession: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_APPLE_PAY_SESSION",
                        value: t
                    })
                },
                retrieveSource: function (t) {
                    return e._sendCAReq({
                        tag: "RETRIEVE_SOURCE",
                        value: t
                    })
                },
                tokenizeWithElement: function (t) {
                    return e._sendCAReq({
                        tag: "TOKENIZE_WITH_ELEMENT",
                        value: t
                    })
                },
                tokenizeCvcUpdate: function (t) {
                    return e._sendCAReq({
                        tag: "TOKENIZE_CVC_UPDATE",
                        value: t
                    })
                },
                tokenizeWithData: function (t) {
                    return e._sendCAReq({
                        tag: "TOKENIZE_WITH_DATA",
                        value: t
                    })
                },
                createSourceWithElement: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_SOURCE_WITH_ELEMENT",
                        value: t
                    })
                },
                createSourceWithData: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_SOURCE_WITH_DATA",
                        value: t
                    })
                },
                createPaymentMethodWithElement: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_PAYMENT_METHOD_WITH_ELEMENT",
                        value: t
                    })
                },
                createPaymentMethodWithData: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_PAYMENT_METHOD_WITH_DATA",
                        value: t
                    })
                },
                createPaymentPage: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_PAYMENT_PAGE",
                        value: t
                    })
                },
                createPaymentPageWithSession: function (t) {
                    return e._sendCAReq({
                        tag: "CREATE_PAYMENT_PAGE_WITH_SESSION",
                        value: t
                    })
                }
            }, this.createElementFrame = function (t, n) {
                var r = n.groupId,
                    o = M(n, ["groupId"]),
                    i = new In(t, e._id, Ar({}, o, {
                        keyMode: ze(e._apiKey)
                    }));
                return e._setupFrame(i, t, r)
            }, this.createSecondaryElementFrame = function (t, n) {
                var r = n.groupId,
                    o = M(n, ["groupId"]),
                    i = new $n(t, e._id, o);
                return e._setupFrame(i, t, r)
            }, this.createHiddenFrame = function (t, n) {
                var r = new wn(t, e._id, n);
                return e._setupFrame(r, t)
            }, this.createLightboxFrame = function (t, n) {
                var r = new Hn(t, e._id, n);
                return e._setupFrame(r, t)
            }, this._setupFrame = function (t, n, r) {
                return e._frames[t.id] = t, e._controllerFrame.sendPersistent({
                    action: "stripe-user-createframe",
                    payload: {
                        newFrameId: t.id,
                        frameType: n,
                        groupId: r
                    }
                }), t._on("unload", function () {
                    e._controllerFrame.sendPersistent({
                        action: "stripe-frame-unload",
                        payload: {
                            unloadedFrameId: t.id
                        }
                    })
                }), t._on("destroy", function () {
                    delete e._frames[t.id], e._controllerFrame.sendPersistent({
                        action: "stripe-frame-destroy",
                        payload: {
                            destroyedFrameId: t.id
                        }
                    })
                }), t._on("load", function () {
                    e._controllerFrame.sendPersistent({
                        action: "stripe-frame-load",
                        payload: {
                            loadedFrameId: t.id
                        }
                    }), e._controllerFrame.loaded && t.send({
                        action: "stripe-controller-load",
                        payload: {}
                    })
                }), t
            }, this.report = function (t) {
                var n = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                e._controllerFrame.send({
                    action: "stripe-controller-report",
                    payload: {
                        event: t,
                        data: n
                    }
                })
            }, this.warn = function () {
                for (var t = arguments.length, n = Array(t), r = 0; r < t; r++) n[r] = arguments[r];
                e._controllerFrame.send({
                    action: "stripe-controller-warn",
                    payload: {
                        args: n
                    }
                })
            }, this.controllerFor = function () {
                return "outer"
            }, this._setupPostMessage = function () {
                window.addEventListener("message", function (t) {
                    var n = t.data,
                        r = t.origin,
                        o = on(n);
                    o && Qn(Ft, r) && e._handleMessage(o)
                })
            }, this._handleMessage = function (t) {
                var n = t.controllerId,
                    r = t.frameId,
                    o = t.message,
                    i = e._frames[r];
                if (n === e._id) switch (o.action) {
                    case "stripe-frame-event":
                        var a = o.payload,
                            s = a.event,
                            c = a.data;
                        if (i) {
                            if (fr) {
                                var u = i._iframe.parentElement,
                                    l = u && u.querySelector(".__PrivateStripeElement-input");
                                if ("focus" === s && !Tr && !Ir(i, l)) {
                                    l && l.focus(), Tr = !0;
                                    break
                                }
                                if ("blur" === s && Tr) {
                                    Tr = !1;
                                    break
                                }
                                "blur" === s && setTimeout(function () {
                                    var e = document.activeElement;
                                    if (e && !Ir(i, l) && !nr(e)) {
                                        var t = u && u.querySelector(".__PrivateStripeElement-safariInput");
                                        if (t) {
                                            var n = t;
                                            n.disabled = !1, n.focus(), n.blur(), n.disabled = !0
                                        }
                                        e.focus()
                                    }
                                }, 400)
                            }
                            i._emit(s, c)
                        }
                        break;
                    case "stripe-frame-action-complete":
                        i && i.resolve(o.payload.nonce, o.payload.result);
                        break;
                    case "stripe-frame-error":
                        throw new we(o.payload.message);
                    case "stripe-integration-error":
                        i && i._emit("__privateIntegrationError", {
                            message: o.payload.message
                        });
                        break;
                    case "stripe-controller-load":
                        e._controllerFrame._emit("load"), Object.keys(e._frames).forEach(function (t) {
                            return e._frames[t].send({
                                action: "stripe-controller-load",
                                payload: {}
                            })
                        });
                        break;
                    case "stripe-safe-controller-action-response":
                        e._requests[o.payload.nonce] && e._requests[o.payload.nonce].resolve(o.payload.caRes);
                        break;
                    case "stripe-safe-controller-action-error":
                        if (e._requests[o.payload.nonce]) {
                            var p = o.payload.caErr;
                            "object" === (void 0 === p ? "undefined" : Pr(p)) && null !== p && "string" == typeof p.name && "IntegrationError" === p.name ? e._requests[o.payload.nonce].reject(new we("string" == typeof p.message ? p.message : "")) : e._requests[o.payload.nonce].reject(p)
                        }
                }
            }
        },
        Rr = jr,
        Mr = function () {
            var e = document.querySelectorAll("meta[name=viewport][content]"),
                t = e[e.length - 1];
            return t && t instanceof HTMLMetaElement ? t.content : ""
        },
        Nr = function (e) {
            Mr().match(/width=device-width/) || e('Elements requires "width=device-width" be set in your page\'s viewport meta tag.\n       For more information: https://stripe.com/docs/stripe-js/elements/quickstart#viewport-meta-requirements')
        },
        qr = function (e) {
            function t() {
                q(this, t);
                var e = L(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
                return e.name = "NetworkError", e.type = "network_error", e
            }
            return D(t, e), t
        }(Error),
        Lr = qr,
        Dr = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        xr = {
            Accept: "application/json",
            "Content-Type": "application/x-www-form-urlencoded"
        },
        Fr = function (e) {
            return Object.keys(xr).forEach(function (t) {
                e.setRequestHeader(t, xr[t])
            }), e
        },
        Br = function e(t) {
            return new Pe(function (n, r) {
                var o = t.method,
                    i = t.url,
                    a = t.data,
                    s = t.withCredentials,
                    c = a ? Kt(a) : "",
                    u = !window.XMLHttpRequest || Ot(i) && void 0 === (new XMLHttpRequest).withCredentials,
                    l = "GET" === o && c ? i + "?" + c : i,
                    p = "GET" === o ? "" : c;
                if (u) {
                    var f = new window.XDomainRequest;
                    try {
                        f.open(o, l)
                    } catch (e) {
                        r(e)
                    }
                    f.onerror = function () {
                        n({
                            responseText: JSON.stringify({
                                error: {
                                    type: "api_error"
                                }
                            })
                        })
                    }, f.onload = function () {
                        n({
                            status: 200,
                            responseText: f.responseText
                        })
                    }, setTimeout(function () {
                        f.send(p)
                    }, 0)
                } else {
                    var d = new XMLHttpRequest;
                    s && (d.withCredentials = s), d.open(o, l, !0), Fr(d), d.onreadystatechange = function () {
                        4 === d.readyState && (d.onreadystatechange = function () {}, 0 === d.status ? s ? r(new Lr) : e(Dr({}, t, {
                            withCredentials: !0
                        })).then(n, r) : n(d))
                    };
                    try {
                        d.send(p)
                    } catch (e) {
                        r(e)
                    }
                }
            })
        },
        Ur = Br,
        zr = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Hr = function (e, t) {
            var n = /@font-face[ ]?{[^}]*}/g,
                r = e.match(n);
            if (!r) throw new we("No @font-face rules found in file from " + t);
            return r
        },
        Yr = function (e) {
            var t = e.match(/@font-face[ ]?{([^}]*)}/);
            return t ? t[1] : ""
        },
        Wr = function (e, t) {
            var n = e.replace(/\/\*.*\*\//g, "").trim(),
                r = n.length && /;$/.test(n) ? n : n + ";",
                o = r.match(/((([^;(]*\([^()]*\)[^;)]*)|[^;]+)+)(?=;)/g);
            if (!o) throw new we("Found @font-face rule containing no valid font-properties in file from " + t);
            return o
        },
        Gr = function (e, t) {
            var n = e.indexOf(":");
            if (-1 === n) throw new we("Invalid css declaration in file from " + t + ': "' + e + '"');
            var r = e.slice(0, n).trim(),
                o = Ut[r];
            if (!o) throw new we("Unsupported css property in file from " + t + ': "' + r + '"');
            return {
                property: o,
                value: e.slice(n + 1).trim()
            }
        },
        Vr = function (e, t) {
            var n = e.reduce(function (e, n) {
                var r = Gr(n, t),
                    o = r.property,
                    i = r.value;
                return zr({}, e, x({}, o, i))
            }, {});
            return ["family", "src"].forEach(function (e) {
                if (!n[e]) throw new we("Missing css property in file from " + t + ': "' + Bt[e] + '"')
            }), n
        },
        Kr = function (e) {
            return Ur({
                url: e,
                method: "GET"
            }).then(function (e) {
                return e.responseText
            }).then(function (t) {
                return Hr(t, e).map(function (t) {
                    var n = Yr(t),
                        r = Wr(n, e);
                    return Vr(r, e)
                })
            })
        },
        $r = Kr,
        Jr = function (e, t) {
            return e.reduce(function (e, n) {
                return e.then(function (e) {
                    return "SATISFIED" === e.type ? e : n().then(function (e) {
                        return t(e) ? {
                            type: "SATISFIED",
                            value: e
                        } : {
                            type: "UNSATISFIED"
                        }
                    })
                })
            }, Pe.resolve({
                type: "UNSATISFIED"
            }))
        },
        Qr = Jr,
        Zr = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Xr = {
            CAN_MAKE_PAYMENT: "CAN_MAKE_PAYMENT"
        },
        eo = {
            success: "success",
            fail: "fail",
            invalid_shipping_address: "invalid_shipping_address"
        },
        to = {
            fail: "fail",
            invalid_payer_name: "invalid_payer_name",
            invalid_payer_email: "invalid_payer_email",
            invalid_payer_phone: "invalid_payer_phone",
            invalid_shipping_address: "invalid_shipping_address"
        },
        no = {
            shipping: "shipping",
            delivery: "delivery",
            pickup: "pickup"
        },
        ro = Zr({
            success: "success"
        }, to),
        oo = {
            merchantCapabilities: ["supports3DS"],
            displayItems: []
        },
        io = bt({
            amount: ft,
            label: it,
            pending: Qe(st)
        }),
        ao = bt({
            amount: pt,
            label: it,
            pending: Qe(st)
        }),
        so = bt({
            amount: pt,
            label: it,
            pending: Qe(st),
            id: at(it, function () {
                return Yt("shippingOption")
            }),
            detail: at(it, function () {
                return ""
            })
        }),
        co = tt.apply(void 0, F(Object.keys(no))),
        uo = bt({
            origin: it,
            name: it
        }),
        lo = bt({
            displayItems: Qe(ht(ao)),
            shippingOptions: Qe(_t("id")(ht(so))),
            total: io,
            requestShipping: Qe(st),
            requestPayerName: Qe(st),
            requestPayerEmail: Qe(st),
            requestPayerPhone: Qe(st),
            shippingType: Qe(co),
            currency: ot,
            country: rt,
            jcbEnabled: Qe(st),
            __billingDetailsEmailOverride: Qe(it),
            __minApplePayVersion: Qe(ct),
            __merchantDetails: Qe(uo),
            __skipGooglePayInPaymentRequest: Qe(st)
        }),
        po = vt({
            currency: Qe(ot),
            displayItems: Qe(ht(ao)),
            shippingOptions: Qe(_t("id")(ht(so))),
            total: Qe(io)
        }),
        fo = function (e, t) {
            var n = ["invalid_payer_name", "invalid_payer_email", "invalid_payer_phone"];
            return tt.apply(void 0, F(Object.keys(eo)))(n.includes(e) ? "fail" : e, t)
        },
        ho = bt({
            displayItems: Qe(ht(ao)),
            shippingOptions: Qe(_t("id")(ht(so))),
            total: Qe(io),
            status: fo
        }),
        _o = tt.apply(void 0, F(Object.keys(ro))),
        mo = {
            checkout_beta_2: "checkout_beta_2",
            checkout_beta_3: "checkout_beta_3",
            checkout_beta_4: "checkout_beta_4",
            payment_intent_beta_1: "payment_intent_beta_1",
            payment_intent_beta_2: "payment_intent_beta_2",
            payment_intent_beta_3: "payment_intent_beta_3",
            card_payment_method_beta_1: "card_payment_method_beta_1",
            acknowledge_ie9_deprecation: "acknowledge_ie9_deprecation",
            cvc_update_beta_1: "cvc_update_beta_1",
            google_pay_beta_1: "google_pay_beta_1",
            checkout_pm_types: "checkout_pm_types"
        },
        yo = Object.keys(mo),
        vo = function (e, t) {
            return e.indexOf(t) >= 0
        },
        bo = function (e) {
            var t = vo(e, mo.google_pay_beta_1);
            return dr ? t ? ["APPLE_PAY", "GOOGLE_PAY"] : ["APPLE_PAY"] : t ? ["GOOGLE_PAY", "BROWSER"] : ["BROWSER"]
        },
        go = bo,
        wo = function () {
            try {
                return window.location.origin === window.top.location.origin
            } catch (e) {
                return !1
            }
        },
        Eo = 2,
        ko = function (e) {
            var t = {};
            return function (n) {
                if (void 0 !== t[n]) return t[n];
                var r = e(n);
                return t[n] = r, r
            }
        }(function (e) {
            return window.ApplePaySession.canMakePaymentsWithActiveCard(e)
        }),
        So = function (e, t, n, r) {
            var o = arguments.length > 4 && void 0 !== arguments[4] ? arguments[4] : Eo,
                i = Math.max(Eo, o);
            if (window.ApplePaySession) {
                if (wo()) {
                    if (n && "https:" !== window.location.protocol) return window.console && window.console.warn("To test Apple Pay, you must serve this page over HTTPS."), Pe.resolve(!1);
                    if (window.ApplePaySession.supportsVersion(i)) {
                        var a = t ? [e, t] : [e],
                            s = "merchant." + a.join(".") + ".stripe";
                        return ko(s).then(function (o) {
                            if (r("pr.apple_pay.can_make_payment_native_response", {
                                    available: o
                                }), n && !o && window.console) {
                                var i = t ? "or stripeAccount parameter (" + t + ") " : "";
                                window.console.warn("Either you do not have a card saved to your Wallet or the current domain (" + e + ") " + i + "is not registered for Apple Pay. Visit https://dashboard.stripe.com/account/apple_pay to register this domain.")
                            }
                            return o
                        })
                    }
                    return n && window.console && window.console.warn("This version of Safari does not support ApplePay JS version " + i + "."), Pe.resolve(!1)
                }
                return Pe.resolve(!1)
            }
            return Pe.resolve(!1)
        },
        Oo = ["mastercard", "visa"],
        Po = ["AT", "AU", "BE", "CA", "CH", "DE", "DK", "EE", "ES", "FI", "FR", "GB", "GR", "HK", "IE", "IT", "JP", "LT", "LU", "LV", "MX", "NL", "NO", "NZ", "PL", "PT", "SE", "SG", "US"],
        Ao = function (e, t) {
            var n = "US" === e || t ? ["discover", "diners", "jcb"].concat(Oo) : Oo;
            return -1 !== Po.indexOf(e) ? ["amex"].concat(B(n)) : n
        },
        To = function (e, t) {
            return Ao(e, t).reduce(function (e, t) {
                return "mastercard" === t ? [].concat(B(e), ["masterCard"]) : "diners" === t ? e : [].concat(B(e), [t])
            }, [])
        },
        Io = {
            bif: 1,
            clp: 1,
            djf: 1,
            gnf: 1,
            jpy: 1,
            kmf: 1,
            krw: 1,
            mga: 1,
            pyg: 1,
            rwf: 1,
            vnd: 1,
            vuv: 1,
            xaf: 1,
            xof: 1,
            xpf: 1
        },
        jo = function (e) {
            var t = Io[e.toLowerCase()] || 100;
            return {
                unitSize: 1 / t,
                fractionDigits: Math.log(t) / Math.log(10)
            }
        },
        Co = function (e, t) {
            var n = jo(t);
            return (e * n.unitSize).toFixed(n.fractionDigits)
        },
        Ro = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Mo = function (e, t) {
            return {
                amount: Co(e.amount, t.currency),
                label: e.label,
                type: e.pending ? "pending" : "final"
            }
        },
        No = function (e, t) {
            return {
                amount: Co(e.amount, t.currency),
                label: e.label,
                detail: e.detail,
                identifier: e.id
            }
        },
        qo = function (e) {
            return function (t) {
                return t[e] && "string" == typeof t[e] ? t[e].toUpperCase() : null
            }
        },
        Lo = (ye = {}, U(ye, ro.success, 0), U(ye, ro.fail, 1), U(ye, ro.invalid_payer_name, 2), U(ye, ro.invalid_shipping_address, 3), U(ye, ro.invalid_payer_phone, 4), U(ye, ro.invalid_payer_email, 4), ye),
        Do = (ve = {}, U(ve, no.pickup, "storePickup"), U(ve, no.shipping, "shipping"), U(ve, no.delivery, "delivery"), ve),
        xo = {
            total: function (e) {
                return Mo(e.total, e)
            },
            lineItems: function (e) {
                return e.displayItems ? e.displayItems.map(function (t) {
                    return Mo(t, e)
                }) : []
            },
            shippingMethods: function (e) {
                return e.shippingOptions ? e.shippingOptions.map(function (t) {
                    return No(t, e)
                }) : []
            }
        },
        Fo = {
            shippingType: function (e) {
                var t = e.shippingType;
                if (!t) return null;
                var n = Do[t];
                if (void 0 !== n) return n;
                throw new we("Invalid value for shippingType: " + t)
            },
            requiredBillingContactFields: function (e) {
                return e.requestPayerName ? ["postalAddress"] : null
            },
            requiredShippingContactFields: function (e) {
                var t = [];
                return e.requestShipping && t.push("postalAddress"), e.requestPayerEmail && t.push("email"), e.requestPayerPhone && t.push("phone"), t.length ? t : null
            },
            countryCode: qo("country"),
            currencyCode: qo("currency"),
            merchantCapabilities: function (e) {
                return function (t) {
                    return t[e] || null
                }
            }("merchantCapabilities"),
            supportedNetworks: function (e) {
                return To(e.country, e.jcbEnabled || !1)
            }
        },
        Bo = {
            status: function (e) {
                return Lo[e.status] || 0
            }
        },
        Uo = Ro({}, xo, Fo),
        zo = Ro({}, xo, Bo),
        Ho = function (e) {
            var t = Ro({}, oo, e);
            return Object.keys(Uo).reduce(function (e, n) {
                var r = Uo[n],
                    o = r(t);
                return null !== o ? Ro({}, e, U({}, n, o)) : e
            }, {})
        },
        Yo = function (e) {
            return Object.keys(zo).reduce(function (t, n) {
                var r = zo[n],
                    o = r(e);
                return null !== o ? Ro({}, t, U({}, n, o)) : t
            }, {})
        },
        Wo = function (e) {
            return "string" == typeof e ? e : null
        },
        Go = function (e) {
            return e ? Wo(e.phoneNumber) : null
        },
        Vo = function (e) {
            return e ? Wo(e.emailAddress) : null
        },
        Ko = function (e) {
            return e ? [e.givenName, e.familyName].filter(function (e) {
                return e && "string" == typeof e
            }).join(" ") : null
        },
        $o = function (e) {
            var t = e.addressLines,
                n = e.countryCode,
                r = e.postalCode,
                o = e.administrativeArea,
                i = e.locality,
                a = e.phoneNumber,
                s = Wo(n);
            return {
                addressLine: Array.isArray(t) ? t.reduce(function (e, t) {
                    return "string" == typeof t ? [].concat(z(e), [t]) : e
                }, []) : [],
                country: s ? s.toUpperCase() : "",
                postalCode: Wo(r) || "",
                recipient: Ko(e) || "",
                region: Wo(o) || "",
                city: Wo(i) || "",
                phone: Wo(a) || "",
                sortingCode: "",
                dependentLocality: "",
                organization: ""
            }
        },
        Jo = function (e, t) {
            var n = e.identifier,
                r = e.label;
            return t.filter(function (e) {
                return e.id === n && e.label === r
            })[0]
        },
        Qo = function (e, t) {
            var n = e.shippingContact,
                r = e.shippingMethod,
                o = e.billingContact;
            return {
                shippingOption: r && t.shippingOptions && t.shippingOptions.length ? Jo(r, t.shippingOptions) : null,
                shippingAddress: n ? $o(n) : null,
                payerEmail: Vo(n),
                payerPhone: Go(n),
                payerName: Ko(o),
                methodName: "apple-pay"
            }
        },
        Zo = Qo,
        Xo = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        ei = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        ti = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        ni = {
            australia: "AU",
            austria: "AT",
            canada: "CA",
            schweiz: "CH",
            deutschland: "DE",
            hongkong: "HK",
            saudiarabia: "SA",
            espaa: "ES",
            singapore: "SG",
            us: "US",
            usa: "US",
            unitedstatesofamerica: "US",
            unitedstates: "US",
            england: "GB",
            gb: "GB",
            uk: "GB",
            unitedkingdom: "GB"
        },
        ri = function (e, t) {
            return e && "object" === (void 0 === e ? "undefined" : ti(e)) ? t(e) : null
        },
        oi = function () {
            function e(t) {
                var n = this;
                H(this, e), this._onEvent = function () {}, this.setEventHandler = function (e) {
                    n._onEvent = e
                }, this.canMakePayment = function () {
                    return So(window.location.hostname, n._authentication.accountId, ze(n._authentication.apiKey) === Ue.test, n._report, n._minimumVersion)
                }, this.update = function (e) {
                    n._initialPaymentRequest = Ne(n._paymentRequestOptions, e), n._initializeSessionState()
                }, this.show = function () {
                    n._initializeSessionState();
                    var e = void 0;
                    try {
                        e = new window.ApplePaySession(n._minimumVersion, Ho(n._paymentRequestOptions))
                    } catch (e) {
                        throw "Must create a new ApplePaySession from a user gesture handler." === e.message ? new we("show() must be called from a user gesture handler (such as a click handler, after the user clicks a button).") : e
                    }
                    n._privateSession = e, n._setupSession(e, n._usesButtonElement()), e.begin(), n._isShowing = !0
                }, this.abort = function () {
                    n._privateSession && n._privateSession.abort()
                }, this._warn = function (e) {}, this._report = function (e, t) {
                    n._controller.report(e, Xo({}, t, {
                        backingLibrary: "APPLE_PAY",
                        usesButtonElement: n._usesButtonElement()
                    }))
                }, this._validateMerchant = function (e, t) {
                    return function (r) {
                        n._controller.action.createApplePaySession({
                            data: {
                                validation_url: r.validationURL,
                                domain_name: window.location.hostname,
                                display_name: n._paymentRequestOptions.total.label
                            },
                            usesButtonElement: t
                        }).then(function (t) {
                            if (n._isShowing) switch (t.type) {
                                case "object":
                                    e.completeMerchantValidation(JSON.parse(t.object.session));
                                    break;
                                case "error":
                                    n._handleValidationError(e)(t.error);
                                    break;
                                default:
                                    Ee(t)
                            }
                        }, n._handleValidationError(e))
                    }
                }, this._handleValidationError = function (e) {
                    return function (t) {
                        n._report("error.pr.apple_pay.session_creation_failed", {
                            error: t
                        }), e.abort();
                        var r = t.message;
                        "string" == typeof r && n._controller.warn(r)
                    }
                }, this._paymentAuthorized = function (e) {
                    return function (t) {
                        var r = t.payment,
                            o = n._usesButtonElement() ? Mt.paymentRequestButton : null;
                        n._controller.action.tokenizeWithData({
                            type: "apple_pay",
                            elementName: o,
                            tokenData: Xo({}, r, {
                                billingContact: ri(r.billingContact, n._normalizeContact)
                            }),
                            mids: n._mids
                        }).then(function (t) {
                            if ("error" === t.type) e.completePayment(window.ApplePaySession.STATUS_FAILURE), n._report("error.pr.create_token_failed", {
                                error: t.error
                            });
                            else {
                                var o = ri(r.shippingContact, n._normalizeContact),
                                    i = ri(r.billingContact, n._normalizeContact);
                                o && n._paymentRequestOptions.requestShipping && !o.countryCode && e.completePayment(window.ApplePaySession.STATUS_INVALID_SHIPPING_POSTAL_ADDRESS);
                                var a = Zo({
                                    shippingContact: o,
                                    billingContact: i
                                }, n._paymentRequestOptions);
                                n._onToken(e)(Xo({}, a, {
                                    shippingOption: n._privateShippingOption,
                                    token: t.object
                                }))
                            }
                        })
                    }
                }, this._normalizeContact = function (e) {
                    if (e.country && "string" == typeof e.country) {
                        var t = e.country.toLowerCase().replace(/[^a-z]+/g, ""),
                            r = void 0;
                        return e.countryCode ? "string" == typeof e.countryCode && (r = e.countryCode.toUpperCase()) : (r = ni[t]) || n._report("warn.pr.apple_pay.missing_country_code", {
                            country: e.country
                        }), Xo({}, e, {
                            countryCode: r
                        })
                    }
                    return e
                }, this._onToken = function (e) {
                    return function (t) {
                        n._onEvent({
                            type: "paymentresponse",
                            payload: Xo({}, t, {
                                complete: n._completePayment(e)
                            })
                        })
                    }
                }, this._completePayment = function (e) {
                    return function (t) {
                        n._paymentRequestOptions = Ne(n._paymentRequestOptions, {
                            status: t
                        });
                        var r = Yo(n._paymentRequestOptions),
                            o = r.status;
                        e.completePayment(o), -1 === [window.ApplePaySession.STATUS_INVALID_BILLING_POSTAL_ADDRESS, window.ApplePaySession.STATUS_INVALID_SHIPPING_POSTAL_ADDRESS, window.ApplePaySession.STATUS_INVALID_SHIPPING_CONTACT].indexOf(o) && (n._isShowing = !1, n._onEvent && n._onEvent({
                            type: "close"
                        }))
                    }
                }, this._shippingContactSelected = function (e) {
                    return function (t) {
                        n._onEvent({
                            type: "shippingaddresschange",
                            payload: {
                                shippingAddress: $o(n._normalizeContact(t.shippingContact)),
                                updateWith: n._completeShippingContactSelection(e)
                            }
                        })
                    }
                }, this._completeShippingContactSelection = function (e) {
                    return function (t) {
                        n._paymentRequestOptions = Ne(n._paymentRequestOptions, t), n._paymentRequestOptions.shippingOptions && n._paymentRequestOptions.shippingOptions.length && (n._privateShippingOption = n._paymentRequestOptions.shippingOptions[0]);
                        var r = Yo(n._paymentRequestOptions),
                            o = r.status,
                            i = r.shippingMethods,
                            a = r.total,
                            s = r.lineItems;
                        e.completeShippingContactSelection(o, i, a, s)
                    }
                }, this._shippingMethodSelected = function (e) {
                    return function (t) {
                        if (n._paymentRequestOptions.shippingOptions) {
                            var r = Jo(t.shippingMethod, n._paymentRequestOptions.shippingOptions);
                            n._privateShippingOption = r, n._onEvent({
                                type: "shippingoptionchange",
                                payload: {
                                    shippingOption: r,
                                    updateWith: n._completeShippingMethodSelection(e)
                                }
                            })
                        }
                    }
                }, this._completeShippingMethodSelection = function (e) {
                    return function (t) {
                        n._paymentRequestOptions = Ne(n._paymentRequestOptions, t);
                        var r = Yo(n._paymentRequestOptions),
                            o = r.status,
                            i = r.total,
                            a = r.lineItems;
                        e.completeShippingMethodSelection(o, i, a)
                    }
                };
                var r = t.controller,
                    o = t.authentication,
                    i = t.mids,
                    a = t.options,
                    s = t.usesButtonElement;
                this._controller = r, this._authentication = o, this._mids = i, this._minimumVersion = a.__minApplePayVersion || Eo, this._usesButtonElement = s, this._initialPaymentRequest = a, this._isShowing = !1, this._initializeSessionState()
            }
            return ei(e, [{
                key: "_initializeSessionState",
                value: function () {
                    this._paymentRequestOptions = Xo({}, oo, this._initialPaymentRequest, {
                        status: ro.success
                    }), this._privateSession = null, this._privateShippingOption = null;
                    var e = this._paymentRequestOptions.shippingOptions;
                    e && e.length && (this._privateShippingOption = e[0])
                }
            }, {
                key: "_setupSession",
                value: function (e, t) {
                    var n = this;
                    e.addEventListener("validatemerchant", sn(this._validateMerchant(e, t))), e.addEventListener("paymentauthorized", sn(this._paymentAuthorized(e))), e.addEventListener("cancel", sn(function () {
                        n._isShowing = !1, n._onEvent({
                            type: "cancel"
                        }), n._onEvent({
                            type: "close"
                        })
                    })), e.addEventListener("shippingcontactselected", sn(this._shippingContactSelected(e))), e.addEventListener("shippingmethodselected", sn(this._shippingMethodSelected(e)))
                }
            }]), e
        }(),
        ii = oi,
        ai = null,
        si = function (e) {
            return null !== ai ? Pe.resolve(ai) : e().then(function (e) {
                return ai = e
            })
        },
        ci = si,
        ui = function () {
            return "https:" === window.location.protocol && !(!_r && !mr)
        },
        li = ui,
        pi = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        fi = function e(t) {
            var n = this;
            Y(this, e), this._mids = null, this._frame = null, this._backdrop = new Fn({
                lockScrolling: !1,
                lockFocus: !0,
                lockFocusOn: null
            }), this._initFrame = function (e) {
                var t = n._controller.createHiddenFrame(Tt.PAYMENT_REQUEST_GOOGLE_PAY, {
                    authentication: n._authentication,
                    mids: n._mids
                });
                t.send({
                    action: "stripe-pr-initialize",
                    payload: {
                        data: e
                    }
                }), n._initFrameEventHandlers(t), n._frame = t
            }, this._initFrameEventHandlers = function (e) {
                e._on("pr-cancel", function () {
                    n._onEvent({
                        type: "cancel"
                    })
                }), e._on("pr-close", function () {
                    n._backdrop.fadeOut().then(function () {
                        n._backdrop.unmount()
                    }), n._onEvent({
                        type: "close"
                    })
                }), e._on("pr-error", function (e) {
                    n._onEvent({
                        type: "error",
                        payload: {
                            errorMessage: e.errorMessage,
                            errorCode: e.errorCode
                        }
                    })
                }), e._on("pr-callback", function (t) {
                    var r = t.event,
                        o = t.options,
                        i = t.nonce;
                    switch (r) {
                        case "paymentresponse":
                            n._handlePaymentResponse(e, o, i);
                            break;
                        case "shippingaddresschange":
                            n._handleShippingAddressChange(e, o, i);
                            break;
                        case "shippingoptionchange":
                            n._handleShippingOptionChange(e, o, i);
                            break;
                        default:
                            throw new Error("Unexpected event name: " + r)
                    }
                })
            }, this._handlePaymentResponse = function (e, t, r) {
                var o = function (t) {
                    e.send({
                        action: "stripe-pr-callback-complete",
                        payload: {
                            nonce: r,
                            data: {
                                status: t
                            }
                        }
                    })
                };
                n._onEvent({
                    type: "paymentresponse",
                    payload: pi({}, t, {
                        complete: o
                    })
                })
            }, this._handleShippingAddressChange = function (e, t, r) {
                var o = function (t) {
                    e.send({
                        action: "stripe-pr-callback-complete",
                        payload: {
                            nonce: r,
                            data: t
                        }
                    })
                };
                n._onEvent({
                    type: "shippingaddresschange",
                    payload: pi({}, t, {
                        updateWith: o
                    })
                })
            }, this._handleShippingOptionChange = function (e, t, r) {
                var o = function (t) {
                    e.send({
                        action: "stripe-pr-callback-complete",
                        payload: {
                            nonce: r,
                            data: t
                        }
                    })
                };
                n._onEvent({
                    type: "shippingoptionchange",
                    payload: pi({}, t, {
                        updateWith: o
                    })
                })
            }, this.setEventHandler = function (e) {
                n._onEvent = e
            }, this.canMakePayment = function () {
                if (!li()) return Pe.resolve(!1);
                if (!n._frame) throw new Error("Frame not initialized.");
                var e = n._frame;
                return ci(function () {
                    return e.action(Xr.CAN_MAKE_PAYMENT).then(function (e) {
                        return !0 === e.available
                    })
                })
            }, this.show = function () {
                n._frame && (n._frame.send({
                    action: "stripe-pr-show",
                    payload: {
                        data: {
                            usesButtonElement: n._usesButtonElement()
                        }
                    }
                }), n._backdrop.mount(), n._backdrop.show(), n._backdrop.fadeIn())
            }, this.update = function (e) {
                n._frame && n._frame.send({
                    action: "stripe-pr-update",
                    payload: {
                        data: e
                    }
                })
            }, this.abort = function () {
                n._frame && n._frame.send({
                    action: "stripe-pr-abort",
                    payload: {}
                })
            }, this._controller = t.controller, this._authentication = t.authentication, this._mids = t.mids, this._usesButtonElement = t.usesButtonElement, li() && this._controller && (this._controller.action.fetchLocale({
                locale: "auto"
            }), this._initFrame(t.options))
        },
        di = fi,
        hi = function () {
            if (!window.PaymentRequest) return null;
            if (/CriOS\/59/.test(navigator.userAgent)) return null;
            if (/.*\(.*; wv\).*Chrome\/(?:53|54)\.\d.*/g.test(navigator.userAgent)) return null;
            if (hr) return null;
            var e = window.PaymentRequest;
            return e.prototype.canMakePayment || (e.prototype.canMakePayment = function () {
                return Pe.resolve(!1)
            }), e
        }(),
        _i = null,
        mi = function (e, t) {
            return null !== _i ? Pe.resolve(_i) : hi ? t && "https:" !== window.location.protocol ? (window.console && window.console.warn("To test Payment Request, you must serve this page over HTTPS."), Pe.resolve(!1)) : e ? e.action(Xr.CAN_MAKE_PAYMENT).then(function (e) {
                var t = e.available;
                return _i = !0 === t
            }) : Pe.resolve(!1) : Pe.resolve(!1)
        },
        yi = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        vi = function e(t) {
            W(this, e), bi.call(this);
            var n = t.authentication,
                r = t.controller,
                o = t.mids,
                i = t.usesButtonElement,
                a = t.options;
            if (this._authentication = n, this._controller = r, this._mids = o, this._usesButtonElement = i, hi && "https:" === window.location.protocol) {
                this._controller.action.fetchLocale({
                    locale: "auto"
                });
                var s = this._controller.createHiddenFrame(Tt.PAYMENT_REQUEST_BROWSER, {
                    authentication: n,
                    mids: this._mids
                });
                this._setupPrFrame(s, a), this._prFrame = s
            } else this._prFrame = null
        },
        bi = function () {
            var e = this;
            this._onEvent = function () {}, this.setEventHandler = function (t) {
                e._onEvent = t
            }, this.canMakePayment = function () {
                return mi(e._prFrame, ze(e._authentication.apiKey) === Ue.test)
            }, this.update = function (t) {
                var n = e._prFrame;
                n && n.send({
                    action: "stripe-pr-update",
                    payload: {
                        data: t
                    }
                })
            }, this.show = function () {
                if (!e._prFrame) throw new we("Payment Request is not available in this browser.");
                e._prFrame.send({
                    action: "stripe-pr-show",
                    payload: {
                        data: {
                            usesButtonElement: e._usesButtonElement()
                        }
                    }
                })
            }, this.abort = function () {
                e._prFrame && e._prFrame.send({
                    action: "stripe-pr-abort",
                    payload: {}
                })
            }, this._setupPrFrame = function (t, n) {
                t.send({
                    action: "stripe-pr-initialize",
                    payload: {
                        data: n
                    }
                }), t._on("pr-cancel", function () {
                    e._onEvent({
                        type: "cancel"
                    })
                }), t._on("pr-close", function () {
                    e._onEvent({
                        type: "close"
                    })
                }), t._on("pr-error", function (t) {
                    e._onEvent({
                        type: "error",
                        payload: {
                            errorMessage: t.message || "",
                            errorCode: t.code || ""
                        }
                    })
                }), t._on("pr-callback", function (n) {
                    var r = n.event,
                        o = n.nonce,
                        i = n.options;
                    switch (r) {
                        case "token":
                            e._onEvent({
                                type: "paymentresponse",
                                payload: yi({}, i, {
                                    complete: function (e) {
                                        t.send({
                                            action: "stripe-pr-callback-complete",
                                            payload: {
                                                data: {
                                                    status: e
                                                },
                                                nonce: o
                                            }
                                        })
                                    }
                                })
                            });
                            break;
                        case "shippingaddresschange":
                            e._onEvent({
                                type: "shippingaddresschange",
                                payload: {
                                    shippingAddress: i.shippingAddress,
                                    updateWith: function (e) {
                                        t.send({
                                            action: "stripe-pr-callback-complete",
                                            payload: {
                                                nonce: o,
                                                data: e
                                            }
                                        })
                                    }
                                }
                            });
                            break;
                        case "shippingoptionchange":
                            e._onEvent({
                                type: "shippingoptionchange",
                                payload: {
                                    shippingOption: i.shippingOption,
                                    updateWith: function (e) {
                                        t.send({
                                            action: "stripe-pr-callback-complete",
                                            payload: {
                                                nonce: o,
                                                data: e
                                            }
                                        })
                                    }
                                }
                            });
                            break;
                        default:
                            throw new Error("Unexpected event from PaymentRequest inner: " + r)
                    }
                })
            }
        },
        gi = vi,
        wi = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Ei = function (e) {
            function t(e) {
                K(this, t);
                var n = $(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
                ki.call(n), n._controller = e.controller, n._authentication = e.authentication, n._mids = e.mids, n._report("pr.options", {
                    options: e.rawOptions
                });
                var r = wt(lo, e.rawOptions || {}, "paymentRequest()"),
                    o = r.value;
                if (r.warnings.forEach(function (e) {
                        return n._warn(e)
                    }), o.__billingDetailsEmailOverride && o.requestPayerEmail) throw new we("When providing `__billingDetailsEmailOverride`, `requestPayerEmail` has to be `false` so that the customer is not prompted for their email in the payment sheet.");
                return n._queryStrategy = e.queryStrategyOverride || go(e.betas), n._report("pr.query_strategy", {
                    queryStrategy: n._queryStrategy
                }), n._initialOptions = wi({}, o, {
                    __skipGooglePayInPaymentRequest: -1 !== n._queryStrategy.indexOf("GOOGLE_PAY")
                }), n._initBackingLibraries(n._initialOptions), n
            }
            return J(t, e), t
        }(fn),
        ki = function () {
            var e = this;
            this._usedByButtonElement = null, this._showCalledByButtonElement = !1, this._isShowing = !1, this._backingLibraries = {
                APPLE_PAY: null,
                GOOGLE_PAY: null,
                BROWSER: null
            }, this._activeBackingLibraryName = null, this._activeBackingLibrary = null, this._canMakePaymentAvailability = {
                APPLE_PAY: null,
                GOOGLE_PAY: null,
                BROWSER: null
            }, this._canMakePaymentResolved = !1, this._validateUserOn = function (t, n) {
                "string" == typeof t && ("source" === t && e._hasRegisteredListener("paymentmethod") || "paymentmethod" === t && e._hasRegisteredListener("source")) && (e._report("pr.double_callback_registration"), e._controller.warn("Do not register event listeners for both `source` or `paymentmethod`. Only one of them will succeed."))
            }, this._report = function (t, n) {
                e._controller.report(t, wi({}, n, {
                    activeBackingLibrary: e._activeBackingLibraryName,
                    usesButtonElement: e._usedByButtonElement
                }))
            }, this._warn = function (t) {
                e._controller.warn(t)
            }, this._registerElement = function () {
                e._usedByButtonElement = !0
            }, this._elementShow = function () {
                e._showCalledByButtonElement = !0, e.show()
            }, this._initBackingLibraries = function (t) {
                e._queryStrategy.forEach(function (n) {
                    var r = {
                        controller: e._controller,
                        authentication: e._authentication,
                        mids: e._mids,
                        options: t,
                        usesButtonElement: function () {
                            return !0 === e._usedByButtonElement
                        }
                    };
                    switch (n) {
                        case "APPLE_PAY":
                            e._backingLibraries.APPLE_PAY = new ii(r), e._backingLibraries.APPLE_PAY.setEventHandler(e._handleInternalEvent);
                            break;
                        case "GOOGLE_PAY":
                            e._backingLibraries.GOOGLE_PAY = new di(r), e._backingLibraries.GOOGLE_PAY.setEventHandler(e._handleInternalEvent);
                            break;
                        case "BROWSER":
                            e._backingLibraries.BROWSER = new gi(r), e._backingLibraries.BROWSER.setEventHandler(e._handleInternalEvent);
                            break;
                        default:
                            Ee(n)
                    }
                })
            }, this._handleInternalEvent = function (t) {
                switch (t.type) {
                    case "paymentresponse":
                        e._emitPaymentResponse(t.payload);
                        break;
                    case "error":
                        e._report("error.pr.internal_error", {
                            error: t.payload
                        });
                        break;
                    case "close":
                        e._isShowing = !1;
                        break;
                    default:
                        e._emitExternalEvent(t)
                }
            }, this._emitExternalEvent = function (t) {
                switch (t.type) {
                    case "cancel":
                        e._emit("cancel");
                        break;
                    case "shippingoptionchange":
                    case "shippingaddresschange":
                        var n = t.type,
                            r = t.payload,
                            o = null,
                            i = !1,
                            a = !1,
                            s = function (s) {
                                if (a && i) return e._report("pr.update_with_called_after_timeout", {
                                    event: n
                                }), void e._controller.warn("Call to updateWith() was ignored because it has already timed out. Please ensure that updateWith is called within 30 seconds.");
                                if (i) return e._report("pr.update_with_double_call", {
                                    event: n
                                }), void e._controller.warn("Call to updateWith() was ignored because it has already been called. Do not call updateWith more than once.");
                                o && clearTimeout(o), i = !0, e._report("pr.update_with", {
                                    event: n,
                                    updates: s
                                });
                                var c = wt(ho, s || {}, n + " callback"),
                                    u = c.value;
                                c.warnings.forEach(function (t) {
                                    return e._controller.warn(t)
                                });
                                var l = u.shippingOptions || e._initialOptions.shippingOptions;
                                if (!("shippingaddresschange" !== t.type || u.status !== ro.success || l && l.length)) throw new we("When requesting shipping information, you must specify shippingOptions once a shipping address is selected.\nEither provide shippingOptions in stripe.paymentRequest(...) or listen for the shippingaddresschange event and provide shippingOptions to the updateWith callback there.");
                                r.updateWith(u)
                            };
                        e._hasRegisteredListener(t.type) ? (o = setTimeout(function () {
                            a = !0, e._report("pr.update_with_timed_out", {
                                event: n
                            }), e._controller.warn('Timed out waiting for a call to updateWith(). If you listen to "' + t.type + '" events, then you must call event.updateWith in the "' + t.type + '" handler within 30 seconds.'), s({
                                status: "fail"
                            })
                        }, 29900), e._emit(n, wi({}, r, {
                            updateWith: s
                        }))) : s({
                            status: "success"
                        });
                        break;
                    case "token":
                    case "source":
                    case "paymentmethod":
                        var c = t.type,
                            u = t.payload,
                            l = null,
                            p = !1,
                            f = !1,
                            d = function (t) {
                                if (p && f) return e._report("pr.complete_called_after_timeout"), void e._controller.warn("Call to complete() was ignored because it has already timed out. Please ensure that complete is called within 30 seconds.");
                                if (f) return e._report("pr.complete_double_call"), void e._controller.warn("Call to complete() was ignored because it has already been called. Do not call complete more than once.");
                                l && clearTimeout(l), f = !0;
                                var n = wt(_o, t, "status for PaymentRequest completion"),
                                    r = n.value;
                                n.warnings.forEach(function (t) {
                                    return e._controller.warn(t)
                                }), u.complete(r)
                            };
                        l = setTimeout(function () {
                            p = !0, e._report("pr.complete_timed_out"), e._controller.warn('Timed out waiting for a call to complete(). Once you have processed the payment in the "' + t.type + '" handler, you must call event.complete within 30 seconds.'), d("fail")
                        }, 29900), e._emit(c, wi({}, u, {
                            complete: d
                        }));
                        break;
                    default:
                        Ee(t)
                }
            }, this._maybeEmitPaymentResponse = function (t) {
                e._isShowing && e._emitExternalEvent(t)
            }, this._emitPaymentResponse = function (t) {
                e._report("pr.payment_authorized");
                var n = t.__googlePayBillingAddress,
                    r = V(t, ["__googlePayBillingAddress"]),
                    o = r.token,
                    i = V(r, ["token"]),
                    a = i.payerEmail,
                    s = i.payerPhone,
                    c = i.complete,
                    u = e._showCalledByButtonElement ? Mt.paymentRequestButton : null;
                e._hasRegisteredListener("token") && e._maybeEmitPaymentResponse({
                    type: "token",
                    payload: r
                }), e._hasRegisteredListener("source") && e._controller.action.createSourceWithData({
                    elementName: u,
                    type: "card",
                    sourceData: {
                        token: o.id,
                        owner: wi({
                            email: e._initialOptions.__billingDetailsEmailOverride || a,
                            phone: s
                        }, n ? {
                            address: n
                        } : {})
                    },
                    mids: null
                }).then(function (t) {
                    "error" === t.type ? (e._report("fatal.pr.token_to_source_failed", {
                        error: t.error,
                        token: o.id
                    }), c("fail")) : e._maybeEmitPaymentResponse({
                        type: "source",
                        payload: wi({}, i, {
                            source: t.object
                        })
                    })
                }), e._hasRegisteredListener("paymentmethod") && e._controller.action.createPaymentMethodWithData({
                    elementName: u,
                    type: "card",
                    paymentMethodData: {
                        card: {
                            token: o.id
                        },
                        billing_details: wi({
                            email: e._initialOptions.__billingDetailsEmailOverride || a,
                            phone: s
                        }, n ? {
                            address: n
                        } : {})
                    },
                    mids: null
                }).then(function (t) {
                    "error" === t.type ? (e._report("fatal.pr.token_to_payment_method_failed", {
                        error: t.error,
                        token: o.id
                    }), c("fail")) : e._maybeEmitPaymentResponse({
                        type: "paymentmethod",
                        payload: wi({}, i, {
                            paymentMethod: t.object
                        })
                    })
                })
            }, this._canMakePaymentForBackingLibrary = function (t) {
                var n = e._backingLibraries[t];
                if (!n) throw new Error("Unexpectedly calling canMakePayment on uninitialized backing library.");
                return Pe.race([new Pe(function (e) {
                    return setTimeout(e, 1e4)
                }).then(function () {
                    return !1
                }), n.canMakePayment().then(function (e) {
                    return !!e
                })]).then(function (n) {
                    return e._canMakePaymentAvailability = wi({}, e._canMakePaymentAvailability, G({}, t, n)), {
                        backingLibraryName: t,
                        available: n
                    }
                })
            }, this._constructCanMakePaymentResponse = function () {
                return wi({
                    applePay: !!e._canMakePaymentAvailability.APPLE_PAY
                }, -1 !== e._queryStrategy.indexOf("GOOGLE_PAY") ? {
                    googlePay: !!e._canMakePaymentAvailability.GOOGLE_PAY
                } : {})
            }, this.canMakePayment = sn(function () {
                if (e._report("pr.can_make_payment"), e._canMakePaymentResolved) {
                    var t = null !== e._activeBackingLibrary ? e._constructCanMakePaymentResponse() : null;
                    return e._report("pr.can_make_payment_response", {
                        response: t,
                        cached: !0
                    }), Pe.resolve(t)
                }
                if ("https:" !== window.location.protocol) return e._canMakePaymentResolved = !0, Pe.resolve(null);
                var n = e._queryStrategy.map(function (t) {
                        return function () {
                            return e._canMakePaymentForBackingLibrary(t)
                        }
                    }),
                    r = Date.now();
                return Qr(n, function (t) {
                    var n = t.backingLibraryName,
                        r = t.available;
                    return r && (e._activeBackingLibraryName = n, e._activeBackingLibrary = e._backingLibraries[n]), r
                }).then(function (t) {
                    var n = Date.now();
                    e._canMakePaymentResolved = !0;
                    var o = null;
                    return "SATISFIED" === t.type && (o = e._constructCanMakePaymentResponse()), e._report("pr.can_make_payment_response", {
                        response: o,
                        cached: !1,
                        duration: n - r
                    }), o
                })
            }), this.update = sn(function (t) {
                if (e._isShowing) throw e._report("pr.update_called_while_showing"), new we("You cannot update Payment Request options while the payment sheet is showing.");
                e._report("pr.update", {
                    updates: t
                });
                var n = wt(po, t, "PaymentRequest update()"),
                    r = n.value;
                n.warnings.forEach(function (t) {
                    return e._warn(t)
                }), e._activeBackingLibrary && e._activeBackingLibrary.update(r)
            }), this.show = sn(function () {
                if (e._usedByButtonElement && !e._showCalledByButtonElement && (e._report("pr.show_called_with_button"), e._warn("Do not call show() yourself if you are using the paymentRequestButton Element. The Element handles showing the payment sheet.")), !e._canMakePaymentResolved) throw e._report("pr.show_called_before_can_make_payment"), new we("You must first check the Payment Request API's availability using paymentRequest.canMakePayment() before calling show().");
                if (!e._activeBackingLibrary) throw e._report("pr.show_called_with_can_make_payment_false"), new we("Payment Request is not available in this browser.");
                var t = e._activeBackingLibrary;
                e._report("pr.show", {
                    listeners: Object.keys(e._callbacks).sort()
                }), e._isShowing = !0, t.show()
            }), this.abort = sn(function () {
                if (e._activeBackingLibrary) {
                    var t = e._activeBackingLibrary;
                    e._report("pr.abort"), t.abort()
                }
            })
        },
        Si = Ei,
        Oi = {
            base: Qe(dt),
            complete: Qe(dt),
            empty: Qe(dt),
            invalid: Qe(dt),
            paymentRequestButton: Qe(dt)
        },
        Pi = {
            classes: Qe(bt({
                base: Qe(it),
                complete: Qe(it),
                empty: Qe(it),
                focus: Qe(it),
                invalid: Qe(it),
                webkitAutofill: Qe(it)
            })),
            hidePostalCode: Qe(st),
            hideIcon: Qe(st),
            style: Qe(bt(Oi)),
            iconStyle: Qe(tt("solid", "default")),
            value: Qe(Ze(it, dt)),
            __privateCvcOptional: Qe(st),
            __privateValue: Qe(Ze(it, dt)),
            __privateEmitIbanValue: Qe(st),
            error: Qe(bt({
                type: it,
                code: Qe(it),
                decline_code: Qe(it),
                param: Qe(it)
            })),
            locale: mt("elements()"),
            fonts: mt("elements()"),
            placeholder: Qe(it),
            disabled: Qe(st),
            placeholderCountry: Qe(it),
            paymentRequest: Qe(function (e, t) {
                return function (n, r) {
                    return n instanceof e ? Ve(n) : Je("a " + t + " instance", n, r)
                }
            }(Si, "stripe.paymentRequest(...)")),
            supportedCountries: Qe(ht(it))
        },
        Ai = bt(Pi),
        Ti = function (e, t) {
            if (!(e && e in vr)) throw new we("A valid Element name must be provided. Valid Elements are:\n" + Object.keys(vr).filter(function (e) {
                return !vr[e].beta
            }).join(", ") + "; you passed: " + e + ".");
            if (vr[e].unique && -1 !== t.indexOf(e)) throw new we("Can only create one Element of type " + e + ".");
            var n = vr[e].conflict,
                r = qe(t, n);
            if (r.length) {
                var o = r[0];
                throw new we("Cannot create an Element of type " + e + " after an Element of type " + o + " has already been created.")
            }
        },
        Ii = "14px",
        ji = function (e) {
            var t = e.split(" ").map(function (e) {
                return parseInt(e.trim(), 10)
            });
            return 1 === t.length || 2 === t.length ? 2 * t[0] : 3 === t.length || 4 === t.length ? t[0] + t[2] : 0
        },
        Ci = function () {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : "1.2em",
                t = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : Ii,
                n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "0",
                r = ji(n);
            if ("string" == typeof e && /^[0-9.]+px$/.test(e)) {
                return parseFloat(e.toString().replace(/[^0-9.]/g, "")) + r + "px"
            }
            var o = parseFloat(e.toString().replace(/[^0-9.]/g, "")),
                i = parseFloat(Ii.replace(/[^0-9.]/g, "")),
                a = parseFloat(t.toString().replace(/[^0-9.]/g, "")),
                s = void 0;
            if ("string" == typeof t && /^(\d+|\d*\.\d+)px$/.test(t)) s = a;
            else if ("string" == typeof t && /^(\d+|\d*\.\d+)em$/.test(t)) s = a * i;
            else if ("string" == typeof t && /^(\d+|\d*\.\d+)%$/.test(t)) s = a / 100 * i;
            else {
                if ("string" != typeof t || !/^[\d.]+$/.test(t) && !/^\d*\.(px|em|%)$/.test(t)) return "100%";
                s = i
            }
            var c = o * s + r,
                u = c + "px";
            return /^[0-9.]+px$/.test(u) ? u : "100%"
        },
        Ri = Ci,
        Mi = function (e, t) {
            return e ? window.getComputedStyle(e, t) : null
        },
        Ni = Mi,
        qi = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Li = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        Di = {
            base: "StripeElement",
            focus: "StripeElement--focus",
            invalid: "StripeElement--invalid",
            complete: "StripeElement--complete",
            empty: "StripeElement--empty",
            webkitAutofill: "StripeElement--webkit-autofill"
        },
        xi = {
            margin: "0",
            padding: "0",
            border: "none",
            display: "block",
            background: "transparent",
            position: "relative",
            opacity: "1"
        },
        Fi = {
            border: "none",
            display: "block",
            position: "absolute",
            height: "1px",
            top: "0",
            left: "0",
            padding: "0",
            margin: "0",
            width: "100%",
            opacity: "0",
            background: "transparent",
            "pointer-events": "none",
            "font-size": "16px"
        },
        Bi = function (e) {
            return parseFloat(e.toFixed(1))
        },
        Ui = function (e) {
            return /^\d+(\.\d*)?px$/.test(e)
        },
        zi = function (e) {
            function t(e) {
                X(this, t);
                var n = ee(this, (t.__proto__ || Object.getPrototypeOf(t)).call(this));
                Hi.call(n);
                var r = e.controller,
                    o = e.componentName,
                    i = e.paymentRequest;
                n._controller = r, n._componentName = o;
                var a = "paymentRequestButton" === n._componentName;
                if (a) {
                    if (!i) throw new we("You must pass in a stripe.paymentRequest object in order to use this Element.");
                    n._paymentRequest = i, n._paymentRequest._registerElement()
                }
                return n._createComponent(e, o), n._classes = Di, n._changeClasses(e.classes || {}), n._lastBackgroundColor = "", n._destroyed = !1, n._focused = !1, n._empty = !a, n._invalid = !1, n._complete = !1, n._autofilled = !1, n._lastSubmittedAt = null, n
            }
            return te(t, e), Li(t, [{
                key: "_checkDestroyed",
                value: function () {
                    if (this._destroyed) throw new we("This Element has already been destroyed. Please create a new one.")
                }
            }, {
                key: "_isMounted",
                value: function () {
                    return !!document.body && document.body.contains(this._component)
                }
            }, {
                key: "_mountToParent",
                value: function (e) {
                    var t = this._component.parentElement,
                        n = this._isMounted();
                    if (e === t) {
                        if (n) return;
                        this.unmount(), this._mountTo(e)
                    } else if (t) {
                        if (n) throw new we("This Element is already mounted. Use `unmount()` to unmount the Element before re-mounting.");
                        this.unmount(), this._mountTo(e)
                    } else this._mountTo(e)
                }
            }, {
                key: "_mountTo",
                value: function (e) {
                    var t = Date.now(),
                        n = Ni(e, null),
                        r = !!n && "rtl" === n.getPropertyValue("direction"),
                        o = this._paymentRequest ? this._paymentRequest._activeBackingLibraryName : null;
                    for (this._parent = e; e.firstChild;) e.removeChild(e.firstChild);
                    e.appendChild(this._component), this._frame.send({
                        action: "stripe-user-mount",
                        payload: {
                            mountTime: t,
                            rtl: r,
                            paymentRequestButtonType: o
                        }
                    }), this._findPossibleLabel(), this._updateClasses()
                }
            }, {
                key: "_updateClasses",
                value: function () {
                    this._parent && Zt(this._parent, [
                        [this._classes.base, !0],
                        [this._classes.empty, this._empty],
                        [this._classes.focus, this._focused],
                        [this._classes.invalid, this._invalid],
                        [this._classes.complete, this._complete],
                        [this._classes.webkitAutofill, this._autofilled]
                    ])
                }
            }, {
                key: "_removeClasses",
                value: function () {
                    this._parent && Zt(this._parent, [
                        [this._classes.base, !1],
                        [this._classes.empty, !1],
                        [this._classes.focus, !1],
                        [this._classes.invalid, !1],
                        [this._classes.complete, !1],
                        [this._classes.webkitAutofill, !1]
                    ])
                }
            }, {
                key: "_findPossibleLabel",
                value: function () {
                    var e = this._parent;
                    if (e) {
                        var t = e.getAttribute("id"),
                            n = void 0;
                        if (t && (n = document.querySelector("label[for='" + t + "']")), n) e.addEventListener("click", this.focus);
                        else
                            for (n = n || e.parentElement; n && "LABEL" !== n.nodeName;) n = n.parentElement;
                        n ? (this._label = n, n.addEventListener("click", this.focus)) : e.addEventListener("click", this.focus)
                    }
                }
            }, {
                key: "_changeClasses",
                value: function (e) {
                    var t = {};
                    return Object.keys(e).forEach(function (n) {
                        if (!Di[n]) throw new we(n + " is not a customizable class name.\nYou can customize: " + Object.keys(Di).join(", "));
                        var r = e[n] || Di[n];
                        t[n] = r.replace(/\./g, " ")
                    }), this._classes = qi({}, this._classes, t), this
                }
            }, {
                key: "_emitEvent",
                value: function (e, t) {
                    return this._emit(e, qi({
                        elementType: this._componentName
                    }, t))
                }
            }, {
                key: "_setupEvents",
                value: function () {
                    var e = this;
                    this._frame._on("redirectfocus", function (t) {
                        var n = t.focusDirection,
                            r = Mn(e._component, n);
                        r && r.focus()
                    }), this._frame._on("focus", function () {
                        e._focused = !0, e._updateClasses()
                    }), this._frame._on("blur", function () {
                        e._focused = !1, e._updateClasses(), e._lastSubmittedAt && "paymentRequestButton" === e._componentName && (e._controller.report("payment_request_button.sheet_visible", {
                            latency: new Date - e._lastSubmittedAt
                        }), e._lastSubmittedAt = null)
                    }), this._frame._on("submit", function () {
                        if ("paymentRequestButton" === e._componentName) {
                            e._lastSubmittedAt = new Date;
                            var t = !1,
                                n = !1;
                            e._emitEvent("click", {
                                preventDefault: function () {
                                    e._controller.report("payment_request_button.default_prevented"), t && e._controller.warn("event.preventDefault() was called after the payment sheet was shown. Make sure to call it synchronously when handling the `click` event."), n = !0
                                }
                            }), !n && e._paymentRequest && (e._paymentRequest._elementShow(), t = !0)
                        } else e._emitEvent("submit"), e._formSubmit()
                    }), ["ready", "focus", "blur", "escape"].forEach(function (t) {
                        e._frame._on(t, function () {
                            e._emitEvent(t)
                        })
                    }), this._frame._on("change", function (t) {
                        var n = {};
                        ["error", "value", "empty", "complete"].concat(Z(Sr[e._componentName] || [])).forEach(function (e) {
                            return n[e] = t[e]
                        }), e._emitEvent("change", n), e._empty = n.empty, e._invalid = !!n.error, e._complete = n.complete, e._updateClasses()
                    }), this._frame._on("__privateIntegrationError", function (t) {
                        var n = t.message;
                        e._emitEvent("__privateIntegrationError", {
                            message: n
                        })
                    }), this._frame._on("dimensions", function (t) {
                        if (e._parent) {
                            var n = Ni(e._parent, null);
                            if (n) {
                                var r = parseFloat(n.getPropertyValue("height")),
                                    o = t.height;
                                if ("border-box" === n.getPropertyValue("box-sizing")) {
                                    var i = parseFloat(n.getPropertyValue("padding-top")),
                                        a = parseFloat(n.getPropertyValue("padding-bottom"));
                                    r = r - parseFloat(n.getPropertyValue("border-top")) - parseFloat(n.getPropertyValue("border-bottom")) - i - a
                                }
                                0 !== r && Bi(r) < Bi(o) && e._controller.report("wrapper_height_mismatch", {
                                    height: o,
                                    outer_height: r
                                });
                                var s = e._component.getBoundingClientRect().height;
                                0 !== s && 0 !== o && Bi(s) !== Bi(o) && (e._frame.updateStyle({
                                    height: o + "px"
                                }), e._controller.report("iframe_height_update", {
                                    height: o,
                                    calculated_height: s
                                }))
                            }
                        }
                    }), this._frame._on("autofill", function () {
                        if (e._parent) {
                            var t = e._parent.style.backgroundColor,
                                n = "#faffbd" === t || "rgb(250, 255, 189)" === t;
                            e._lastBackgroundColor = n ? e._lastBackgroundColor : t, e._parent.style.backgroundColor = "#faffbd", e._autofilled = !0, e._updateClasses()
                        }
                    }), this._frame._on("autofill-cleared", function () {
                        e._autofilled = !1, e._parent && (e._parent.style.backgroundColor = e._lastBackgroundColor), e._updateClasses()
                    })
                }
            }, {
                key: "_handleOutsideClick",
                value: function () {
                    this._secondaryFrame && this._secondaryFrame.send({
                        action: "stripe-outside-click",
                        payload: {}
                    })
                }
            }, {
                key: "_createSecondFrame",
                value: function (e, t, n) {
                    var r = this._controller.createSecondaryElementFrame(e, qi({}, n, {
                        componentName: t
                    }));
                    return r && r.on && r.on("height-change", function (e) {
                        r.updateStyle({
                            height: e.height + "px"
                        })
                    }), r
                }
            }, {
                key: "_createComponent",
                value: function (e, t) {
                    this._createElement(e, t), this._setupEvents(), this._updateFrameHeight(e, !0)
                }
            }, {
                key: "_updateFrameHeight",
                value: function (e) {
                    var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
                    if ("paymentRequestButton" === this._componentName) {
                        var n = e.style && e.style.paymentRequestButton || {},
                            r = n.height,
                            o = "string" == typeof r ? r : void 0;
                        (t || o) && (this._frame.updateStyle({
                            height: o || this._lastHeight || "40px"
                        }), this._lastHeight = o || this._lastHeight)
                    } else {
                        var i = e.style && e.style.base || {},
                            a = i.lineHeight,
                            s = i.fontSize,
                            c = i.padding,
                            u = "string" != typeof a || isNaN(parseFloat(a)) ? void 0 : a,
                            l = "string" == typeof s ? s : void 0,
                            p = "string" == typeof c ? c : void 0;
                        if (l && !Ui(l) && this._controller.warn("The fontSize style you specified (" + l + ") is not in px. We do not recommend using relative css units, as they will be calculated relative to our iframe's styles rather than your site's."), t || u || l) {
                            var f = -1 === zt.indexOf(this._componentName) ? void 0 : p || this._lastPadding,
                                d = Ri(u || this._lastHeight, l || this._lastFontSize, f);
                            this._frame.updateStyle({
                                height: d
                            }), this._lastFontSize = l || this._lastFontSize, this._lastHeight = u || this._lastHeight, this._lastPadding = f
                        }
                    }
                }
            }, {
                key: "_createElement",
                value: function (e, t) {
                    var n = this,
                        r = (e.classes, e.controller, e.paymentRequest, Q(e, ["classes", "controller", "paymentRequest"])),
                        o = document.createElement("div");
                    o.className = "__PrivateStripeElement";
                    var i = document.createElement("input");
                    i.className = "__PrivateStripeElement-input", i.setAttribute("aria-hidden", "true"), i.setAttribute("aria-label", " "), i.setAttribute("autocomplete", "false"), i.maxLength = 1, i.disabled = !0, Xt(o, xi), Xt(i, Fi);
                    var a = Ni(document.body),
                        s = !!a && "rtl" === a.getPropertyValue("direction"),
                        c = gr[t],
                        u = qi({}, r, {
                            rtl: s
                        }),
                        l = this._controller.createElementFrame(c, u);
                    if (l._on("load", function () {
                            i.disabled = !1
                        }), i.addEventListener("focus", function () {
                            l.focus()
                        }), l.appendTo(o), Or[t]) {
                        var p = Or[t].secondary;
                        this._secondaryFrame = this._createSecondFrame(c, p, qi({}, u, {
                            primaryElementType: t
                        })), this._secondaryFrame.appendTo(o), window.addEventListener("click", function () {
                            return n._handleOutsideClick()
                        })
                    }
                    if (o.appendChild(i), fr) {
                        var f = document.createElement("input");
                        f.className = "__PrivateStripeElement-safariInput", f.setAttribute("aria-hidden", "true"), f.setAttribute("tabindex", "-1"), f.setAttribute("autocomplete", "false"), f.maxLength = 1, f.disabled = !0, Xt(f, Fi), o.appendChild(f)
                    }
                    this._component = o, this._frame = l, this._fakeInput = i
                }
            }]), t
        }(fn),
        Hi = function () {
            var e = this;
            this._paymentRequest = null, this.mount = sn(function (t) {
                e._checkDestroyed();
                var n = void 0;
                if (!t) throw new we("Missing argument. Make sure to call mount() with a valid DOM element or selector.");
                if ("string" == typeof t) {
                    var r = document.querySelectorAll(t);
                    if (r.length > 1 && e._controller.warn("The selector you specified (" + t + ") applies to " + r.length + " DOM elements that are currently on the page.\nThe Stripe Element will be mounted to the first one."), !r.length) throw new we("The selector you specified (" + t + ") applies to no DOM elements that are currently on the page.\nMake sure the element exists on the page before calling mount().");
                    n = r[0]
                } else {
                    if (!t.appendChild) throw new we("Invalid DOM element. Make sure to call mount() with a valid DOM element or selector.");
                    n = t
                }
                if ("INPUT" === n.nodeName) throw new we("Stripe Elements must be mounted in a DOM element that\ncan contain child nodes. `input` elements are not permitted to have child\nnodes. Try using a `div` element instead.");
                if (n.children.length && e._controller.warn("This Element will be mounted to a DOM element that contains child nodes."), e._paymentRequest) {
                    if (!e._paymentRequest._canMakePaymentResolved) throw new we("For the paymentRequestButton Element, you must first check availability using paymentRequest.canMakePayment() before mounting the Element.");
                    if (!e._paymentRequest._activeBackingLibraryName) throw new we("The paymentRequestButton Element is not available in the current environment.");
                    e._mountToParent(n)
                } else e._mountToParent(n)
            }), this.update = sn(function (t) {
                e._checkDestroyed();
                var n = wt(Ai, t || {}, "element.update()"),
                    r = n.value;
                if (n.warnings.forEach(function (t) {
                        return e._controller.warn(t)
                    }), r) {
                    var o = r.classes,
                        i = Q(r, ["classes"]);
                    e._changeClasses(o || {}), e._updateFrameHeight(r), Object.keys(i).length && (e._frame.update(i), e._secondaryFrame && e._secondaryFrame.update(i))
                }
                return e
            }), this.focus = sn(function (t) {
                return e._checkDestroyed(), t && t.preventDefault(), document.activeElement && document.activeElement.blur && document.activeElement.blur(), e._fakeInput.focus(), e
            }), this.blur = sn(function () {
                return e._checkDestroyed(), e._frame.blur(), e._fakeInput.blur(), e
            }), this.clear = sn(function () {
                return e._checkDestroyed(), e._frame.clear(), e
            }), this.unmount = sn(function () {
                e._checkDestroyed();
                var t = e._component.parentElement,
                    n = e._label;
                return t && (t.removeChild(e._component), t.removeEventListener("click", e.focus), e._removeClasses()), e._parent = null, n && (n.removeEventListener("click", e.focus), e._label = null), e._secondaryFrame && (e._secondaryFrame.unmount(), window.removeEventListener("click", e._handleOutsideClick)), e._fakeInput.disabled = !0, e._frame.unmount(), e
            }), this.destroy = sn(function () {
                return e._checkDestroyed(), e.unmount(), e._destroyed = !0, e._emitEvent("destroy"), e
            }), this._formSubmit = function () {
                for (var t = e._component.parentElement; t && "FORM" !== t.nodeName;) t = t.parentElement;
                if (t) {
                    var n = document.createEvent("Event");
                    n.initEvent("submit", !0, !0), t.dispatchEvent(n)
                }
            }
        },
        Yi = zi,
        Wi = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Gi = {
            locale: Qe(it),
            fonts: Qe(ht(dt))
        },
        Vi = bt(Gi),
        Ki = function e(t, n) {
            var r = this;
            re(this, e), $i.call(this);
            var o = wt(Vi, n || {}, "elements()"),
                i = o.value;
            o.warnings.forEach(function (e) {
                return t.warn(e)
            }), Nr(t.warn), t.report("elements", {
                options: n
            }), this._elements = [], this._id = Yt("elements"), this._controller = t;
            var a = i.locale,
                s = i.fonts || [];
            this._controller.action.fetchLocale({
                locale: a || "auto"
            });
            var c = s.filter(function (e) {
                    return !e.cssSrc || "string" != typeof e.cssSrc
                }).map(function (e) {
                    return Wi({}, e, {
                        __resolveFontRelativeTo: window.location.href
                    })
                }),
                u = s.map(function (e) {
                    return e.cssSrc
                }).reduce(function (e, t) {
                    return "string" == typeof t ? [].concat(ne(e), [t]) : e
                }, []).map(function (e) {
                    return kt(e) ? e : Pt(window.location.href, e)
                });
            return this._pendingFonts = u.length, this._commonOptions = Wi({}, i, {
                fonts: c
            }), u.forEach(function (e) {
                if ("string" == typeof e) {
                    var t = Date.now();
                    $r(e).then(function (n) {
                        r._controller.report("font.loaded", {
                            load_time: Date.now() - t,
                            font_count: n.length,
                            css_src: e
                        });
                        var o = n.map(function (t) {
                            return Wi({}, t, {
                                __resolveFontRelativeTo: e
                            })
                        });
                        r._controller.action.updateCSSFonts({
                            fonts: o,
                            groupId: r._id
                        }), r._commonOptions = Wi({}, r._commonOptions, {
                            fonts: [].concat(ne(r._commonOptions.fonts ? r._commonOptions.fonts : []), ne(o))
                        })
                    }).catch(function (n) {
                        r._controller.report("error.font.not_loaded", {
                            load_time: Date.now() - t,
                            message: n && n.message && n.message,
                            css_src: e
                        }), r._controller.warn("Failed to load CSS file at " + e + ".")
                    })
                }
            }), this
        },
        $i = function () {
            var e = this;
            this.create = cn(function (t, n) {
                Ti(t, e._elements);
                var r = wt(Ai, n || {}, "create()"),
                    o = r.value;
                r.warnings.forEach(function (t) {
                    return e._controller.warn(t)
                });
                var i = Wi({}, o, e._commonOptions, {
                        componentName: t,
                        groupId: e._id
                    }),
                    a = (ur || lr) && Kt(i).length > 2e3,
                    s = !!e._pendingFonts || a,
                    c = new Yi(Wi({}, i, {
                        fonts: a ? null : e._commonOptions.fonts,
                        controller: e._controller,
                        wait: s
                    }));
                return e._elements = [].concat(ne(e._elements), [t]), c._on("destroy", function () {
                    e._elements = e._elements.filter(function (e) {
                        return e !== t
                    })
                }), a && c._frame.send({
                    action: "stripe-user-update",
                    payload: {
                        fonts: e._commonOptions.fonts
                    }
                }), c
            })
        },
        Ji = Ki,
        Qi = function (e, t, n, r, o, i) {
            return new Si({
                controller: e,
                authentication: t,
                mids: n,
                rawOptions: r,
                betas: o,
                queryStrategyOverride: i
            })
        },
        Zi = Qi,
        Xi = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        ea = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        ta = function (e, t) {
            switch (e.type) {
                case "object":
                    return {
                        paymentIntent: e.object
                    };
                case "error":
                    return {
                        error: ea({}, t ? {
                            payment_intent: t
                        } : {}, e.error)
                    };
                default:
                    return Ee(e)
            }
        },
        na = function (e) {
            var t = e.trim().match(/^([a-z]+_[^_]+)_secret_[^-]+$/);
            return t ? {
                id: t[1],
                clientSecret: t[0]
            } : null
        },
        ra = function (e, t) {
            if ("string" != typeof e) return Je("a client_secret string", e, t);
            var n = na(e);
            return null === n ? Je("a client secret of the form ${id}_secret_${secret}", e, t) : Ve(n, [])
        },
        oa = function (e, t) {
            if (null == e) return Ve(null);
            var n = e.type,
                r = ie(e, ["type"]),
                o = ea({}, t, {
                    path: [].concat(oe(t.path), ["type"])
                }),
                i = at(it, function () {
                    return null
                })(n, o);
            return "error" === i.type ? i : Ve({
                type: i.value,
                data: r
            })
        },
        ia = function (e) {
            return "requires_source_action" === e || "requires_action" === e
        },
        aa = function (e) {
            return "requires_source_action" === e.status || "requires_action" === e.status ? e.next_action : null
        },
        sa = function (e, t) {
            if (null === e) return $e("object", "null", t);
            if ("object" !== (void 0 === e ? "undefined" : Xi(e))) return $e("object", void 0 === e ? "undefined" : Xi(e), t);
            var n = e.client_secret,
                r = e.status,
                o = e.next_action,
                i = ea({}, t, {
                    path: [].concat(oe(t.path), ["client_secret"])
                }),
                a = ra(n, i);
            if ("error" === a.type) return a;
            if ("string" != typeof r) {
                var s = ea({}, t, {
                    path: [].concat(oe(t.path), ["status"])
                });
                return $e("string", void 0 === r ? "undefined" : Xi(r), s)
            }
            if (("requires_source_action" === r || "requires_action" === r) && "object" !== (void 0 === o ? "undefined" : Xi(o))) {
                var c = ea({}, t, {
                    path: [].concat(oe(t.path), ["next_action"])
                });
                return $e("object", void 0 === o ? "undefined" : Xi(o), c)
            }
            if ("payment_intent" === e.object) {
                return Ve(e, [])
            }
            return Ve(e, [])
        },
        ca = function (e) {
            return function (t, n) {
                if ("object" === (void 0 === t ? "undefined" : Xi(t)) && null !== t) {
                    var r = t.source,
                        o = t.source_data,
                        i = t.payment_method,
                        a = t.payment_method_data,
                        s = ie(t, ["source", "source_data", "payment_method", "payment_method_data"]);
                    if (null != r && "string" != typeof r) {
                        var c = ea({}, n, {
                            path: [].concat(oe(n.path), ["source"])
                        });
                        return $e("string", void 0 === r ? "undefined" : Xi(r), c)
                    }
                    if (null != i && "string" != typeof i) {
                        var u = ea({}, n, {
                            path: [].concat(oe(n.path), ["payment_method"])
                        });
                        return $e("string", void 0 === i ? "undefined" : Xi(i), u)
                    }
                    if (null != o && "object" !== (void 0 === o ? "undefined" : Xi(o))) {
                        var l = ea({}, n, {
                            path: [].concat(oe(n.path), ["source_data"])
                        });
                        return $e("object", void 0 === o ? "undefined" : Xi(o), l)
                    }
                    if (null != a && "object" !== (void 0 === a ? "undefined" : Xi(a))) {
                        var p = ea({}, n, {
                            path: [].concat(oe(n.path), ["payment_method_data"])
                        });
                        return $e("object", void 0 === a ? "undefined" : Xi(a), p)
                    }
                    var f = ea({}, n, {
                            path: [].concat(oe(n.path), ["source_data"])
                        }),
                        d = oa(o, f);
                    if ("error" === d.type) return d;
                    var h = d.value,
                        _ = ea({}, n, {
                            path: [].concat(oe(n.path), ["payment_method_data"])
                        }),
                        m = oa(a, _);
                    if ("error" === m.type) return m;
                    var y = m.value;
                    return Ve({
                        sourceData: h,
                        source: null == r ? null : r,
                        paymentMethodData: y,
                        paymentMethod: null == i ? null : i,
                        otherParams: ea({}, e, s)
                    })
                }
                return null === t ? $e("object", "null", n) : $e("object", void 0 === t ? "undefined" : Xi(t), n)
            }
        },
        ua = function (e) {
            return function (t, n) {
                if (void 0 === t) return Ve({
                    sourceData: null,
                    paymentMethodData: null,
                    source: null,
                    paymentMethod: null,
                    otherParams: {}
                });
                if ("object" !== (void 0 === t ? "undefined" : Xi(t))) return $e("object", void 0 === t ? "undefined" : Xi(t), n);
                if (null === t) return $e("object", "null", n);
                if (e) {
                    if (!t.payment_intent) return Ve({
                        sourceData: null,
                        paymentMethodData: null,
                        source: null,
                        paymentMethod: null,
                        otherParams: t
                    });
                    var r = t.payment_intent,
                        o = ie(t, ["payment_intent"]),
                        i = ea({}, n, {
                            path: [].concat(oe(n.path), ["payment_intent"])
                        });
                    return ca(o)(r, i)
                }
                return t.payment_intent ? Ke(new we("The payment_intent parameter has been removed. To fix, move everything nested under the payment_intent parameter to the top-level object.")) : ca({})(t, n)
            }
        },
        la = {
            card: "card",
            ideal: "ideal",
            sepa_debit: "sepa_debit",
            three_d_secure: "three_d_secure"
        },
        pa = (be = {}, ae(be, Mt.card, la.card), ae(be, Mt.cardNumber, la.card), ae(be, Mt.cardExpiry, la.card), ae(be, Mt.cardCvc, la.card), ae(be, Mt.postalCode, la.card), ae(be, Mt.iban, la.sepa_debit), ae(be, Mt.idealBank, la.ideal), be),
        fa = function (e) {
            return -1 === Dt.indexOf(e)
        },
        da = function (e, t) {
            return null != t ? t : fa(e) ? null : pa[e] || null
        },
        ha = function (e) {
            var t = e.name,
                n = e.value,
                r = e.expiresIn,
                o = e.path,
                i = e.domain,
                a = new Date,
                s = r || 31536e6;
            a.setTime(a.getTime() + s);
            var c = o || "/",
                u = (n || "").replace(/[^!#-+\--:<-[\]-~]/g, encodeURIComponent),
                l = encodeURIComponent(t) + "=" + u + ";expires=" + a.toGMTString() + ";path=" + c;
            i && (l += ";domain=" + i), document.cookie = l
        },
        _a = function (e) {
            var t = Ie(document.cookie.split("; "), function (t) {
                var n = t.indexOf("=");
                return decodeURIComponent(t.substr(0, n)) === e
            });
            if (t) {
                var n = t.indexOf("=");
                return decodeURIComponent(t.substr(n + 1))
            }
            return null
        },
        ma = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        ya = "__privateStripeMetricsController",
        va = {
            MERCHANT: "merchant",
            SESSION: "session"
        },
        ba = function () {
            function e() {
                var t = this,
                    n = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
                if (se(this, e), n.checkoutIds) {
                    var r = n.checkoutIds,
                        o = r.muid,
                        i = r.sid;
                    this._muid = o, this._sid = i, this._doNotPersist = !0
                } else this._muid = this._getID(va.MERCHANT), this._sid = this._getID(va.SESSION), this._doNotPersist = !1;
                this._id = Yt(ya), this._controllerFrame = new Sn(Tt.METRICS_CONTROLLER, this._id, {
                    autoload: !0,
                    queryString: this._buildFrameQueryString()
                }), this._guidPromise = new Pe(function (e) {
                    t._establishMessageChannel(e)
                }), this._startIntervalCheck(), setTimeout(this._testLatency.bind(this), 2e3 + 500 * Math.random())
            }
            return ma(e, [{
                key: "ids",
                value: function () {
                    return {
                        guid: this._guid || "NA",
                        muid: this._muid || "NA",
                        sid: this._sid || "NA"
                    }
                }
            }, {
                key: "idsPromise",
                value: function () {
                    var e = this;
                    return this._guidPromise.then(function () {
                        return e.ids()
                    })
                }
            }, {
                key: "_establishMessageChannel",
                value: function (e) {
                    var t = this;
                    window.addEventListener("message", function (n) {
                        try {
                            var r = JSON.parse(n.data),
                                o = r.originatingScript,
                                i = r.payload;
                            "m" === o && (t._guid = i, e(i))
                        } catch (e) {}
                    })
                }
            }, {
                key: "_startIntervalCheck",
                value: function () {
                    var e = this,
                        t = window.location.href;
                    setInterval(function () {
                        var n = window.location.href;
                        n !== t && (e.send({
                            action: "ping",
                            payload: {
                                sid: e._getID(va.SESSION),
                                muid: e._getID(va.MERCHANT),
                                title: document.title,
                                referrer: document.referrer,
                                url: document.location.href
                            }
                        }), t = n)
                    }, 5e3)
                }
            }, {
                key: "report",
                value: function (e, t) {
                    try {
                        this.send({
                            action: "track",
                            payload: {
                                sid: this._getID(va.SESSION),
                                muid: this._getID(va.MERCHANT),
                                url: document.location.href,
                                source: e,
                                data: t
                            }
                        })
                    } catch (e) {}
                }
            }, {
                key: "send",
                value: function (e) {
                    var t = Ct(Tt.METRICS_CONTROLLER);
                    Zn(t) && this._controllerFrame.send(e)
                }
            }, {
                key: "_testLatency",
                value: function () {
                    var e = this,
                        t = [],
                        n = new Date,
                        r = function r() {
                            try {
                                var o = new Date;
                                t.push(o - n), t.length >= 10 && (e.report("mouse-timings-10", t), document.removeEventListener("mousemove", r)), n = o
                            } catch (e) {}
                        };
                    document.addEventListener("mousemove", r)
                }
            }, {
                key: "_extractMetaReferrerPolicy",
                value: function () {
                    var e = document.querySelector("meta[name=referrer]");
                    return null != e && e instanceof HTMLMetaElement ? e.content.toLowerCase() : null
                }
            }, {
                key: "_extractUrl",
                value: function (e) {
                    var t = document.location.href;
                    switch (e) {
                        case "origin":
                        case "strict-origin":
                        case "origin-when-cross-origin":
                        case "strict-origin-when-cross-origin":
                            return document.location.origin;
                        case "unsafe-url":
                            return t.split("#")[0];
                        default:
                            return t
                    }
                }
            }, {
                key: "_buildFrameQueryString",
                value: function () {
                    var e = this._extractMetaReferrerPolicy(),
                        t = this._extractUrl(e),
                        n = {
                            url: t,
                            title: document.title,
                            referrer: document.referrer,
                            muid: this._muid,
                            sid: this._sid,
                            preview: Xn(t)
                        };
                    return null != e && (n.metaReferrerPolicy = e), Object.keys(n).map(function (e) {
                        return null != n[e] ? e + "=" + encodeURIComponent(n[e].toString()) : null
                    }).join("&")
                }
            }, {
                key: "_getID",
                value: function (e) {
                    switch (e) {
                        case va.MERCHANT:
                            if (this._doNotPersist) return this._muid;
                            try {
                                var t = _a("__stripe_mid") || Wt();
                                return ha({
                                    name: "__stripe_mid",
                                    value: t,
                                    domain: "." + document.location.hostname
                                }), t
                            } catch (e) {
                                return "NA"
                            }
                            case va.SESSION:
                                if (this._doNotPersist) return this._sid;
                                try {
                                    var n = _a("__stripe_sid") || Wt();
                                    return ha({
                                        name: "__stripe_sid",
                                        value: n,
                                        domain: "." + document.location.hostname,
                                        expiresIn: 18e5
                                    }), n
                                } catch (e) {
                                    return "NA"
                                }
                                default:
                                    throw new Error("Invalid ID type specified: " + e)
                    }
                }
            }]), e
        }(),
        ga = ba,
        wa = {
            _frame: bt({
                id: it
            }),
            _componentName: it
        },
        Ea = bt(wa),
        ka = function (e) {
            var t = gt(Ea, e, "");
            return "error" === t.type ? null : t.value
        },
        Sa = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Oa = function (e, t, n, r) {
            if (null === e) {
                if (null === t) {
                    throw new we(n + ": you must additionally specify the type of payment method to create within " + (r ? "source_data" : "payment_method_data") + ".")
                }
                return t
            }
            if (null === t) return e;
            if (t !== e) throw new we(n + ": you specified `type: " + t + "`, but " + n + " will create a " + e + " payment method.");
            return e
        },
        Pa = function (e, t, n, r, o, i) {
            var a = gt(Ea, o, r);
            if ("error" === a.type) return null;
            var s = a.value,
                c = wt(ua(t), i, r),
                u = c.value,
                l = u.sourceData,
                p = u.source,
                f = u.paymentMethodData,
                d = u.paymentMethod,
                h = u.otherParams;
            if (!e && l) throw new we(r + ": Expected payment_method_data, not source_data.");
            if (null != p) throw new we("When calling " + r + " on an Element, you can't pass in a pre-existing source ID, as a source will be created using the Element.");
            if (null != d) throw new we("When calling " + r + " on an Element, you can't pass in a pre-existing PaymentMethod ID, as a PaymentMethod will be created using the Element.");
            var _ = s._componentName,
                m = s._frame.id,
                y = l || f || {
                    type: null,
                    data: {}
                },
                v = y.type,
                b = y.data,
                g = da(_, v),
                w = e && !f;
            return {
                confirmMode: {
                    tag: "element",
                    elementName: _,
                    shouldCreateSource: w,
                    frameId: m,
                    type: Oa(n, g, r, w),
                    data: b
                },
                otherParams: h
            }
        },
        Aa = function (e, t, n, r, o, i) {
            var a = wt(ua(t), o, r),
                s = a.value,
                c = s.sourceData,
                u = s.source,
                l = s.paymentMethodData,
                p = s.paymentMethod,
                f = s.otherParams;
            if (!e && c) throw new we(r + ": Expected payment_method, source, or payment_method_data, not source_data.");
            if (null !== u && null !== c) throw new we(r + ": Expected either source or source_data, but not both.");
            if (null !== p && null !== l) throw new we(r + ": Expected either payment_method or payment_method_data, but not both.");
            if (null !== p && null !== u) throw new we(r + ": Expected either payment_method or source, but not both.");
            if (c || l) {
                var d = c || l || {},
                    h = d.type,
                    _ = d.data,
                    m = e && !l;
                return {
                    confirmMode: {
                        tag: "data",
                        shouldCreateSource: m,
                        type: Oa(n, h, r, m),
                        data: _
                    },
                    otherParams: f
                }
            }
            return null !== u ? {
                confirmMode: {
                    tag: "source",
                    source: u
                },
                otherParams: f
            } : null !== p ? {
                confirmMode: {
                    tag: "paymentMethod",
                    paymentMethod: p
                },
                otherParams: f
            } : {
                confirmMode: {
                    tag: "none"
                },
                otherParams: f
            }
        },
        Ta = function (e, t, n, r) {
            return function (o, i) {
                var a = Pa(e, t, n, r, o, i);
                if (a) return a;
                var s = Aa(e, t, n, r, o);
                if (s) return s;
                throw new we("Expected: stripe." + r + "(intentSecret, element[, data]) or stripe." + r + "(intentSecret[, data]). Please see the docs for more usage examples https://stripe.com/docs/payments/dynamic-authentication")
            }
        },
        Ia = function (e, t, n) {
            return e.createLightboxFrame(Tt.AUTHORIZE_WITH_URL, {
                url: t,
                locale: n
            })
        },
        ja = function (e, t, n) {
            var r = Mr(),
                o = Date.now(),
                i = Ia(t, e, n);
            return i.show(), t.report("authorize_with_url.loading", {
                viewport: r
            }), i._on("load", function () {
                t.report("authorize_with_url.loaded", {
                    loadDuration: Date.now() - o
                }), i.fadeInBackdrop()
            }), new Pe(function (e, n) {
                i._once("authorize_with_url_done", function (n) {
                    t.report("authorize_with_url.done", {
                        shownDuration: Date.now() - o,
                        success: !("error" in n)
                    }), i.destroy().then(function () {
                        return e(n)
                    })
                })
            })
        },
        Ca = function (e, t) {
            if (e) {
                if ("use_stripe_sdk" === e.type && "cardinal_3ds2_fingerprint" === e.use_stripe_sdk.type) return Sa({
                    type: "cardinal-sdk-fingerprint"
                }, e.use_stripe_sdk.stripe_js);
                if ("use_stripe_sdk" === e.type && "stripe_3ds2_fingerprint" === e.use_stripe_sdk.type) return {
                    type: "3ds2-fingerprint",
                    threeDS2Source: e.use_stripe_sdk.three_d_secure_2_source,
                    transactionId: e.use_stripe_sdk.server_transaction_id,
                    methodUrl: e.use_stripe_sdk.three_ds_method_url,
                    optimizations: e.use_stripe_sdk.three_ds_optimizations,
                    directoryServerName: e.use_stripe_sdk.directory_server_name
                };
                if ("use_stripe_sdk" !== e.type && "authorize_with_url" !== e.type || e.use_stripe_sdk && ("cardinal_3ds2_fingerprint" === e.use_stripe_sdk.type || "cardinal_3ds2_challenge" === e.use_stripe_sdk.type || "stripe_3ds2_fingerprint" === e.use_stripe_sdk.type) || t !== la.card) {
                    if ("redirect_to_url" !== e.type && "authorize_with_url" !== e.type || t !== la.ideal) return;
                    return {
                        type: "ideal-redirect",
                        redirectUrl: e.redirect_to_url ? e.redirect_to_url.url : e.authorize_with_url.url
                    }
                }
                return {
                    type: "3ds1-modal",
                    url: e.use_stripe_sdk ? e.use_stripe_sdk.stripe_js : e.authorize_with_url.url
                }
            }
        },
        Ra = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Ma = function (e) {
            if (!e || "object" !== (void 0 === e ? "undefined" : Ra(e))) return null;
            var t = e.type,
                n = ce(e, ["type"]);
            return {
                type: "string" == typeof t ? t : null,
                data: n
            }
        },
        Na = function (e) {
            switch (e.type) {
                case "object":
                    return {
                        source: e.object
                    };
                case "error":
                    return {
                        error: e.error
                    };
                default:
                    return Ee(e)
            }
        },
        qa = {
            source: bt({
                id: et("src_"),
                client_secret: et("src_client_secret_")
            })
        },
        La = bt(qa),
        Da = function (e) {
            switch (e.type) {
                case "object":
                    return {
                        paymentMethod: e.object
                    };
                case "error":
                    return {
                        error: e.error
                    };
                default:
                    return Ee(e)
            }
        },
        xa = function (e) {
            return new Pe(function (t, n) {
                var r = setTimeout(function () {
                    t({
                        type: "error",
                        error: {
                            code: "redirect_error",
                            message: "Failed to redirect to " + e
                        },
                        locale: "en"
                    })
                }, 3e3);
                window.addEventListener("pagehide", function () {
                    clearTimeout(r)
                }), window.top.location.href = e
            })
        },
        Fa = function (e, t, n) {
            e.report("redirect_error", {
                initiator: t,
                error: n.error
            })
        },
        Ba = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Ua = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        za = function (e, t, n) {
            return e.createLightboxFrame(Tt.CARDINAL_3DS2, {
                intentSecret: t,
                locale: n
            })
        },
        Ha = function (e, t, n) {
            return e.createLightboxFrame(Tt.STRIPE_3DS2, {
                intentSecret: t,
                locale: n
            })
        },
        Ya = function (e) {
            return function (t) {
                if (t.error || t.paymentIntent) return t;
                throw e.report("cardinal_3ds2.malformed_frame_action_payload", {
                    payload: t
                }), new Error("Malformed frame action response")
            }
        },
        Wa = function (e, t, n, r) {
            var o = Date.now(),
                i = za(n, e, r);
            return i.show(), n.report("cardinal_3ds2.frame.loading"), new Pe(function (e) {
                i._on("load", function () {
                    n.report("cardinal_3ds2.frame.loaded", {
                        loadDuration: Date.now() - o
                    }), i.fadeInBackdrop(), i.action("stripe-cardinal-3ds2-init", t).then(Ya(n)).then(function (t) {
                        n.report("cardinal_3ds2.done", {
                            totalDuration: Date.now() - o,
                            success: !("error" in t)
                        }), i.destroy().then(function () {
                            return e(t)
                        })
                    })
                })
            })
        },
        Ga = function (e) {
            return function (t) {
                if (t.error) return {
                    error: t.error
                };
                if (t.object) {
                    if ("payment_intent" === t.object.object) return {
                        paymentIntent: t.object
                    };
                    if ("setup_intent" === t.object.object) return {
                        setupIntent: t.object
                    }
                }
                throw e.report("3ds2.malformed_frame_action_payload", {
                    payload: t
                }), new Error("Malformed frame action response")
            }
        },
        Va = function (e, t, n, r, o) {
            var i = Date.now(),
                a = Ha(r, e, o);
            return a.show(), r.report("3ds2.frame.loading"), new Pe(function (o) {
                a._on("challenge_complete", function () {
                    a.fadeOutBackdrop()
                }), a._on("load", function () {
                    r.report("3ds2.frame.loaded", {
                        loadDuration: Date.now() - i
                    }), a.fadeInBackdrop(), a.action("3ds2-init", Ua({}, n, {
                        clientSecret: e,
                        intentType: t
                    })).then(Ga(r)).then(function (e) {
                        r.report("3ds2.done", {
                            totalDuration: Date.now() - i,
                            success: !("error" in e)
                        }), a.destroy().then(function () {
                            return o(e)
                        })
                    })
                })
            })
        },
        Ka = function (e, t, n) {
            var r = function (t) {
                return Fa(n, "ideal redirect", t), ta(t, e)
            };
            return xa(t).then(r)
        },
        $a = function (e) {
            switch (e.type) {
                case "error":
                    var t = e.error;
                    if ("payment_intent_unexpected_state" === t.code && "object" === Ba(t.payment_intent) && null != t.payment_intent && "string" == typeof t.payment_intent.status && ia(t.payment_intent.status)) {
                        var n = t.payment_intent;
                        return {
                            type: "object",
                            locale: e.locale,
                            object: n
                        }
                    }
                    return e;
                case "object":
                    return e;
                default:
                    return Ee(e)
            }
        },
        Ja = function (e, t, n, r) {
            var o = Ca(aa(t), n);
            if (!o) return Pe.resolve({
                paymentIntent: t
            });
            switch (o.type) {
                case "3ds1-modal":
                    return ja(o.url, e, r).then(function (e) {
                        if (e.paymentIntent || e.error) return e;
                        throw new Error("Got SetupIntent response from AuthorizeWithUrl")
                    });
                case "3ds2-fingerprint":
                    return Va(t.client_secret, qt.PAYMENT_INTENT, {
                        threeDS2Source: o.threeDS2Source,
                        directoryServerName: o.directoryServerName,
                        transactionId: o.transactionId,
                        methodUrl: o.methodUrl,
                        optimizations: o.optimizations
                    }, e, r).then(function (e) {
                        if (e.paymentIntent || e.error) return e;
                        throw new Error("Got SetupIntent response from Stripe 3DS2")
                    });
                case "cardinal-sdk-fingerprint":
                    return Wa(t.client_secret, {
                        jwt: o.jwt,
                        bin: o.bin,
                        env: o.env
                    }, e, r);
                case "ideal-redirect":
                    return Ka(t, o.redirectUrl, e);
                default:
                    return Pe.resolve({
                        paymentIntent: t
                    })
            }
        },
        Qa = function (e, t, n) {
            return function (r) {
                var o = $a(r);
                switch (o.type) {
                    case "error":
                        var i = o.error,
                            a = i.payment_intent;
                        return n && a && "payment_intent_unexpected_state" === i.code && ("succeeded" === a.status || "requires_capture" === a.status) ? Pe.resolve({
                            paymentIntent: a
                        }) : Pe.resolve(ta(r));
                    case "object":
                        var s = o.object;
                        return Ja(e, s, t, o.locale);
                    default:
                        return Ee(o)
                }
            }
        },
        Za = function (e, t, n, r, o) {
            var i = ka(r);
            if ("string" != typeof n) return Pe.reject(new we("Please provide a PaymentMethod type to createPaymentMethod."));
            var a = Ma(i ? o : r),
                s = a || {
                    type: null,
                    data: {}
                },
                c = s.type,
                u = s.data;
            if (c && n !== c) return Pe.reject(new we("The type supplied in payment_method_data is not consistent."));
            if (i) {
                var l = i._frame.id,
                    p = i._componentName;
                return e.action.createPaymentMethodWithElement({
                    frameId: l,
                    elementName: p,
                    type: n,
                    paymentMethodData: u,
                    mids: t
                }).then(Da)
            }
            return a ? e.action.createPaymentMethodWithData({
                elementName: null,
                type: n,
                paymentMethodData: u,
                mids: t
            }).then(Da) : Pe.reject(new we("Please provide either an Element or PaymentMethod creation parameters to createPaymentMethod."))
        },
        Xa = function (e, t) {
            var n = wt(ra, e, "retrievePaymentIntent"),
                r = n.value;
            return t.action.retrievePaymentIntent(r).then(ta)
        },
        es = function (e, t, n, r, o, i) {
            var a = wt(ra, r, "stripe.confirmPaymentIntent intent secret"),
                s = a.value,
                c = Ta(e, !1, null, "confirmPaymentIntent")(o, i);
            return t.action.confirmPaymentIntent(Ua({}, c, {
                intentSecret: s,
                expectedType: null,
                mids: n
            })).then(ta)
        },
        ts = function (e, t, n) {
            return Pe.resolve({
                controller: e,
                clientSecret: t,
                intentType: n
            })
        },
        ns = function (e, t) {
            var n = wt(ra, e, "handleCardAction"),
                r = n.value;
            return t.action.retrievePaymentIntent(r).then(function (e) {
                var n = $a(e);
                switch (n.type) {
                    case "error":
                        return Pe.resolve(ta(e));
                    case "object":
                        var r = n.object;
                        if (ia(r.status)) {
                            if ("manual" !== r.confirmation_method) throw new we("handleCardAction: The PaymentIntent supplied does not require manual server-side confirmation. Please use handleCardPayment instead to complete the payment.");
                            return Ja(t, r, la.card, n.locale)
                        }
                        throw new we("handleCardAction: The PaymentIntent supplied is not in the requires_action state.");
                    default:
                        return Ee(n)
                }
            })
        },
        rs = function (e, t, n, r, o, i, a) {
            var s = wt(ra, o, "stripe.handleCardPayment intent secret"),
                c = s.value,
                u = la.card,
                l = Ta(e, r, u, "handleCardPayment")(i, a),
                p = !i && !a;
            return t.action.confirmPaymentIntent(Ua({}, l, {
                otherParams: Ua({}, l.otherParams, {
                    use_stripe_sdk: !0
                }),
                intentSecret: c,
                expectedType: u,
                mids: n
            })).then(Qa(t, u, p))
        },
        os = function (e, t, n, r, o, i) {
            var a = wt(ra, r, "stripe.handleSepaDebitPayment intent secret"),
                s = a.value,
                c = la.sepa_debit,
                u = Ta(!0, n, c, "handleSepaDebitPayment")(o, i),
                l = !o && !i;
            return e.action.confirmPaymentIntent(Ua({}, u, {
                intentSecret: s,
                expectedType: c,
                mids: t
            })).then(Qa(e, c, l))
        },
        is = function (e, t, n, r, o, i) {
            var a = wt(ra, r, "stripe.handleIdealPayment intent secret"),
                s = a.value,
                c = la.ideal,
                u = Ta(!0, n, c, "handleIdealPayment")(o, i),
                l = !o && !i;
            return e.action.confirmPaymentIntent(Ua({}, u, {
                intentSecret: s,
                expectedType: c,
                mids: t
            })).then(Qa(e, c, l))
        },
        as = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        ss = function (e, t, n, r) {
            var o = Ca(aa(t), n);
            if (!o) return Pe.resolve({
                setupIntent: t
            });
            switch (o.type) {
                case "3ds1-modal":
                    return ja(o.url, e, r).then(function (e) {
                        if (e.setupIntent || e.error) return e;
                        throw new Error("Got PaymentIntent response from AuthorizeWithUrl")
                    });
                case "3ds2-fingerprint":
                    return Va(t.client_secret, qt.SETUP_INTENT, {
                        threeDS2Source: o.threeDS2Source,
                        directoryServerName: o.directoryServerName,
                        transactionId: o.transactionId,
                        methodUrl: o.methodUrl,
                        optimizations: o.optimizations
                    }, e, r).then(function (e) {
                        if (e.setupIntent || e.error) return e;
                        throw new Error("Got PaymentIntent response from Stripe 3DS2")
                    });
                default:
                    return Pe.resolve({
                        setupIntent: t
                    })
            }
        },
        cs = function (e) {
            switch (e.type) {
                case "error":
                    return {
                        error: e.error
                    };
                case "object":
                    return {
                        setupIntent: e.object
                    };
                default:
                    return Ee(e)
            }
        },
        us = function (e, t, n) {
            return function (r) {
                switch (r.type) {
                    case "error":
                        var o = r.error,
                            i = o.setup_intent;
                        return n && i && "succeeded" === i.status ? Pe.resolve({
                            setupIntent: i
                        }) : Pe.resolve({
                            error: o
                        });
                    case "object":
                        var a = r.object;
                        return ss(e, a, t, r.locale);
                    default:
                        return Ee(r)
                }
            }
        },
        ls = function (e, t, n, r, o) {
            var i = wt(ra, n, "stripe.handleCardSetup intent secret"),
                a = i.value,
                s = la.card,
                c = Ta(!1, !1, s, "handleCardSetup")(r, o),
                u = !r && !o;
            return e.action.confirmSetupIntent(as({}, c, {
                otherParams: as({}, c.otherParams, {
                    use_stripe_sdk: !0
                }),
                intentSecret: a,
                expectedType: s,
                mids: t
            })).then(us(e, s, u))
        },
        ps = function (e, t) {
            var n = wt(ra, e, "stripe.retrieveSetupIntent intent secret"),
                r = n.value;
            return t.action.retrieveSetupIntent(r).then(cs)
        },
        fs = function (e, t, n, r, o) {
            var i = wt(ra, n, "stripe.confirmSetupIntent intent secret"),
                a = i.value,
                s = Ta(!1, !1, null, "confirmSetupIntent")(r, o);
            return e.action.confirmSetupIntent(as({}, s, {
                otherParams: as({}, s.otherParams),
                intentSecret: a,
                expectedType: null,
                mids: t
            })).then(cs)
        },
        ds = [mo.checkout_beta_2, mo.checkout_beta_3, mo.checkout_beta_4],
        hs = [mo.checkout_beta_2, mo.checkout_beta_3, mo.checkout_beta_4, mo.checkout_pm_types],
        _s = {
            da: "da",
            de: "de",
            en: "en",
            es: "es",
            fi: "fi",
            fr: "fr",
            it: "it",
            ja: "ja",
            nl: "nl",
            nb: "nb",
            pl: "pl",
            pt: "pt",
            sv: "sv",
            zh: "zh"
        },
        ms = Object.keys(_s),
        ys = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        vs = {
            sku: Qe(it),
            plan: Qe(it),
            clientReferenceId: Qe(it),
            locale: Qe(tt.apply(void 0, ["auto"].concat(le(ms)))),
            customerEmail: Qe(it),
            billingAddressCollection: Qe(tt("required", "auto")),
            submitType: Qe(tt("auto", "pay", "book", "donate")),
            paymentMethodTypes: Qe(ht(tt("card", "ideal")))
        },
        bs = function (e, t, n) {
            if (e && t || (e || t) && n) throw new we("stripe.redirectToCheckout: Expected only one of sku, plan, or items.");
            if ("string" == typeof e) return [{
                sku: e,
                quantity: 1
            }];
            if ("string" == typeof t) return [{
                plan: t,
                quantity: 1
            }];
            if (n) return n.map(function (e) {
                return "sku" === e.type ? {
                    sku: e.id,
                    quantity: e.quantity
                } : {
                    plan: e.id,
                    quantity: e.quantity
                }
            });
            throw new we("stripe.redirectToCheckout: You must provide either sku, plan, or items.")
        },
        gs = function (e) {
            var t = vt(ys({}, vs, {
                    items: Qe(Ze(ht(vt({
                        type: tt("plan"),
                        quantity: ut(0),
                        id: it
                    })), ht(vt({
                        type: tt("sku"),
                        quantity: ut(0),
                        id: it
                    })))),
                    successUrl: it,
                    cancelUrl: it
                })),
                n = wt(t, e, "stripe.redirectToCheckout"),
                r = n.value,
                o = r.sku,
                i = r.plan,
                a = r.items,
                s = ue(r, ["sku", "plan", "items"]),
                c = bs(o, i, a);
            return ys({
                tag: "no-session",
                items: c
            }, s)
        },
        ws = function (e, t) {
            var n = vt(ys({}, vs, {
                    sessionId: Qe(it),
                    successUrl: Qe(it),
                    cancelUrl: Qe(it),
                    items: Qe(Ze(ht(vt({
                        quantity: ut(0),
                        plan: it
                    })), ht(vt({
                        quantity: ut(0),
                        sku: it
                    }))))
                })),
                r = wt(n, e, "stripe.redirectToCheckout"),
                o = r.value;
            if (o.sessionId) {
                var i = o.sessionId;
                if (Object.keys(o).length > 1) throw new we("stripe.redirectToCheckout: Do not provide other parameters when providing sessionId. Specify all parameters on your server when creating the CheckoutSession.");
                if (!/^cs_/.test(i)) throw new we("stripe.redirectToCheckout: Invalid value for sessionId. You specified '" + i + "'.");
                if ("livemode" === t && /^cs_test_/.test(i)) throw new we("stripe.redirectToCheckout: the provided sessionId is for a test mode Checkout Session, whereas Stripe.js was initialized with a live mode publishable key.");
                if ("testmode" === t && /^cs_live_/.test(i)) throw new we("stripe.redirectToCheckout: the provided sessionId is for a live mode Checkout Session, whereas Stripe.js was initialized with a test mode publishable key.");
                return {
                    tag: "session",
                    sessionId: i
                }
            }
            var a = (o.sessionId, o.sku, o.plan, o.items),
                s = o.successUrl,
                c = o.cancelUrl,
                u = ue(o, ["sessionId", "sku", "plan", "items", "successUrl", "cancelUrl"]);
            if (!a) throw new we("stripe.redirectToCheckout: You must provide one of items or sessionId.");
            if (!s || !c) throw new we("stripe.redirectToCheckout: You must provide successUrl and cancelUrl.");
            return ys({
                tag: "no-session",
                items: a,
                successUrl: s,
                cancelUrl: c
            }, u)
        },
        Es = function (e, t) {
            var n = ws(e, t);
            if ("no-session" === n.tag) {
                var r = n.successUrl,
                    o = n.cancelUrl;
                if (!kt(r)) throw new we("stripe.redirectToCheckout: successUrl must start with either http:// or https://.");
                if (!kt(o)) throw new we("stripe.redirectToCheckout: cancelUrl must start with either http:// or https://.");
                return n
            }
            return n
        },
        ks = function (e, t, n) {
            if (n && n.paymentMethodTypes) {
                if (-1 === t.indexOf("checkout_pm_types")) throw new we("Invalid stripe.redirectToCheckout parameter: paymentMethodTypes is not an accepted parameter.");
                if (e) throw new we("Invalid stripe.redirectToCheckout parameter: paymentMethodTypes is not an accepted parameter for " + e + ". Please follow our migration guide to update to the final version of Checkout: https://stripe.com/docs/payments/checkout/migration-from-beta")
            }
        },
        Ss = function (e, t) {
            return "session" === t.tag || null == e || t.locale || -1 === ["auto"].concat(le(ms)).indexOf(e) ? t : ys({}, t, {
                locale: e
            })
        },
        Os = function (e, t, n) {
            var r = Ie(ds, function (t) {
                return vo(e, t)
            });
            switch (ks(r, e, t), r) {
                case "checkout_beta_2":
                    return gs(t);
                case "checkout_beta_3":
                    return ws(t, n);
                case "checkout_beta_4":
                default:
                    return Es(t, n)
            }
        },
        Ps = function (e, t, n) {
            var r = arguments.length > 3 && void 0 !== arguments[3] ? arguments[3] : "unknown";
            return Ss(t, Os(e, n, r))
        },
        As = Ps,
        Ts = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Is = function (e, t) {
            var n = function (t) {
                return Fa(e, "redirectToCheckout", t), {
                    error: t.error
                }
            };
            return xa(t).then(n)
        },
        js = function (e, t, n, r) {
            return function (o) {
                e.report("redirect_to_checkout.options", {
                    betas: t,
                    options: o,
                    globalLocale: r
                });
                var i = As(t, r, o, e.livemode());
                if ("session" === i.tag) {
                    var a = i,
                        s = a.sessionId;
                    return e.action.createPaymentPageWithSession({
                        betas: t,
                        mids: n(),
                        sessionId: s
                    }).then(function (t) {
                        if ("error" === t.type) return {
                            error: t.error
                        };
                        var n = t.object.url;
                        return Is(e, n)
                    })
                }
                var c = i,
                    u = (c.tag, c.items),
                    l = c.successUrl,
                    p = c.cancelUrl,
                    f = c.clientReferenceId,
                    d = c.customerEmail,
                    h = c.billingAddressCollection,
                    _ = c.submitType,
                    m = c.paymentMethodTypes,
                    y = pe(c, ["tag", "items", "successUrl", "cancelUrl", "clientReferenceId", "customerEmail", "billingAddressCollection", "submitType", "paymentMethodTypes"]),
                    v = u.map(function (e) {
                        if (e.sku) return {
                            type: "sku",
                            id: e.sku,
                            quantity: e.quantity
                        };
                        if (e.plan) return {
                            type: "plan",
                            id: e.plan,
                            quantity: e.quantity
                        };
                        throw new Error("Unexpected item shape.")
                    }),
                    b = Ie(ds, function (e) {
                        return vo(t, e)
                    });
                return e.action.createPaymentPage(Ts({
                    betas: t,
                    mids: n(),
                    items: v,
                    success_url: l,
                    cancel_url: p,
                    client_reference_id: f,
                    customer_email: d,
                    billing_address_collection: h,
                    submit_type: _,
                    payment_method_types: m,
                    use_payment_methods: !b
                }, y)).then(function (t) {
                    if ("error" === t.type) return {
                        error: t.error
                    };
                    var n = t.object.url;
                    return Is(e, n)
                })
            }
        },
        Cs = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Rs = function (e) {
            switch (e.type) {
                case "object":
                    return {
                        token: e.object
                    };
                case "error":
                    return {
                        error: e.error
                    };
                default:
                    return Ee(e)
            }
        },
        Ms = function (e) {
            return "object" === (void 0 === e ? "undefined" : Cs(e)) && null !== e ? e : {}
        },
        Ns = function (e, t, n) {
            var r = ka(t);
            if (r && "cardCvc" === r._componentName) {
                var o = r._frame.id;
                return e.action.tokenizeCvcUpdate({
                    frameId: o,
                    mids: n
                }).then(Rs)
            }
            throw new we("You must provide a `cardCvc` Element to create a `cvc_update` token.")
        },
        qs = function (e, t) {
            return function (n, r) {
                var o = ka(n);
                if (o) {
                    var i = o._frame.id,
                        a = o._componentName,
                        s = Ms(r);
                    return e.action.tokenizeWithElement({
                        frameId: i,
                        elementName: a,
                        tokenData: s,
                        mids: t
                    }).then(Rs)
                }
                if ("string" == typeof n) {
                    var c = n,
                        u = Ms(r);
                    return e.action.tokenizeWithData({
                        elementName: null,
                        type: c,
                        tokenData: u,
                        mids: t
                    }).then(Rs)
                }
                throw new we("You must provide a Stripe Element or a valid token type to create a Token.")
            }
        },
        Ls = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Ds = function () {
            function e(e, t) {
                for (var n = 0; n < t.length; n++) {
                    var r = t[n];
                    r.enumerable = r.enumerable || !1, r.configurable = !0, "value" in r && (r.writable = !0), Object.defineProperty(e, r.key, r)
                }
            }
            return function (t, n, r) {
                return n && e(t.prototype, n), r && e(t, r), t
            }
        }(),
        xs = bt({
            apiKey: it,
            stripeAccount: Qe(it),
            locale: Qe(it),
            __privateApiUrl: Qe(it),
            __checkout: Qe(bt({
                mids: bt({
                    muid: it,
                    sid: it
                })
            })),
            __hosted3DS: Qe(st),
            betas: Qe(ht(nt.apply(void 0, de(yo))))
        }),
        Fs = function (e) {
            return "You have an in-flight " + e + "! Please be sure to disable your form submit button when " + e + " is called."
        },
        Bs = function () {
            function e(t, n) {
                var r = this;
                fe(this, e), Us.call(this);
                var o = wt(xs, t || {}, "Stripe()"),
                    i = o.value,
                    a = o.warnings,
                    s = i.apiKey,
                    c = i.stripeAccount,
                    u = i.locale,
                    l = i.__privateApiUrl,
                    p = i.__checkout,
                    f = i.__hosted3DS,
                    d = i.betas;
                if ("" === s) throw new we("Please call Stripe() with your publishable key. You used an empty string.");
                if (0 === s.indexOf("sk_")) throw new we("You should not use your secret key with Stripe.js.\n        Please pass a publishable key instead.");
                p && p.mids && (e._ec = new ga({
                    checkoutIds: p.mids
                })), this._apiKey = s, this._keyMode = ze(s), this._locale = u || null, this._betas = d || [], this._stripeAccount = c || null, this._isCheckout = !!p, this._controller = new Rr(Ls({
                    apiKey: s,
                    __privateApiUrl: l,
                    stripeAccount: c,
                    betas: this._betas,
                    stripeJsId: e.stripeJsId
                }, this._locale ? {
                    locale: this._locale
                } : {})), a.forEach(function (e) {
                    return r._controller.warn(e)
                }), this._ensureHTTPS(), this._ensureStripeHosted(n), this._attachPaymentIntentMethods(this._betas, !!f), this._attachCheckoutMethods(this._betas), this._attachPrivateMethodsForCheckout(this._isCheckout), this._warnIE9Deprecation()
            }
            return Ds(e, [{
                key: "_attachPaymentIntentMethods",
                value: function (e, t) {
                    var n = this,
                        r = vo(this._betas, mo.payment_intent_beta_1) || vo(this._betas, mo.payment_intent_beta_2),
                        o = function () {
                            return n._mids()
                        },
                        i = un(function () {
                            for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];
                            return Za.apply(void 0, [n._controller, o()].concat(t))
                        }),
                        a = sn(function (e) {
                            return Xa(e, n._controller)
                        }),
                        s = un(function () {
                            for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];
                            return es.apply(void 0, [!0, n._controller, o()].concat(t))
                        }),
                        c = un(function () {
                            for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];
                            return es.apply(void 0, [!1, n._controller, o()].concat(t))
                        }),
                        u = jn(rs, Fs("handleCardPayment")),
                        l = un(function () {
                            for (var e = arguments.length, t = Array(e), i = 0; i < e; i++) t[i] = arguments[i];
                            return u.apply(void 0, [!0, n._controller, o(), r].concat(t))
                        }),
                        p = un(function () {
                            for (var e = arguments.length, t = Array(e), i = 0; i < e; i++) t[i] = arguments[i];
                            return u.apply(void 0, [!1, n._controller, o(), r].concat(t))
                        }),
                        f = jn(ns, Fs("handleCardAction")),
                        d = sn(function (e) {
                            return f(e, n._controller)
                        }),
                        h = jn(ls, Fs("handleCardSetup")),
                        _ = un(function () {
                            for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];
                            return h.apply(void 0, [n._controller, o()].concat(t))
                        }),
                        m = sn(function (e) {
                            return ps(e, n._controller)
                        }),
                        y = un(function () {
                            for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];
                            return fs.apply(void 0, [n._controller, o()].concat(t))
                        }),
                        v = un(function () {
                            for (var e = arguments.length, t = Array(e), i = 0; i < e; i++) t[i] = arguments[i];
                            return os.apply(void 0, [n._controller, o(), r].concat(t))
                        }),
                        b = un(function () {
                            for (var e = arguments.length, t = Array(e), i = 0; i < e; i++) t[i] = arguments[i];
                            return is.apply(void 0, [n._controller, o(), r].concat(t))
                        }),
                        g = cn(function () {
                            for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];
                            return ts.apply(void 0, [n._controller].concat(t))
                        });
                    this.createPaymentMethod = i, this.retrievePaymentIntent = a, this.handleCardPayment = p, this.confirmPaymentIntent = c, this.handleCardAction = d, this.handleCardSetup = _, this.retrieveSetupIntent = m, this.confirmSetupIntent = y;
                    var w = function (e) {
                        return function () {
                            throw new we("You cannot call `stripe." + e + "` without supplying a PaymentIntents beta flag when initializing Stripe.js.        You can find more information including code snippets at https://www.stripe.com/docs/payments/payment-intents/quickstart.")
                        }
                    };
                    this.fulfillPaymentIntent = w("fulfillPaymentIntent"), this.handleSepaDebitPayment = w("handleSepaDebitPayment"), this.handleIdealPayment = w("handleIdealPayment"), vo(this._betas, mo.payment_intent_beta_1) ? this.fulfillPaymentIntent = l : (vo(this._betas, mo.payment_intent_beta_3) || vo(this._betas, mo.payment_intent_beta_2)) && (this.handleCardPayment = l), vo(this._betas, mo.payment_intent_beta_3) && (this.confirmPaymentIntent = s, this.handleSepaDebitPayment = v, this.handleIdealPayment = b), t && (this.handleHosted3DS2 = g)
                }
            }, {
                key: "_attachPrivateMethodsForCheckout",
                value: function (e) {
                    var t = this;
                    e && (this.tryNextAction = cn(function (e, n) {
                        var r = wt(sa, e, "Payment Intent"),
                            o = r.value,
                            i = Object.keys(la).map(function (e) {
                                return la[e]
                            }),
                            a = wt(tt.apply(void 0, de(i)), n, "Source type"),
                            s = a.value;
                        return "payment_intent" === o.object ? Ja(t._controller, o, s, "auto") : ss(t._controller, o, s, "auto")
                    }))
                }
            }, {
                key: "_attachCheckoutMethods",
                value: function (e) {
                    var t = this,
                        n = function () {
                            return t._mids()
                        },
                        r = e.reduce(function (e, t) {
                            var n = Ie(hs, function (e) {
                                return e === t
                            });
                            return n ? [].concat(de(e), [n]) : e
                        }, []);
                    this.redirectToCheckout = js(this._controller, r, n, this._locale)
                }
            }, {
                key: "_warnIE9Deprecation",
                value: function () {
                    var e = this._keyMode === Ue.live,
                        t = "Starting in December 2018, stripe.js v3 will no longer support IE9, per Microsoft's lifecycle policy.\n\nThis error is being thrown only in IE9 in testmode so that you have an opportunity to update your integration or your browser testing strategy.\n\nIf you want to suppress this error in testmode until December, initialize stripe.js with the `acknowledge_ie9_deprecation` beta:\nvar stripe = Stripe(key, {betas: ['acknowledge_ie9_deprecation']})";
                    if (pr && !e && !vo(this._betas, mo.acknowledge_ie9_deprecation)) throw window.console && console.error(t), new we(t)
                }
            }, {
                key: "_ensureHTTPS",
                value: function () {
                    var e = window.location.protocol,
                        t = -1 !== ["https:", "file:"].indexOf(e),
                        n = -1 !== ["localhost", "127.0.0.1", "0.0.0.0"].indexOf(window.location.hostname),
                        r = this._keyMode === Ue.live,
                        o = "Live Stripe.js integrations must use HTTPS. For more information: https://stripe.com/docs/stripe-js/elements/quickstart#http-requirements";
                    if (!t) {
                        if (r && !n) throw this._controller.report("user_error.non_https_error", {
                            protocol: e
                        }), new we(o);
                        !r || n ? window.console && console.warn("You may test your Stripe.js integration over HTTP. However, live Stripe.js integrations must use HTTPS.") : window.console && console.warn(o)
                    }
                }
            }, {
                key: "_ensureStripeHosted",
                value: function (e) {
                    if (!e) throw this._controller.report("user_error.self_hosted"), new we("Stripe.js must be loaded from js.stripe.com. For more information https://stripe.com/docs/stripe-js/reference#including-stripejs")
                }
            }, {
                key: "_mids",
                value: function () {
                    return e._ec ? e._ec.ids() : null
                }
            }]), e
        }();
    Bs.version = 3, Bs.stripeJsId = Wt(), Bs._ec = function () {
        return "https://checkout.stripe.com/".match(new RegExp(document.location.protocol + "//" + document.location.host)) ? null : new ga
    }();
    var Us = function () {
            var e = this;
            this.elements = sn(function (t) {
                return new Ji(e._controller, Ls({}, e._locale ? {
                    locale: e._locale
                } : {}, t))
            }), this.createToken = cn(function (t, n) {
                var r = e._mids();
                if ("cvc_update" === t) {
                    if (vo(e._betas, mo.cvc_update_beta_1)) return Ns(e._controller, n, r);
                    throw new we("You cannot create a 'cvc_update' token without using the 'cvc_update_beta_1' beta flag.")
                }
                return qs(e._controller, r)(t, n)
            }), this.createSource = cn(function (t, n) {
                var r = ka(t),
                    o = Ma(r ? n : t),
                    i = o || {
                        type: null,
                        data: {}
                    },
                    a = i.type,
                    s = i.data;
                if (r) {
                    var c = r._frame.id,
                        u = r._componentName;
                    return !o && fa(u) ? Pe.reject(new we("Please provide Source creation parameters to createSource.")) : e._controller.action.createSourceWithElement({
                        frameId: c,
                        elementName: u,
                        type: a,
                        sourceData: s,
                        mids: e._mids()
                    }).then(Na)
                }
                return o ? a ? e._controller.action.createSourceWithData({
                    elementName: null,
                    type: a,
                    sourceData: s,
                    mids: e._mids()
                }).then(Na) : Pe.reject(new we("Please provide a source type to createSource.")) : Pe.reject(new we("Please provide either an Element or Source creation parameters to createSource."))
            }), this.retrieveSource = sn(function (t) {
                var n = wt(La, {
                        source: t
                    }, "retrieveSource"),
                    r = n.value;
                return n.warnings.forEach(function (t) {
                    return e._controller.warn(t)
                }), e._controller.action.retrieveSource(r).then(Na)
            }), this.paymentRequest = cn(function (t, n) {
                He(e._keyMode);
                var r = e._isCheckout && n ? n : null;
                return Zi(e._controller, {
                    apiKey: e._apiKey,
                    accountId: e._stripeAccount
                }, e._mids(), t, e._betas, r)
            })
        },
        zs = Bs,
        Hs = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (e) {
            return typeof e
        } : function (e) {
            return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
        },
        Ys = Object.assign || function (e) {
            for (var t = 1; t < arguments.length; t++) {
                var n = arguments[t];
                for (var r in n) Object.prototype.hasOwnProperty.call(n, r) && (e[r] = n[r])
            }
            return e
        },
        Ws = function () {
            if (document.currentScript) {
                var e = St(document.currentScript.src);
                return !e || Xn(e.origin)
            }
            return !0
        }(),
        Gs = function (e, t) {
            return new zs(Ys({
                apiKey: e
            }, t && "object" === (void 0 === t ? "undefined" : Hs(t)) ? t : {}), Ws)
        };
    Gs.version = zs.version, window.Stripe && 2 === window.Stripe.version && !window.Stripe.StripeV3 ? window.Stripe.StripeV3 = Gs : window.Stripe ? window.console && console.warn("It looks like Stripe.js was loaded more than one time. Please only load it once per page.") : window.Stripe = Gs;
    t.default = Gs
}, function (e, t, n) {
    "use strict";

    function r(e) {
        var t = new o(o._61);
        return t._81 = 1, t._65 = e, t
    }
    var o = n(3);
    e.exports = o;
    var i = r(!0),
        a = r(!1),
        s = r(null),
        c = r(void 0),
        u = r(0),
        l = r("");
    o.resolve = function (e) {
        if (e instanceof o) return e;
        if (null === e) return s;
        if (void 0 === e) return c;
        if (!0 === e) return i;
        if (!1 === e) return a;
        if (0 === e) return u;
        if ("" === e) return l;
        if ("object" == typeof e || "function" == typeof e) try {
            var t = e.then;
            if ("function" == typeof t) return new o(t.bind(e))
        } catch (e) {
            return new o(function (t, n) {
                n(e)
            })
        }
        return r(e)
    }, o.all = function (e) {
        var t = Array.prototype.slice.call(e);
        return new o(function (e, n) {
            function r(a, s) {
                if (s && ("object" == typeof s || "function" == typeof s)) {
                    if (s instanceof o && s.then === o.prototype.then) {
                        for (; 3 === s._81;) s = s._65;
                        return 1 === s._81 ? r(a, s._65) : (2 === s._81 && n(s._65), void s.then(function (e) {
                            r(a, e)
                        }, n))
                    }
                    var c = s.then;
                    if ("function" == typeof c) {
                        return void new o(c.bind(s)).then(function (e) {
                            r(a, e)
                        }, n)
                    }
                }
                t[a] = s, 0 == --i && e(t)
            }
            if (0 === t.length) return e([]);
            for (var i = t.length, a = 0; a < t.length; a++) r(a, t[a])
        })
    }, o.reject = function (e) {
        return new o(function (t, n) {
            n(e)
        })
    }, o.race = function (e) {
        return new o(function (t, n) {
            e.forEach(function (e) {
                o.resolve(e).then(t, n)
            })
        })
    }, o.prototype.catch = function (e) {
        return this.then(null, e)
    }
}, function (e, t, n) {
    "use strict";

    function r() {}

    function o(e) {
        try {
            return e.then
        } catch (e) {
            return y = e, v
        }
    }

    function i(e, t) {
        try {
            return e(t)
        } catch (e) {
            return y = e, v
        }
    }

    function a(e, t, n) {
        try {
            e(t, n)
        } catch (e) {
            return y = e, v
        }
    }

    function s(e) {
        if ("object" != typeof this) throw new TypeError("Promises must be constructed via new");
        if ("function" != typeof e) throw new TypeError("not a function");
        this._45 = 0, this._81 = 0, this._65 = null, this._54 = null, e !== r && _(e, this)
    }

    function c(e, t, n) {
        return new e.constructor(function (o, i) {
            var a = new s(r);
            a.then(o, i), u(e, new h(t, n, a))
        })
    }

    function u(e, t) {
        for (; 3 === e._81;) e = e._65;
        if (s._10 && s._10(e), 0 === e._81) return 0 === e._45 ? (e._45 = 1, void(e._54 = t)) : 1 === e._45 ? (e._45 = 2, void(e._54 = [e._54, t])) : void e._54.push(t);
        l(e, t)
    }

    function l(e, t) {
        m(function () {
            var n = 1 === e._81 ? t.onFulfilled : t.onRejected;
            if (null === n) return void(1 === e._81 ? p(t.promise, e._65) : f(t.promise, e._65));
            var r = i(n, e._65);
            r === v ? f(t.promise, y) : p(t.promise, r)
        })
    }

    function p(e, t) {
        if (t === e) return f(e, new TypeError("A promise cannot be resolved with itself."));
        if (t && ("object" == typeof t || "function" == typeof t)) {
            var n = o(t);
            if (n === v) return f(e, y);
            if (n === e.then && t instanceof s) return e._81 = 3, e._65 = t, void d(e);
            if ("function" == typeof n) return void _(n.bind(t), e)
        }
        e._81 = 1, e._65 = t, d(e)
    }

    function f(e, t) {
        e._81 = 2, e._65 = t, s._97 && s._97(e, t), d(e)
    }

    function d(e) {
        if (1 === e._45 && (u(e, e._54), e._54 = null), 2 === e._45) {
            for (var t = 0; t < e._54.length; t++) u(e, e._54[t]);
            e._54 = null
        }
    }

    function h(e, t, n) {
        this.onFulfilled = "function" == typeof e ? e : null, this.onRejected = "function" == typeof t ? t : null, this.promise = n
    }

    function _(e, t) {
        var n = !1,
            r = a(e, function (e) {
                n || (n = !0, p(t, e))
            }, function (e) {
                n || (n = !0, f(t, e))
            });
        n || r !== v || (n = !0, f(t, y))
    }
    var m = n(4),
        y = null,
        v = {};
    e.exports = s, s._10 = null, s._97 = null, s._61 = r, s.prototype.then = function (e, t) {
        if (this.constructor !== s) return c(this, e, t);
        var n = new s(r);
        return u(this, new h(e, t, n)), n
    }
}, function (e, t, n) {
    "use strict";
    (function (t) {
        function n(e) {
            a.length || (i(), s = !0), a[a.length] = e
        }

        function r() {
            for (; c < a.length;) {
                var e = c;
                if (c += 1, a[e].call(), c > u) {
                    for (var t = 0, n = a.length - c; t < n; t++) a[t] = a[t + c];
                    a.length -= c, c = 0
                }
            }
            a.length = 0, c = 0, s = !1
        }

        function o(e) {
            return function () {
                function t() {
                    clearTimeout(n), clearInterval(r), e()
                }
                var n = setTimeout(t, 0),
                    r = setInterval(t, 50)
            }
        }
        e.exports = n;
        var i, a = [],
            s = !1,
            c = 0,
            u = 1024,
            l = void 0 !== t ? t : self,
            p = l.MutationObserver || l.WebKitMutationObserver;
        i = "function" == typeof p ? function (e) {
            var t = 1,
                n = new p(e),
                r = document.createTextNode("");
            return n.observe(r, {
                    characterData: !0
                }),
                function () {
                    t = -t, r.data = t
                }
        }(r) : o(r), n.requestFlush = i, n.makeRequestCallFromTimer = o
    }).call(t, n(5))
}, function (e, t) {
    var n;
    n = function () {
        return this
    }();
    try {
        n = n || Function("return this")() || (0, eval)("this")
    } catch (e) {
        "object" == typeof window && (n = window)
    }
    e.exports = n
}, function (e, t, n) {
    var r, o;
    ! function () {
        "use strict";
        var n = function () {
            function e() {}

            function t(e, t) {
                for (var n = t.length, r = 0; r < n; ++r) i(e, t[r])
            }

            function n(e, t) {
                e[t] = !0
            }

            function r(e, t) {
                for (var n in t) s.call(t, n) && (e[n] = !!t[n])
            }

            function o(e, t) {
                for (var n = t.split(c), r = n.length, o = 0; o < r; ++o) e[n[o]] = !0
            }

            function i(e, i) {
                if (i) {
                    var a = typeof i;
                    "string" === a ? o(e, i) : Array.isArray(i) ? t(e, i) : "object" === a ? r(e, i) : "number" === a && n(e, i)
                }
            }

            function a() {
                for (var n = arguments.length, r = Array(n), o = 0; o < n; o++) r[o] = arguments[o];
                var i = new e;
                t(i, r);
                var a = [];
                for (var s in i) i[s] && a.push(s);
                return a.join(" ")
            }
            e.prototype = Object.create(null);
            var s = {}.hasOwnProperty,
                c = /\s+/;
            return a
        }();
        void 0 !== e && e.exports ? e.exports = n : (r = [], void 0 !== (o = function () {
            return n
        }.apply(t, r)) && (e.exports = o))
    }()
}, function (e, t) {}]);
