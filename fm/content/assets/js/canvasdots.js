$.fn.canvaDots = function(o) {
    this.options = {}, this.options.speed = 2, this.options.sizeMultiplier = .5, this.options.showDirectionVector = !1, this.options.showConnections = !0, this.options.sizeDependConnections = !1, this.options.magnetPowerDelimiter = 10, this.options.mouseReaction = !0, this.options.randomBounceSides = !0, this.options.fillCircles = !1, this.options.moveDirection = "random", this.options.dotsColor = [255, 255, 255, 1], this.options.linesColor = [255, 255, 255];
    var t, i, s = this;
    t = document.getElementById(this.attr("id")), i = t.getContext("2d");
    var n, e, r, a = .4;
    this.attr("width", s.parent().innerWidth()).attr("height", s.parent().innerHeight()), n = this.innerWidth(), e = this.innerHeight();
    var p = Math.pow(n * e, a),
        h = function(o, t, i) {
            var s, n = !1,
                i = !!i;
            for (s in t)
                if (i && t[s] === o || !i && t[s] == o) {
                    n = !0;
                    break
                }
            return n
        },
        c = function() {
            return Math.random() * (2 * s.options.speed) - s.options.speed
        },
        l = function(o, t) {
            for (var i = t + 1; i < C.length; i++) {
                var n = Math.pow(Math.pow(C[i].x - o.x, 2) + Math.pow(C[i].y - o.y, 2), .5);
                r >= n && (s.options.showConnections && d(o.x, o.y, C[i].x, C[i].y, n), C[t].connections++, C[i].connections++)
            }
        },
        d = function(o, t, n, e, a) {
            i.beginPath(), i.moveTo(o, t), i.lineTo(n, e);
            var p = 1 - a / r;
            i.strokeStyle = "rgba(" + s.options.linesColor[0] + ", " + s.options.linesColor[1] + ", " + s.options.linesColor[2] + ", " + p + ")", i.stroke()
        },
        f = function() {
            y();
            for (var o = 0; o < C.length; o++) {
                switch ((s.options.showConnections || s.options.sizeDependConnections) && l(C[o], o), u(C[o]), C[o].connections = 0, s.options.moveDirection) {
                    case "up":
                        C[o].y += C[o].s_y, C[o].s_x = 0;
                        break;
                    case "down":
                        C[o].y += C[o].s_y, C[o].s_x = 0;
                        break;
                    case "left":
                        C[o].x += C[o].s_x, C[o].s_y = 0;
                        break;
                    case "right":
                        C[o].x += C[o].s_x, C[o].s_y = 0;
                        break;
                    default:
                        C[o].x += C[o].s_x, C[o].y += C[o].s_y
                }
                if (C[o].x >= n) {
                    switch (s.options.moveDirection) {
                        case "right":
                            C[o].x = 0;
                            break;
                        default:
                            C[o].x = n, C[o].s_x *= -1
                    }(s.options.randomBounceSides || "random" != s.options.moveDirection) && (C[o].s_x = c(), C[o].s_y = c()), "right" == s.options.moveDirection && (C[o].y = Math.ceil(Math.random() * e))
                }
                if (C[o].x <= 0) {
                    switch (s.options.moveDirection) {
                        case "left":
                            C[o].x = n;
                            break;
                        default:
                            C[o].x = 0, C[o].s_x *= -1
                    }(s.options.randomBounceSides || "random" != s.options.moveDirection) && (C[o].s_x = c(), C[o].s_y = c()), "left" == s.options.moveDirection && (C[o].y = Math.ceil(Math.random() * e))
                }
                if (C[o].y >= e) {
                    switch (s.options.moveDirection) {
                        case "down":
                            C[o].y = 0;
                            break;
                        default:
                            C[o].y = e, C[o].s_y *= -1
                    }(s.options.randomBounceSides || "random" != s.options.moveDirection) && (C[o].s_y = c(), C[o].s_x = c()), "down" == s.options.moveDirection && (C[o].x = Math.ceil(Math.random() * n))
                }
                if (C[o].y <= 0) {
                    switch (s.options.moveDirection) {
                        case "up":
                            C[o].y = e;
                            break;
                        default:
                            C[o].y = 0, C[o].s_y *= -1
                    }(s.options.randomBounceSides || "random" != s.options.moveDirection) && (C[o].s_y = c(), C[o].s_x = c()), "up" == s.options.moveDirection && (C[o].x = Math.ceil(Math.random() * n))
                }
                switch (s.options.randomBounceSides || "random" == s.options.moveDirection || ((C[o].s_y > s.options.speed || 0 == C[o].s_y) && (C[o].s_y = c()), (C[o].s_x > s.options.speed || 0 == C[o].s_x) && (C[o].s_x = c())), s.options.moveDirection) {
                    case "up":
                        C[o].s_y = -1 * Math.pow(Math.pow(C[o].s_y, 2), .5);
                        break;
                    case "down":
                        C[o].s_y = Math.pow(Math.pow(C[o].s_y, 2), .5);
                        break;
                    case "left":
                        C[o].s_x = -1 * Math.pow(Math.pow(C[o].s_x, 2), .5);
                        break;
                    case "right":
                        C[o].s_x = Math.pow(Math.pow(C[o].s_x, 2), .5)
                }
                "random" == s.options.moveDirection && m(C[o], o)
            }
        },
        m = function(o, t) {
            for (var i in w) {
                var n = Math.pow(Math.pow(w[i].x - o.x, 2) + Math.pow(w[i].y - o.y, 2), .5);
                r >= n && (o.x < w[i].x ? o.y < w[i].y ? C[t].s_x -= (1 - (w[i].x - o.x) / r) * (1 - (w[i].y - o.y) / r) * s.options.speed / s.options.magnetPowerDelimiter : C[t].s_x -= (1 - (w[i].x - o.x) / r) * (1 - (o.y - w[i].y) / r) * s.options.speed / s.options.magnetPowerDelimiter : o.y < w[i].y ? C[t].s_x += (1 - (o.x - w[i].x) / r) * (1 - (w[i].y - o.y) / r) * s.options.speed / s.options.magnetPowerDelimiter : C[t].s_x += (1 - (o.x - w[i].x) / r) * (1 - (o.y - w[i].y) / r) * s.options.speed / s.options.magnetPowerDelimiter, o.y < w[i].y ? o.x < w[i].x ? C[t].s_y -= (1 - (w[i].y - o.y) / r) * (1 - (w[i].x - o.x) / r) * s.options.speed / s.options.magnetPowerDelimiter : C[t].s_y -= (1 - (w[i].y - o.y) / r) * (1 - (o.x - w[i].x) / r) * s.options.speed / s.options.magnetPowerDelimiter : o.x < w[i].x ? C[t].s_y += (1 - (o.y - w[i].y) / r) * (1 - (w[i].x - o.x) / r) * s.options.speed / s.options.magnetPowerDelimiter : C[t].s_y += (1 - (o.y - w[i].y) / r) * (1 - (o.x - w[i].x) / r) * s.options.speed / s.options.magnetPowerDelimiter)
            }
        },
        y = function() {
            i.clearRect(0, 0, t.width, t.height)
        },
        u = function(o) {
            i.beginPath(), i.strokeStyle = "rgba(" + s.options.dotsColor[0] + ", " + s.options.dotsColor[1] + ", " + s.options.dotsColor[2] + ", " + s.options.dotsColor[3] + ")";
            var t = 2;
            s.options.sizeDependConnections && (t = o.connections * s.options.sizeMultiplier + 1), i.arc(o.x, o.y, t, 0, 2 * Math.PI), s.options.fillCircles && (i.fillStyle = "rgba(" + s.options.dotsColor[0] + ", " + s.options.dotsColor[1] + ", " + s.options.dotsColor[2] + ", " + s.options.dotsColor[3] + ")", i.fill()), i.stroke(), s.options.showDirectionVector && (i.beginPath(), i.moveTo(o.x, o.y), i.lineTo(o.x + 10 * o.s_x, o.y + 10 * o.s_y), i.strokeStyle = "rgba(" + s.options.linesColor[0] + ", " + s.options.linesColor[1] + ", " + s.options.linesColor[2] + ", 0.25)", i.stroke())
        };
    for (var x in o) this.options[x] = o[x];
    this.options.speed < 0 && (this.options.speed = 0), this.options.sizeMultiplier < 0 && (this.options.sizeMultiplier = 0), "boolean" != typeof this.options.showDirectionVector && (this.options.showDirectionVector = !1), "boolean" != typeof this.options.showConnections && (this.options.showConnections = !0), "boolean" != typeof this.options.sizeDependConnections && (this.options.sizeDependConnections = !1), "boolean" != typeof this.options.mouseReaction && (this.options.mouseReaction = !0), "boolean" != typeof this.options.randomBounceSides && (this.options.randomBounceSides = !0), this.options.magnetPowerDelimiter < 0 && (this.options.magnetPowerDelimiter = 0), h(this.options.moveDirection, ["up", "down", "left", "right", "random"]) || (this.options.moveDirection = "random"), "boolean" != typeof this.options.fillCircles && (this.options.fillCircles = !0), (4 != this.options.dotsColor.length || this.options.dotsColor[0] < 0 || this.options.dotsColor[0] > 255 || this.options.dotsColor[1] < 0 || this.options.dotsColor[1] > 255 || this.options.dotsColor[2] < 0 || this.options.dotsColor[2] > 255 || this.options.dotsColor[3] < 0 || this.options.dotsColor[3] > 1) && (this.options.dotsColor = [255, 255, 255, 1]), (3 != this.options.linesColor.length || this.options.linesColor[0] < 0 || this.options.linesColor[0] > 255 || this.options.linesColor[1] < 0 || this.options.linesColor[1] > 255 || this.options.linesColor[2] < 0 || this.options.linesColor[2] > 255) && (this.options.linesColor = [255, 255, 255]), s = this;
    for (var C = [], v = 0; p > v; v++) C[v] = Array(), C[v].s_x = c(), C[v].s_y = c(), C[v].x = Math.ceil(Math.random() * n), C[v].y = Math.ceil(Math.random() * e), C[v].r_x = -1, C[v].r_y = -1, C[v].connections = 0;
    r = Math.pow(n * e, .7) / C.length;
    var w = [];
    return w[0] = {}, w[0].x = -1e3, w[0].y = -1e3, this.setSpeed = function(o) {
        return parseInt(o) >= 0 ? (this.options.speed = parseInt(o), !0) : !1
    }, this.setSizeDependConnections = function(o) {
        return "boolean" == typeof o ? (this.options.sizeDependConnections = o, s = this, !0) : !1
    }, this.setSizeMultiplier = function(o) {
        return parseFloat(o) >= 0 ? (this.options.sizeMultiplier = parseFloat(o), s = this, !0) : !1
    }, this.setShowDirectionVector = function(o) {
        return "boolean" == typeof o ? (this.options.showDirectionVector = o, s = this, !0) : !1
    }, this.setShowConnections = function(o) {
        return "boolean" == typeof o ? (this.options.showConnections = o, s = this, !0) : !1
    }, this.setMouseReaction = function(o) {
        return "boolean" == typeof o ? (this.options.mouseReaction = o, this.options.mouseReaction || (w[0].x = -1e3, w[0].y = -1e3), s = this, !0) : !1
    }, this.setRandomBounceSides = function(o) {
        return "boolean" == typeof o ? (this.options.randomBounceSides = o, s = this, !0) : !1
    }, this.setMoveDirection = function(o) {
        return h(o, ["up", "down", "left", "right", "random"]) ? (this.options.moveDirection = o, s = this, !0) : !1
    }, this.setFillCircles = function(o) {
        return "boolean" != typeof o ? (this.options.fillCircles = o, !0) : !1
    }, this.setDotsColor = function(o) {
        return 4 == o.length && o[0] >= 0 && o[0] <= 255 && o[1] >= 0 && o[1] <= 255 && o[2] >= 0 && o[2] <= 255 && o[3] >= 0 && o[3] <= 1 ? (this.options.dotsColor = o, s = this, !0) : !1
    }, this.setLinesColor = function(o) {
        return 3 == o.length && o[0] < 0 && o[0] > 255 && o[1] < 0 && o[1] > 255 && o[2] < 0 && o[2] > 255 ? (this.options.linesColor = o, s = this, !0) : !1
    }, this.loadMagnetDots = function(o) {
        w = [], w[0] = {}, w[0].x = -1e3, w[0].y = -1e3;
        for (var t = 1; t <= o.length; t++) w[t] = o[t - 1];
        return console.log(w), !0
    }, this.stopAnimation = function() {
        return clearTimeout(this.timeout), !0
    }, this.startAnimation = function() {
        return this.timeout = setInterval(function() {
            f()
        }, 20), !0
    }, $(window).resize(function() {
        s.attr("width", s.parent().innerWidth()).attr("height", s.parent().innerHeight()), n = s.innerWidth(), e = s.innerHeight(), r = Math.pow(n * e, .7) / C.length, s.options.mouseReaction && "random" == s.options.moveDirection && (w[0].x = Math.ceil(n / 2), w[0].y = Math.ceil(e / 2))
    }), this.mousemove(function(o) {
        s.options.mouseReaction && "random" == s.options.moveDirection && (w[0].x = o.offsetX, w[0].y = o.offsetY)
    }), this.startAnimation(), this
};
