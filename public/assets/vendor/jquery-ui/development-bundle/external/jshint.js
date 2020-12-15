var JSHINT = (function () {
    "use strict";
    var anonname,       
        bang = {
            "<"  : true,
            "<=" : true,
            "==" : true,
            "===": true,
            "!==": true,
            "!=" : true,
            ">"  : true,
            ">=" : true,
            "+"  : true,
            "-"  : true,
            "*"  : true,
            "/"  : true,
            "%"  : true
        },
        boolOptions = {
            asi         : true, 
            bitwise     : true, 
            boss        : true, 
            browser     : true, 
            camelcase   : true, 
            couch       : true, 
            curly       : true, 
            debug       : true, 
            devel       : true, 
            dojo        : true, 
            eqeqeq      : true, 
            eqnull      : true, 
            es5         : true, 
            esnext      : true, 
            evil        : true, 
            expr        : true, 
            forin       : true, 
            funcscope   : true, 
            globalstrict: true, 
            immed       : true, 
            iterator    : true, 
            jquery      : true, 
            lastsemic   : true, 
            latedef     : true, 
            laxbreak    : true, 
            laxcomma    : true, 
            loopfunc    : true, 
            mootools    : true, 
            multistr    : true, 
            newcap      : true, 
            noarg       : true, 
            node        : true, 
            noempty     : true, 
            nonew       : true, 
            nonstandard : true, 
            nomen       : true, 
            onevar      : true, 
            onecase     : true, 
            passfail    : true, 
            plusplus    : true, 
            proto       : true, 
            prototypejs : true, 
            regexdash   : true, 
            regexp      : true, 
            rhino       : true, 
            undef       : true, 
            unused      : true, 
            scripturl   : true, 
            shadow      : true, 
            smarttabs   : true, 
            strict      : true, 
            sub         : true, 
            supernew    : true, 
            trailing    : true, 
            validthis   : true, 
            withstmt    : true, 
            white       : true, 
            worker      : true, 
            wsh         : true, 
            yui         : true  
        },
        valOptions = {
            maxlen       : false,
            indent       : false,
            maxerr       : false,
            predef       : false,
            quotmark     : false, 
            scope        : false,
            maxstatements: false, 
            maxdepth     : false, 
            maxparams    : false, 
            maxcomplexity: false  
        },
        invertedOptions = {
            bitwise     : true,
            forin       : true,
            newcap      : true,
            nomen       : true,
            plusplus    : true,
            regexp      : true,
            undef       : true,
            white       : true,
            eqeqeq      : true,
            onevar      : true
        },
        renamedOptions = {
            eqeq        : "eqeqeq",
            vars        : "onevar",
            windows     : "wsh"
        },
        browser = {
            ArrayBuffer              :  false,
            ArrayBufferView          :  false,
            Audio                    :  false,
            Blob                     :  false,
            addEventListener         :  false,
            applicationCache         :  false,
            atob                     :  false,
            blur                     :  false,
            btoa                     :  false,
            clearInterval            :  false,
            clearTimeout             :  false,
            close                    :  false,
            closed                   :  false,
            DataView                 :  false,
            DOMParser                :  false,
            defaultStatus            :  false,
            document                 :  false,
            event                    :  false,
            FileReader               :  false,
            Float32Array             :  false,
            Float64Array             :  false,
            FormData                 :  false,
            focus                    :  false,
            frames                   :  false,
            getComputedStyle         :  false,
            HTMLElement              :  false,
            HTMLAnchorElement        :  false,
            HTMLBaseElement          :  false,
            HTMLBlockquoteElement    :  false,
            HTMLBodyElement          :  false,
            HTMLBRElement            :  false,
            HTMLButtonElement        :  false,
            HTMLCanvasElement        :  false,
            HTMLDirectoryElement     :  false,
            HTMLDivElement           :  false,
            HTMLDListElement         :  false,
            HTMLFieldSetElement      :  false,
            HTMLFontElement          :  false,
            HTMLFormElement          :  false,
            HTMLFrameElement         :  false,
            HTMLFrameSetElement      :  false,
            HTMLHeadElement          :  false,
            HTMLHeadingElement       :  false,
            HTMLHRElement            :  false,
            HTMLHtmlElement          :  false,
            HTMLIFrameElement        :  false,
            HTMLImageElement         :  false,
            HTMLInputElement         :  false,
            HTMLIsIndexElement       :  false,
            HTMLLabelElement         :  false,
            HTMLLayerElement         :  false,
            HTMLLegendElement        :  false,
            HTMLLIElement            :  false,
            HTMLLinkElement          :  false,
            HTMLMapElement           :  false,
            HTMLMenuElement          :  false,
            HTMLMetaElement          :  false,
            HTMLModElement           :  false,
            HTMLObjectElement        :  false,
            HTMLOListElement         :  false,
            HTMLOptGroupElement      :  false,
            HTMLOptionElement        :  false,
            HTMLParagraphElement     :  false,
            HTMLParamElement         :  false,
            HTMLPreElement           :  false,
            HTMLQuoteElement         :  false,
            HTMLScriptElement        :  false,
            HTMLSelectElement        :  false,
            HTMLStyleElement         :  false,
            HTMLTableCaptionElement  :  false,
            HTMLTableCellElement     :  false,
            HTMLTableColElement      :  false,
            HTMLTableElement         :  false,
            HTMLTableRowElement      :  false,
            HTMLTableSectionElement  :  false,
            HTMLTextAreaElement      :  false,
            HTMLTitleElement         :  false,
            HTMLUListElement         :  false,
            HTMLVideoElement         :  false,
            history                  :  false,
            Int16Array               :  false,
            Int32Array               :  false,
            Int8Array                :  false,
            Image                    :  false,
            length                   :  false,
            localStorage             :  false,
            location                 :  false,
            MessageChannel           :  false,
            MessageEvent             :  false,
            MessagePort              :  false,
            moveBy                   :  false,
            moveTo                   :  false,
            MutationObserver         :  false,
            name                     :  false,
            Node                     :  false,
            NodeFilter               :  false,
            navigator                :  false,
            onbeforeunload           :  true,
            onblur                   :  true,
            onerror                  :  true,
            onfocus                  :  true,
            onload                   :  true,
            onresize                 :  true,
            onunload                 :  true,
            open                     :  false,
            openDatabase             :  false,
            opener                   :  false,
            Option                   :  false,
            parent                   :  false,
            print                    :  false,
            removeEventListener      :  false,
            resizeBy                 :  false,
            resizeTo                 :  false,
            screen                   :  false,
            scroll                   :  false,
            scrollBy                 :  false,
            scrollTo                 :  false,
            sessionStorage           :  false,
            setInterval              :  false,
            setTimeout               :  false,
            SharedWorker             :  false,
            status                   :  false,
            top                      :  false,
            Uint16Array              :  false,
            Uint32Array              :  false,
            Uint8Array               :  false,
            WebSocket                :  false,
            window                   :  false,
            Worker                   :  false,
            XMLHttpRequest           :  false,
            XMLSerializer            :  false,
            XPathEvaluator           :  false,
            XPathException           :  false,
            XPathExpression          :  false,
            XPathNamespace           :  false,
            XPathNSResolver          :  false,
            XPathResult              :  false
        },
        couch = {
            "require" : false,
            respond   : false,
            getRow    : false,
            emit      : false,
            send      : false,
            start     : false,
            sum       : false,
            log       : false,
            exports   : false,
            module    : false,
            provides  : false
        },
        declared, 
        devel = {
            alert   : false,
            confirm : false,
            console : false,
            Debug   : false,
            opera   : false,
            prompt  : false
        },
        dojo = {
            dojo      : false,
            dijit     : false,
            dojox     : false,
            define    : false,
            "require" : false
        },
        funct,          
        functionicity = [
            "closure", "exception", "global", "label",
            "outer", "unused", "var"
        ],
        functions,      
        global,         
        implied,        
        inblock,
        indent,
        jsonmode,
        jquery = {
            "$"    : false,
            jQuery : false
        },
        lines,
        lookahead,
        member,
        membersOnly,
        mootools = {
            "$"             : false,
            "$$"            : false,
            Asset           : false,
            Browser         : false,
            Chain           : false,
            Class           : false,
            Color           : false,
            Cookie          : false,
            Core            : false,
            Document        : false,
            DomReady        : false,
            DOMEvent        : false,
            DOMReady        : false,
            Drag            : false,
            Element         : false,
            Elements        : false,
            Event           : false,
            Events          : false,
            Fx              : false,
            Group           : false,
            Hash            : false,
            HtmlTable       : false,
            Iframe          : false,
            IframeShim      : false,
            InputValidator  : false,
            instanceOf      : false,
            Keyboard        : false,
            Locale          : false,
            Mask            : false,
            MooTools        : false,
            Native          : false,
            Options         : false,
            OverText        : false,
            Request         : false,
            Scroller        : false,
            Slick           : false,
            Slider          : false,
            Sortables       : false,
            Spinner         : false,
            Swiff           : false,
            Tips            : false,
            Type            : false,
            typeOf          : false,
            URI             : false,
            Window          : false
        },
        nexttoken,
        node = {
            __filename    : false,
            __dirname     : false,
            Buffer        : false,
            console       : false,
            exports       : true,  
            GLOBAL        : false,
            global        : false,
            module        : false,
            process       : false,
            require       : false,
            setTimeout    : false,
            clearTimeout  : false,
            setInterval   : false,
            clearInterval : false
        },
        noreach,
        option,
        predefined,     
        prereg,
        prevtoken,
        prototypejs = {
            "$"               : false,
            "$$"              : false,
            "$A"              : false,
            "$F"              : false,
            "$H"              : false,
            "$R"              : false,
            "$break"          : false,
            "$continue"       : false,
            "$w"              : false,
            Abstract          : false,
            Ajax              : false,
            Class             : false,
            Enumerable        : false,
            Element           : false,
            Event             : false,
            Field             : false,
            Form              : false,
            Hash              : false,
            Insertion         : false,
            ObjectRange       : false,
            PeriodicalExecuter: false,
            Position          : false,
            Prototype         : false,
            Selector          : false,
            Template          : false,
            Toggle            : false,
            Try               : false,
            Autocompleter     : false,
            Builder           : false,
            Control           : false,
            Draggable         : false,
            Draggables        : false,
            Droppables        : false,
            Effect            : false,
            Sortable          : false,
            SortableObserver  : false,
            Sound             : false,
            Scriptaculous     : false
        },
        quotmark,
        rhino = {
            defineClass  : false,
            deserialize  : false,
            gc           : false,
            help         : false,
            importPackage: false,
            "java"       : false,
            load         : false,
            loadClass    : false,
            print        : false,
            quit         : false,
            readFile     : false,
            readUrl      : false,
            runCommand   : false,
            seal         : false,
            serialize    : false,
            spawn        : false,
            sync         : false,
            toint32      : false,
            version      : false
        },
        scope,      
        stack,
        standard = {
            Array               : false,
            Boolean             : false,
            Date                : false,
            decodeURI           : false,
            decodeURIComponent  : false,
            encodeURI           : false,
            encodeURIComponent  : false,
            Error               : false,
            "eval"              : false,
            EvalError           : false,
            Function            : false,
            hasOwnProperty      : false,
            isFinite            : false,
            isNaN               : false,
            JSON                : false,
            Map                 : false,
            Math                : false,
            NaN                 : false,
            Number              : false,
            Object              : false,
            parseInt            : false,
            parseFloat          : false,
            RangeError          : false,
            ReferenceError      : false,
            RegExp              : false,
            Set                 : false,
            String              : false,
            SyntaxError         : false,
            TypeError           : false,
            URIError            : false,
            WeakMap             : false
        },
        nonstandard = {
            escape              : false,
            unescape            : false
        },
        directive,
        syntax = {},
        tab,
        token,
        unuseds,
        urls,
        useESNextSyntax,
        warnings,
        worker = {
            importScripts       : true,
            postMessage         : true,
            self                : true
        },
        wsh = {
            ActiveXObject             : true,
            Enumerator                : true,
            GetObject                 : true,
            ScriptEngine              : true,
            ScriptEngineBuildVersion  : true,
            ScriptEngineMajorVersion  : true,
            ScriptEngineMinorVersion  : true,
            VBArray                   : true,
            WSH                       : true,
            WScript                   : true,
            XDomainRequest            : true
        },
        yui = {
            YUI             : false,
            Y               : false,
            YUI_config      : false
        };
    var ax, cx, tx, nx, nxg, lx, ix, jx, ft;
    (function () {
        ax = /@cc|<\/?|script|\]\s*\]|<\s*!|&lt/i;
        cx = /[\u0000-\u001f\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/;
        tx = /^\s*([(){}\[.,:;'"~\?\]#@]|==?=?|\/=(?!(\S*\/[gim]?))|\/(\*(jshint|jslint|members?|global)?|\/)?|\*[\/=]?|\+(?:=|\++)?|-(?:=|-+)?|%=?|&[&=]?|\|[|=]?|>>?>?=?|<([\/=!]|\!(\[|--)?|<=?)?|\^=?|\!=?=?|[a-zA-Z_$][a-zA-Z0-9_$]*|[0-9]+([xX][0-9a-fA-F]+|\.[0-9]*)?([eE][+\-]?[0-9]+)?)/;
        nx = /[\u0000-\u001f&<"\/\\\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/;
        nxg = /[\u0000-\u001f&<"\/\\\u007f-\u009f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g;
        lx = /\*\
        
        ix = /^([a-zA-Z_$][a-zA-Z0-9_$]*)$/;
        jx = /^(?:javascript|jscript|ecmascript|vbscript|mocha|livescript)\s*:/i;
        ft = /^\s*\/\*\s*falls\sthrough\s*\*\/\s*$/;
    }());
    function F() {}     
    function is_own(object, name) {
        return Object.prototype.hasOwnProperty.call(object, name);
    }
    function checkOption(name, t) {
        if (valOptions[name] === undefined && boolOptions[name] === undefined) {
            warning("Bad option: '" + name + "'.", t);
        }
    }
    function isString(obj) {
        return Object.prototype.toString.call(obj) === "[object String]";
    }
    if (typeof Array.isArray !== "function") {
        Array.isArray = function (o) {
            return Object.prototype.toString.apply(o) === "[object Array]";
        };
    }
    if (!Array.prototype.forEach) {
        Array.prototype.forEach = function (fn, scope) {
            var len = this.length;
            for (var i = 0; i < len; i++) {
                fn.call(scope || this, this[i], i, this);
            }
        };
    }
    if (!Array.prototype.indexOf) {
        Array.prototype.indexOf = function (searchElement  ) {
            if (this === null || this === undefined) {
                throw new TypeError();
            }
            var t = new Object(this);
            var len = t.length >>> 0;
            if (len === 0) {
                return -1;
            }
            var n = 0;
            if (arguments.length > 0) {
                n = Number(arguments[1]);
                if (n != n) { 
                    n = 0;
                } else if (n !== 0 && n != Infinity && n != -Infinity) {
                    n = (n > 0 || -1) * Math.floor(Math.abs(n));
                }
            }
            if (n >= len) {
                return -1;
            }
            var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
            for (; k < len; k++) {
                if (k in t && t[k] === searchElement) {
                    return k;
                }
            }
            return -1;
        };
    }
    if (typeof Object.create !== "function") {
        Object.create = function (o) {
            F.prototype = o;
            return new F();
        };
    }
    if (typeof Object.keys !== "function") {
        Object.keys = function (o) {
            var a = [], k;
            for (k in o) {
                if (is_own(o, k)) {
                    a.push(k);
                }
            }
            return a;
        };
    }
    function isAlpha(str) {
        return (str >= "a" && str <= "z\uffff") ||
            (str >= "A" && str <= "Z\uffff");
    }
    function isDigit(str) {
        return (str >= "0" && str <= "9");
    }
    function isIdentifier(token, value) {
        if (!token)
            return false;
        if (!token.identifier || token.value !== value)
            return false;
        return true;
    }
    function supplant(str, data) {
        return str.replace(/\{([^{}]*)\}/g, function (a, b) {
            var r = data[b];
            return typeof r === "string" || typeof r === "number" ? r : a;
        });
    }
    function combine(t, o) {
        var n;
        for (n in o) {
            if (is_own(o, n) && !is_own(JSHINT.blacklist, n)) {
                t[n] = o[n];
            }
        }
    }
    function updatePredefined() {
        Object.keys(JSHINT.blacklist).forEach(function (key) {
            delete predefined[key];
        });
    }
    function assume() {
        if (option.couch) {
            combine(predefined, couch);
        }
        if (option.rhino) {
            combine(predefined, rhino);
        }
        if (option.prototypejs) {
            combine(predefined, prototypejs);
        }
        if (option.node) {
            combine(predefined, node);
            option.globalstrict = true;
        }
        if (option.devel) {
            combine(predefined, devel);
        }
        if (option.dojo) {
            combine(predefined, dojo);
        }
        if (option.browser) {
            combine(predefined, browser);
        }
        if (option.nonstandard) {
            combine(predefined, nonstandard);
        }
        if (option.jquery) {
            combine(predefined, jquery);
        }
        if (option.mootools) {
            combine(predefined, mootools);
        }
        if (option.worker) {
            combine(predefined, worker);
        }
        if (option.wsh) {
            combine(predefined, wsh);
        }
        if (option.esnext) {
            useESNextSyntax();
        }
        if (option.globalstrict && option.strict !== false) {
            option.strict = true;
        }
        if (option.yui) {
            combine(predefined, yui);
        }
    }
    function quit(message, line, chr) {
        var percentage = Math.floor((line / lines.length) * 100);
        throw {
            name: "JSHintError",
            line: line,
            character: chr,
            message: message + " (" + percentage + "% scanned).",
            raw: message
        };
    }
    function isundef(scope, m, t, a) {
        return JSHINT.undefs.push([scope, m, t, a]);
    }
    function warning(m, t, a, b, c, d) {
        var ch, l, w;
        t = t || nexttoken;
        if (t.id === "(end)") {  
            t = token;
        }
        l = t.line || 0;
        ch = t.from || 0;
        w = {
            id: "(error)",
            raw: m,
            evidence: lines[l - 1] || "",
            line: l,
            character: ch,
            scope: JSHINT.scope,
            a: a,
            b: b,
            c: c,
            d: d
        };
        w.reason = supplant(m, w);
        JSHINT.errors.push(w);
        if (option.passfail) {
            quit("Stopping. ", l, ch);
        }
        warnings += 1;
        if (warnings >= option.maxerr) {
            quit("Too many errors.", l, ch);
        }
        return w;
    }
    function warningAt(m, l, ch, a, b, c, d) {
        return warning(m, {
            line: l,
            from: ch
        }, a, b, c, d);
    }
    function error(m, t, a, b, c, d) {
        warning(m, t, a, b, c, d);
    }
    function errorAt(m, l, ch, a, b, c, d) {
        return error(m, {
            line: l,
            from: ch
        }, a, b, c, d);
    }
    function addInternalSrc(elem, src) {
        var i;
        i = {
            id: "(internal)",
            elem: elem,
            value: src
        };
        JSHINT.internals.push(i);
        return i;
    }
    var lex = (function lex() {
        var character, from, line, s;
        function nextLine() {
            var at,
                match,
                tw; 
            if (line >= lines.length)
                return false;
            character = 1;
            s = lines[line];
            line += 1;
            if (option.smarttabs) {
                match = s.match(/(\/\/)? \t/);
                at = match && !match[1] ? 0 : -1;
            } else {
                at = s.search(/ \t|\t [^\*]/);
            }
            if (at >= 0)
                warningAt("Mixed spaces and tabs.", line, at + 1);
            s = s.replace(/\t/g, tab);
            at = s.search(cx);
            if (at >= 0)
                warningAt("Unsafe character.", line, at);
            if (option.maxlen && option.maxlen < s.length)
                warningAt("Line too long.", line, s.length);
            tw = option.trailing && s.match(/^(.*?)\s+$/);
            if (tw && !/^\s+$/.test(s)) {
                warningAt("Trailing whitespace.", line, tw[1].length + 1);
            }
            return true;
        }
        function it(type, value) {
            var i, t;
            function checkName(name) {
                if (!option.proto && name === "__proto__") {
                    warningAt("The '{a}' property is deprecated.", line, from, name);
                    return;
                }
                if (!option.iterator && name === "__iterator__") {
                    warningAt("'{a}' is only available in JavaScript 1.7.", line, from, name);
                    return;
                }
                var hasDangling = /^(_+.*|.*_+)$/.test(name);
                if (option.nomen && hasDangling && name !== "_") {
                    if (option.node && token.id !== "." && /^(__dirname|__filename)$/.test(name))
                        return;
                    warningAt("Unexpected {a} in '{b}'.", line, from, "dangling '_'", name);
                    return;
                }
                if (option.camelcase) {
                    if (name.replace(/^_+/, "").indexOf("_") > -1 && !name.match(/^[A-Z0-9_]*$/)) {
                        warningAt("Identifier '{a}' is not in camel case.", line, from, value);
                    }
                }
            }
            if (type === "(color)" || type === "(range)") {
                t = {type: type};
            } else if (type === "(punctuator)" ||
                    (type === "(identifier)" && is_own(syntax, value))) {
                t = syntax[value] || syntax["(error)"];
            } else {
                t = syntax[type];
            }
            t = Object.create(t);
            if (type === "(string)" || type === "(range)") {
                if (!option.scripturl && jx.test(value)) {
                    warningAt("Script URL.", line, from);
                }
            }
            if (type === "(identifier)") {
                t.identifier = true;
                checkName(value);
            }
            t.value = value;
            t.line = line;
            t.character = character;
            t.from = from;
            i = t.id;
            if (i !== "(endline)") {
                prereg = i &&
                    (("(,=:[!&|?{};".indexOf(i.charAt(i.length - 1)) >= 0) ||
                    i === "return" ||
                    i === "case");
            }
            return t;
        }
        return {
            init: function (source) {
                if (typeof source === "string") {
                    lines = source
                        .replace(/\r\n/g, "\n")
                        .replace(/\r/g, "\n")
                        .split("\n");
                } else {
                    lines = source;
                }
                if (lines[0] && lines[0].substr(0, 2) === "#!")
                    lines[0] = "";
                line = 0;
                nextLine();
                from = 1;
            },
            range: function (begin, end) {
                var c, value = "";
                from = character;
                if (s.charAt(0) !== begin) {
                    errorAt("Expected '{a}' and instead saw '{b}'.",
                            line, character, begin, s.charAt(0));
                }
                for (;;) {
                    s = s.slice(1);
                    character += 1;
                    c = s.charAt(0);
                    switch (c) {
                    case "":
                        errorAt("Missing '{a}'.", line, character, c);
                        break;
                    case end:
                        s = s.slice(1);
                        character += 1;
                        return it("(range)", value);
                    case "\\":
                        warningAt("Unexpected '{a}'.", line, character, c);
                    }
                    value += c;
                }
            },
            token: function () {
                var b, c, captures, d, depth, high, i, l, low, q, t, isLiteral, isInRange, n;
                function match(x) {
                    var r = x.exec(s), r1;
                    if (r) {
                        l = r[0].length;
                        r1 = r[1];
                        c = r1.charAt(0);
                        s = s.substr(l);
                        from = character + l - r1.length;
                        character += l;
                        return r1;
                    }
                }
                function string(x) {
                    var c, j, r = "", allowNewLine = false;
                    if (jsonmode && x !== "\"") {
                        warningAt("Strings must use doublequote.",
                                line, character);
                    }
                    if (option.quotmark) {
                        if (option.quotmark === "single" && x !== "'") {
                            warningAt("Strings must use singlequote.",
                                    line, character);
                        } else if (option.quotmark === "double" && x !== "\"") {
                            warningAt("Strings must use doublequote.",
                                    line, character);
                        } else if (option.quotmark === true) {
                            quotmark = quotmark || x;
                            if (quotmark !== x) {
                                warningAt("Mixed double and single quotes.",
                                        line, character);
                            }
                        }
                    }
                    function esc(n) {
                        var i = parseInt(s.substr(j + 1, n), 16);
                        j += n;
                        if (i >= 32 && i <= 126 &&
                                i !== 34 && i !== 92 && i !== 39) {
                            warningAt("Unnecessary escapement.", line, character);
                        }
                        character += n;
                        c = String.fromCharCode(i);
                    }
                    j = 0;
unclosedString:
                    for (;;) {
                        while (j >= s.length) {
                            j = 0;
                            var cl = line, cf = from;
                            if (!nextLine()) {
                                errorAt("Unclosed string.", cl, cf);
                                break unclosedString;
                            }
                            if (allowNewLine) {
                                allowNewLine = false;
                            } else {
                                warningAt("Unclosed string.", cl, cf);
                            }
                        }
                        c = s.charAt(j);
                        if (c === x) {
                            character += 1;
                            s = s.substr(j + 1);
                            return it("(string)", r, x);
                        }
                        if (c < " ") {
                            if (c === "\n" || c === "\r") {
                                break;
                            }
                            warningAt("Control character in string: {a}.",
                                    line, character + j, s.slice(0, j));
                        } else if (c === "\\") {
                            j += 1;
                            character += 1;
                            c = s.charAt(j);
                            n = s.charAt(j + 1);
                            switch (c) {
                            case "\\":
                            case "\"":
                            case "/":
                                break;
                            case "\'":
                                if (jsonmode) {
                                    warningAt("Avoid \\'.", line, character);
                                }
                                break;
                            case "b":
                                c = "\b";
                                break;
                            case "f":
                                c = "\f";
                                break;
                            case "n":
                                c = "\n";
                                break;
                            case "r":
                                c = "\r";
                                break;
                            case "t":
                                c = "\t";
                                break;
                            case "0":
                                c = "\0";
                                if (n >= 0 && n <= 7 && directive["use strict"]) {
                                    warningAt(
                                    "Octal literals are not allowed in strict mode.",
                                    line, character);
                                }
                                break;
                            case "u":
                                esc(4);
                                break;
                            case "v":
                                if (jsonmode) {
                                    warningAt("Avoid \\v.", line, character);
                                }
                                c = "\v";
                                break;
                            case "x":
                                if (jsonmode) {
                                    warningAt("Avoid \\x-.", line, character);
                                }
                                esc(2);
                                break;
                            case "":
                                allowNewLine = true;
                                if (option.multistr) {
                                    if (jsonmode) {
                                        warningAt("Avoid EOL escapement.", line, character);
                                    }
                                    c = "";
                                    character -= 1;
                                    break;
                                }
                                warningAt("Bad escapement of EOL. Use option multistr if needed.",
                                    line, character);
                                break;
                            case "!":
                                if (s.charAt(j - 2) === "<")
                                    break;
                            default:
                                warningAt("Bad escapement.", line, character);
                            }
                        }
                        r += c;
                        character += 1;
                        j += 1;
                    }
                }
                for (;;) {
                    if (!s) {
                        return it(nextLine() ? "(endline)" : "(end)", "");
                    }
                    t = match(tx);
                    if (!t) {
                        t = "";
                        c = "";
                        while (s && s < "!") {
                            s = s.substr(1);
                        }
                        if (s) {
                            errorAt("Unexpected '{a}'.", line, character, s.substr(0, 1));
                            s = "";
                        }
                    } else {
                        if (isAlpha(c) || c === "_" || c === "$") {
                            return it("(identifier)", t);
                        }
                        if (isDigit(c)) {
                            if (!isFinite(Number(t))) {
                                warningAt("Bad number '{a}'.",
                                    line, character, t);
                            }
                            if (isAlpha(s.substr(0, 1))) {
                                warningAt("Missing space after '{a}'.",
                                        line, character, t);
                            }
                            if (c === "0") {
                                d = t.substr(1, 1);
                                if (isDigit(d)) {
                                    if (token.id !== ".") {
                                        warningAt("Don't use extra leading zeros '{a}'.",
                                            line, character, t);
                                    }
                                } else if (jsonmode && (d === "x" || d === "X")) {
                                    warningAt("Avoid 0x-. '{a}'.",
                                            line, character, t);
                                }
                            }
                            if (t.substr(t.length - 1) === ".") {
                                warningAt(
"A trailing decimal point can be confused with a dot '{a}'.", line, character, t);
                            }
                            return it("(number)", t);
                        }
                        switch (t) {
                        case "\"":
                        case "'":
                            return string(t);
                        case "
                            s = "";
                            token.comment = true;
                            break;
                        case "":
                            return {
                                value: t,
                                type: "special",
                                line: line,
                                character: character,
                                from: from
                            };
                        case "":
                            break;
                        case "/":
                            if (s.charAt(0) === "=") {
                                errorAt("A regular expression literal can be confused with '/='.",
                                    line, from);
                            }
                            if (prereg) {
                                depth = 0;
                                captures = 0;
                                l = 0;
                                for (;;) {
                                    b = true;
                                    c = s.charAt(l);
                                    l += 1;
                                    switch (c) {
                                    case "":
                                        errorAt("Unclosed regular expression.", line, from);
                                        return quit("Stopping.", line, from);
                                    case "/":
                                        if (depth > 0) {
                                            warningAt("{a} unterminated regular expression " +
                                                "group(s).", line, from + l, depth);
                                        }
                                        c = s.substr(0, l - 1);
                                        q = {
                                            g: true,
                                            i: true,
                                            m: true
                                        };
                                        while (q[s.charAt(l)] === true) {
                                            q[s.charAt(l)] = false;
                                            l += 1;
                                        }
                                        character += l;
                                        s = s.substr(l);
                                        q = s.charAt(0);
                                        if (q === "/" || q === "*") {
                                            errorAt("Confusing regular expression.",
                                                    line, from);
                                        }
                                        return it("(regexp)", c);
                                    case "\\":
                                        c = s.charAt(l);
                                        if (c < " ") {
                                            warningAt(
"Unexpected control character in regular expression.", line, from + l);
                                        } else if (c === "<") {
                                            warningAt(
"Unexpected escaped character '{a}' in regular expression.", line, from + l, c);
                                        }
                                        l += 1;
                                        break;
                                    case "(":
                                        depth += 1;
                                        b = false;
                                        if (s.charAt(l) === "?") {
                                            l += 1;
                                            switch (s.charAt(l)) {
                                            case ":":
                                            case "=":
                                            case "!":
                                                l += 1;
                                                break;
                                            default:
                                                warningAt(
"Expected '{a}' and instead saw '{b}'.", line, from + l, ":", s.charAt(l));
                                            }
                                        } else {
                                            captures += 1;
                                        }
                                        break;
                                    case "|":
                                        b = false;
                                        break;
                                    case ")":
                                        if (depth === 0) {
                                            warningAt("Unescaped '{a}'.",
                                                    line, from + l, ")");
                                        } else {
                                            depth -= 1;
                                        }
                                        break;
                                    case " ":
                                        q = 1;
                                        while (s.charAt(l) === " ") {
                                            l += 1;
                                            q += 1;
                                        }
                                        if (q > 1) {
                                            warningAt(
"Spaces are hard to count. Use {{a}}.", line, from + l, q);
                                        }
                                        break;
                                    case "[":
                                        c = s.charAt(l);
                                        if (c === "^") {
                                            l += 1;
                                            if (s.charAt(l) === "]") {
                                                errorAt("Unescaped '{a}'.",
                                                    line, from + l, "^");
                                            }
                                        }
                                        if (c === "]") {
                                            warningAt("Empty class.", line,
                                                    from + l - 1);
                                        }
                                        isLiteral = false;
                                        isInRange = false;
klass:
                                        do {
                                            c = s.charAt(l);
                                            l += 1;
                                            switch (c) {
                                            case "[":
                                            case "^":
                                                warningAt("Unescaped '{a}'.",
                                                        line, from + l, c);
                                                if (isInRange) {
                                                    isInRange = false;
                                                } else {
                                                    isLiteral = true;
                                                }
                                                break;
                                            case "-":
                                                if (isLiteral && !isInRange) {
                                                    isLiteral = false;
                                                    isInRange = true;
                                                } else if (isInRange) {
                                                    isInRange = false;
                                                } else if (s.charAt(l) === "]") {
                                                    isInRange = true;
                                                } else {
                                                    if (option.regexdash !== (l === 2 || (l === 3 &&
                                                        s.charAt(1) === "^"))) {
                                                        warningAt("Unescaped '{a}'.",
                                                            line, from + l - 1, "-");
                                                    }
                                                    isLiteral = true;
                                                }
                                                break;
                                            case "]":
                                                if (isInRange && !option.regexdash) {
                                                    warningAt("Unescaped '{a}'.",
                                                            line, from + l - 1, "-");
                                                }
                                                break klass;
                                            case "\\":
                                                c = s.charAt(l);
                                                if (c < " ") {
                                                    warningAt(
"Unexpected control character in regular expression.", line, from + l);
                                                } else if (c === "<") {
                                                    warningAt(
"Unexpected escaped character '{a}' in regular expression.", line, from + l, c);
                                                }
                                                l += 1;
                                                if (/[wsd]/i.test(c)) {
                                                    if (isInRange) {
                                                        warningAt("Unescaped '{a}'.",
                                                            line, from + l, "-");
                                                        isInRange = false;
                                                    }
                                                    isLiteral = false;
                                                } else if (isInRange) {
                                                    isInRange = false;
                                                } else {
                                                    isLiteral = true;
                                                }
                                                break;
                                            case "/":
                                                warningAt("Unescaped '{a}'.",
                                                        line, from + l - 1, "/");
                                                if (isInRange) {
                                                    isInRange = false;
                                                } else {
                                                    isLiteral = true;
                                                }
                                                break;
                                            case "<":
                                                if (isInRange) {
                                                    isInRange = false;
                                                } else {
                                                    isLiteral = true;
                                                }
                                                break;
                                            default:
                                                if (isInRange) {
                                                    isInRange = false;
                                                } else {
                                                    isLiteral = true;
                                                }
                                            }
                                        } while (c);
                                        break;
                                    case ".":
                                        if (option.regexp) {
                                            warningAt("Insecure '{a}'.", line,
                                                    from + l, c);
                                        }
                                        break;
                                    case "]":
                                    case "?":
                                    case "{":
                                    case "}":
                                    case "+":
                                    case "*":
                                        warningAt("Unescaped '{a}'.", line,
                                                from + l, c);
                                    }
                                    if (b) {
                                        switch (s.charAt(l)) {
                                        case "?":
                                        case "+":
                                        case "*":
                                            l += 1;
                                            if (s.charAt(l) === "?") {
                                                l += 1;
                                            }
                                            break;
                                        case "{":
                                            l += 1;
                                            c = s.charAt(l);
                                            if (c < "0" || c > "9") {
                                                warningAt(
"Expected a number and instead saw '{a}'.", line, from + l, c);
                                                break; 
                                            }
                                            l += 1;
                                            low = +c;
                                            for (;;) {
                                                c = s.charAt(l);
                                                if (c < "0" || c > "9") {
                                                    break;
                                                }
                                                l += 1;
                                                low = +c + (low * 10);
                                            }
                                            high = low;
                                            if (c === ",") {
                                                l += 1;
                                                high = Infinity;
                                                c = s.charAt(l);
                                                if (c >= "0" && c <= "9") {
                                                    l += 1;
                                                    high = +c;
                                                    for (;;) {
                                                        c = s.charAt(l);
                                                        if (c < "0" || c > "9") {
                                                            break;
                                                        }
                                                        l += 1;
                                                        high = +c + (high * 10);
                                                    }
                                                }
                                            }
                                            if (s.charAt(l) !== "}") {
                                                warningAt(
"Expected '{a}' and instead saw '{b}'.", line, from + l, "}", c);
                                            } else {
                                                l += 1;
                                            }
                                            if (s.charAt(l) === "?") {
                                                l += 1;
                                            }
                                            if (low > high) {
                                                warningAt(
"'{a}' should not be greater than '{b}'.", line, from + l, low, high);
                                            }
                                        }
                                    }
                                }
                                c = s.substr(0, l - 1);
                                character += l;
                                s = s.substr(l);
                                return it("(regexp)", c);
                            }
                            return it("(punctuator)", t);
                        case "#":
                            return it("(punctuator)", t);
                        default:
                            return it("(punctuator)", t);
                        }
                    }
                }
            }
        };
    }());
    function addlabel(t, type, token) {
        if (t === "hasOwnProperty") {
            warning("'hasOwnProperty' is a really bad name.");
        }
        if (type === "exception") {
            if (is_own(funct["(context)"], t)) {
                if (funct[t] !== true && !option.node) {
                    warning("Value of '{a}' may be overwritten in IE.", nexttoken, t);
                }
            }
        }
        if (is_own(funct, t) && !funct["(global)"]) {
            if (funct[t] === true) {
                if (option.latedef)
                    warning("'{a}' was used before it was defined.", nexttoken, t);
            } else {
                if (!option.shadow && type !== "exception") {
                    warning("'{a}' is already defined.", nexttoken, t);
                }
            }
        }
        funct[t] = type;
        if (token) {
            funct["(tokens)"][t] = token;
        }
        if (funct["(global)"]) {
            global[t] = funct;
            if (is_own(implied, t)) {
                if (option.latedef)
                    warning("'{a}' was used before it was defined.", nexttoken, t);
                delete implied[t];
            }
        } else {
            scope[t] = funct;
        }
    }
    function doOption() {
        var nt = nexttoken;
        var o  = nt.value;
        var quotmarkValue = option.quotmark;
        var predef = {};
        var b, obj, filter, t, tn, v, minus;
        switch (o) {
        case "*/":
            error("Unbegun comment.");
            break;
        case "") {
                    break loop;
                }
                if (t.id !== "(endline)" && t.id !== ",") {
                    break;
                }
                t = lex.token();
            }
            if (o === "", ":");
                }
                if (o === "
    function directives() {
        var i, p, pn;
        for (;;) {
            if (nexttoken.id === "(string)") {
                p = peek(0);
                if (p.id === "(endline)") {
                    i = 1;
                    do {
                        pn = peek(i);
                        i = i + 1;
                    } while (pn.id === "(endline)");
                    if (pn.id !== ";") {
                        if (pn.id !== "(string)" && pn.id !== "(number)" &&
                            pn.id !== "(regexp)" && pn.identifier !== true &&
                            pn.id !== "}") {
                            break;
                        }
                        warning("Missing semicolon.", nexttoken);
                    } else {
                        p = pn;
                    }
                } else if (p.id === "}") {
                    warning("Missing semicolon.", p);
                } else if (p.id !== ";") {
                    break;
                }
                indentation();
                advance();
                if (directive[token.value]) {
                    warning("Unnecessary directive \"{a}\".", token, token.value);
                }
                if (token.value === "use strict") {
                    if (!option["(explicitNewcap)"])
                        option.newcap = true;
                    option.undef = true;
                }
                directive[token.value] = true;
                if (p.id === ";") {
                    advance(";");
                }
                continue;
            }
            break;
        }
    }
    function block(ordinary, stmt, isfunc) {
        var a,
            b = inblock,
            old_indent = indent,
            m,
            s = scope,
            t,
            line,
            d;
        inblock = ordinary;
        if (!ordinary || !option.funcscope)
            scope = Object.create(scope);
        nonadjacent(token, nexttoken);
        t = nexttoken;
        var metrics = funct["(metrics)"];
        metrics.nestedBlockDepth += 1;
        metrics.verifyMaxNestedBlockDepthPerFunction();
        if (nexttoken.id === "{") {
            advance("{");
            line = token.line;
            if (nexttoken.id !== "}") {
                indent += option.indent;
                while (!ordinary && nexttoken.from > indent) {
                    indent += option.indent;
                }
                if (isfunc) {
                    m = {};
                    for (d in directive) {
                        if (is_own(directive, d)) {
                            m[d] = directive[d];
                        }
                    }
                    directives();
                    if (option.strict && funct["(context)"]["(global)"]) {
                        if (!m["use strict"] && !directive["use strict"]) {
                            warning("Missing \"use strict\" statement.");
                        }
                    }
                }
                a = statements(line);
                metrics.statementCount += a.length;
                if (isfunc) {
                    directive = m;
                }
                indent -= option.indent;
                if (line !== nexttoken.line) {
                    indentation();
                }
            } else if (line !== nexttoken.line) {
                indentation();
            }
            advance("}", t);
            indent = old_indent;
        } else if (!ordinary) {
            error("Expected '{a}' and instead saw '{b}'.",
                  nexttoken, "{", nexttoken.value);
        } else {
            if (!stmt || option.curly)
                warning("Expected '{a}' and instead saw '{b}'.",
                        nexttoken, "{", nexttoken.value);
            noreach = true;
            indent += option.indent;
            a = [statement(nexttoken.line === token.line)];
            indent -= option.indent;
            noreach = false;
        }
        funct["(verb)"] = null;
        if (!ordinary || !option.funcscope) scope = s;
        inblock = b;
        if (ordinary && option.noempty && (!a || a.length === 0)) {
            warning("Empty block.");
        }
        metrics.nestedBlockDepth -= 1;
        return a;
    }
    function countMember(m) {
        if (membersOnly && typeof membersOnly[m] !== "boolean") {
            warning("Unexpected  on a line just before
                    if (!ft.test(lines[nexttoken.line - 2])) {
                        warning(
                            "Expected a 'break' statement before 'case'.",
                            token);
                    }
                }
                indentation(-option.indent);
                advance("case");
                this.cases.push(expression(20));
                increaseComplexityCount();
                g = true;
                advance(":");
                funct["(verb)"] = "case";
                break;
            case "default":
                switch (funct["(verb)"]) {
                case "break":
                case "continue":
                case "return":
                case "throw":
                    break;
                default:
                    if (!ft.test(lines[nexttoken.line - 2])) {
                        warning(
                            "Expected a 'break' statement before 'default'.",
                            token);
                    }
                }
                indentation(-option.indent);
                advance("default");
                g = true;
                advance(":");
                break;
            case "}":
                indent -= option.indent;
                indentation();
                advance("}", t);
                if (this.cases.length === 1 || this.condition.id === "true" ||
                        this.condition.id === "false") {
                    if (!option.onecase)
                        warning("This 'switch' should be an 'if'.", this);
                }
                funct["(breakage)"] -= 1;
                funct["(verb)"] = undefined;
                return;
            case "(end)":
                error("Missing '{a}'.", nexttoken, "}");
                return;
            default:
                if (g) {
                    switch (token.id) {
                    case ",":
                        error("Each value should have its own case label.");
                        return;
                    case ":":
                        g = false;
                        statements();
                        break;
                    default:
                        error("Missing ':' on a case clause.", token);
                        return;
                    }
                } else {
                    if (token.id === ":") {
                        advance(":");
                        error("Unexpected '{a}'.", token, ":");
                        statements();
                    } else {
                        error("Expected '{a}' and instead saw '{b}'.",
                            nexttoken, "case", nexttoken.value);
                        return;
                    }
                }
            }
        }
    }).labelled = true;
    stmt("debugger", function () {
        if (!option.debug) {
            warning("All 'debugger' statements should be removed.");
        }
        return this;
    }).exps = true;
    (function () {
        var x = stmt("do", function () {
            funct["(breakage)"] += 1;
            funct["(loopage)"] += 1;
            increaseComplexityCount();
            this.first = block(true);
            advance("while");
            var t = nexttoken;
            nonadjacent(token, t);
            advance("(");
            nospace();
            expression(20);
            if (nexttoken.id === "=") {
                if (!option.boss)
                    warning("Expected a conditional expression and instead saw an assignment.");
                advance("=");
                expression(20);
            }
            advance(")", t);
            nospace(prevtoken, token);
            funct["(breakage)"] -= 1;
            funct["(loopage)"] -= 1;
            return this;
        });
        x.labelled = true;
        x.exps = true;
    }());
    blockstmt("for", function () {
        var s, t = nexttoken;
        funct["(breakage)"] += 1;
        funct["(loopage)"] += 1;
        increaseComplexityCount();
        advance("(");
        nonadjacent(this, t);
        nospace();
        if (peek(nexttoken.id === "var" ? 1 : 0).id === "in") {
            if (nexttoken.id === "var") {
                advance("var");
                varstatement.fud.call(varstatement, true);
            } else {
                switch (funct[nexttoken.value]) {
                case "unused":
                    funct[nexttoken.value] = "var";
                    break;
                case "var":
                    break;
                default:
                    warning("Bad for in variable '{a}'.",
                            nexttoken, nexttoken.value);
                }
                advance();
            }
            advance("in");
            expression(20);
            advance(")", t);
            s = block(true, true);
            if (option.forin && s && (s.length > 1 || typeof s[0] !== "object" ||
                    s[0].value !== "if")) {
                warning("The body of a for in should be wrapped in an if statement to filter " +
                        "unwanted properties from the prototype.", this);
            }
            funct["(breakage)"] -= 1;
            funct["(loopage)"] -= 1;
            return this;
        } else {
            if (nexttoken.id !== ";") {
                if (nexttoken.id === "var") {
                    advance("var");
                    varstatement.fud.call(varstatement);
                } else {
                    for (;;) {
                        expression(0, "for");
                        if (nexttoken.id !== ",") {
                            break;
                        }
                        comma();
                    }
                }
            }
            nolinebreak(token);
            advance(";");
            if (nexttoken.id !== ";") {
                expression(20);
                if (nexttoken.id === "=") {
                    if (!option.boss)
                        warning("Expected a conditional expression and instead saw an assignment.");
                    advance("=");
                    expression(20);
                }
            }
            nolinebreak(token);
            advance(";");
            if (nexttoken.id === ";") {
                error("Expected '{a}' and instead saw '{b}'.",
                        nexttoken, ")", ";");
            }
            if (nexttoken.id !== ")") {
                for (;;) {
                    expression(0, "for");
                    if (nexttoken.id !== ",") {
                        break;
                    }
                    comma();
                }
            }
            advance(")", t);
            nospace(prevtoken, token);
            block(true, true);
            funct["(breakage)"] -= 1;
            funct["(loopage)"] -= 1;
            return this;
        }
    }).labelled = true;
    stmt("break", function () {
        var v = nexttoken.value;
        if (funct["(breakage)"] === 0)
            warning("Unexpected '{a}'.", nexttoken, this.value);
        if (!option.asi)
            nolinebreak(this);
        if (nexttoken.id !== ";") {
            if (token.line === nexttoken.line) {
                if (funct[v] !== "label") {
                    warning("'{a}' is not a statement label.", nexttoken, v);
                } else if (scope[v] !== funct) {
                    warning("'{a}' is out of scope.", nexttoken, v);
                }
                this.first = nexttoken;
                advance();
            }
        }
        reachable("break");
        return this;
    }).exps = true;
    stmt("continue", function () {
        var v = nexttoken.value;
        if (funct["(breakage)"] === 0)
            warning("Unexpected '{a}'.", nexttoken, this.value);
        if (!option.asi)
            nolinebreak(this);
        if (nexttoken.id !== ";") {
            if (token.line === nexttoken.line) {
                if (funct[v] !== "label") {
                    warning("'{a}' is not a statement label.", nexttoken, v);
                } else if (scope[v] !== funct) {
                    warning("'{a}' is out of scope.", nexttoken, v);
                }
                this.first = nexttoken;
                advance();
            }
        } else if (!funct["(loopage)"]) {
            warning("Unexpected '{a}'.", nexttoken, this.value);
        }
        reachable("continue");
        return this;
    }).exps = true;
    stmt("return", function () {
        if (this.line === nexttoken.line) {
            if (nexttoken.id === "(regexp)")
                warning("Wrap the /regexp/ literal in parens to disambiguate the slash operator.");
            if (nexttoken.id !== ";" && !nexttoken.reach) {
                nonadjacent(token, nexttoken);
                if (peek().value === "=" && !option.boss) {
                    warningAt("Did you mean to return a conditional instead of an assignment?",
                              token.line, token.character + 1);
                }
                this.first = expression(0);
            }
        } else if (!option.asi) {
            nolinebreak(this); 
        }
        reachable("return");
        return this;
    }).exps = true;
    stmt("throw", function () {
        nolinebreak(this);
        nonadjacent(token, nexttoken);
        this.first = expression(20);
        reachable("throw");
        return this;
    }).exps = true;
    reserve("class");
    reserve("const");
    reserve("enum");
    reserve("export");
    reserve("extends");
    reserve("import");
    reserve("super");
    reserve("let");
    reserve("yield");
    reserve("implements");
    reserve("interface");
    reserve("package");
    reserve("private");
    reserve("protected");
    reserve("public");
    reserve("static");
    function jsonValue() {
        function jsonObject() {
            var o = {}, t = nexttoken;
            advance("{");
            if (nexttoken.id !== "}") {
                for (;;) {
                    if (nexttoken.id === "(end)") {
                        error("Missing '}' to match '{' from line {a}.",
                                nexttoken, t.line);
                    } else if (nexttoken.id === "}") {
                        warning("Unexpected comma.", token);
                        break;
                    } else if (nexttoken.id === ",") {
                        error("Unexpected comma.", nexttoken);
                    } else if (nexttoken.id !== "(string)") {
                        warning("Expected a string and instead saw {a}.",
                                nexttoken, nexttoken.value);
                    }
                    if (o[nexttoken.value] === true) {
                        warning("Duplicate key '{a}'.",
                                nexttoken, nexttoken.value);
                    } else if ((nexttoken.value === "__proto__" &&
                        !option.proto) || (nexttoken.value === "__iterator__" &&
                        !option.iterator)) {
                        warning("The '{a}' key may produce unexpected results.",
                            nexttoken, nexttoken.value);
                    } else {
                        o[nexttoken.value] = true;
                    }
                    advance();
                    advance(":");
                    jsonValue();
                    if (nexttoken.id !== ",") {
                        break;
                    }
                    advance(",");
                }
            }
            advance("}");
        }
        function jsonArray() {
            var t = nexttoken;
            advance("[");
            if (nexttoken.id !== "]") {
                for (;;) {
                    if (nexttoken.id === "(end)") {
                        error("Missing ']' to match '[' from line {a}.",
                                nexttoken, t.line);
                    } else if (nexttoken.id === "]") {
                        warning("Unexpected comma.", token);
                        break;
                    } else if (nexttoken.id === ",") {
                        error("Unexpected comma.", nexttoken);
                    }
                    jsonValue();
                    if (nexttoken.id !== ",") {
                        break;
                    }
                    advance(",");
                }
            }
            advance("]");
        }
        switch (nexttoken.id) {
        case "{":
            jsonObject();
            break;
        case "[":
            jsonArray();
            break;
        case "true":
        case "false":
        case "null":
        case "(number)":
        case "(string)":
            advance();
            break;
        case "-":
            advance("-");
            if (token.character !== nexttoken.from) {
                warning("Unexpected space after '-'.", token);
            }
            adjacent(token, nexttoken);
            advance("(number)");
            break;
        default:
            error("Expected a JSON value.", nexttoken);
        }
    }
    var itself = function (s, o, g) {
        var a, i, k, x;
        var optionKeys;
        var newOptionObj = {};
        if (o && o.scope) {
            JSHINT.scope = o.scope;
        } else {
            JSHINT.errors = [];
            JSHINT.undefs = [];
            JSHINT.internals = [];
            JSHINT.blacklist = {};
            JSHINT.scope = "(main)";
        }
        predefined = Object.create(standard);
        declared = Object.create(null);
        combine(predefined, g || {});
        if (o) {
            a = o.predef;
            if (a) {
                if (!Array.isArray(a) && typeof a === "object") {
                    a = Object.keys(a);
                }
                a.forEach(function (item) {
                    var slice;
                    if (item[0] === "-") {
                        slice = item.slice(1);
                        JSHINT.blacklist[slice] = slice;
                    } else {
                        predefined[item] = true;
                    }
                });
            }
            optionKeys = Object.keys(o);
            for (x = 0; x < optionKeys.length; x++) {
                newOptionObj[optionKeys[x]] = o[optionKeys[x]];
                if (optionKeys[x] === "newcap" && o[optionKeys[x]] === false)
                    newOptionObj["(explicitNewcap)"] = true;
                if (optionKeys[x] === "indent")
                    newOptionObj.white = true;
            }
        }
        option = newOptionObj;
        option.indent = option.indent || 4;
        option.maxerr = option.maxerr || 50;
        tab = "";
        for (i = 0; i < option.indent; i += 1) {
            tab += " ";
        }
        indent = 1;
        global = Object.create(predefined);
        scope = global;
        funct = {
            "(global)":   true,
            "(name)":     "(global)",
            "(scope)":    scope,
            "(breakage)": 0,
            "(loopage)":  0,
            "(tokens)":   {},
            "(metrics)":   createMetrics(nexttoken)
        };
        functions = [funct];
        urls = [];
        stack = null;
        member = {};
        membersOnly = null;
        implied = {};
        inblock = false;
        lookahead = [];
        jsonmode = false;
        warnings = 0;
        lines = [];
        unuseds = [];
        if (!isString(s) && !Array.isArray(s)) {
            errorAt("Input is neither a string nor an array of strings.", 0);
            return false;
        }
        if (isString(s) && /^\s*$/g.test(s)) {
            errorAt("Input is an empty string.", 0);
            return false;
        }
        if (s.length === 0) {
            errorAt("Input is an empty array.", 0);
            return false;
        }
        lex.init(s);
        prereg = true;
        directive = {};
        prevtoken = token = nexttoken = syntax["(begin)"];
        for (var name in o) {
            if (is_own(o, name)) {
                checkOption(name, token);
            }
        }
        assume();
        combine(predefined, g || {});
        comma.first = true;
        quotmark = undefined;
        try {
            advance();
            switch (nexttoken.id) {
            case "{":
            case "[":
                option.laxbreak = true;
                jsonmode = true;
                jsonValue();
                break;
            default:
                directives();
                if (directive["use strict"] && !option.globalstrict) {
                    warning("Use the function form of \"use strict\".", prevtoken);
                }
                statements();
            }
            advance((nexttoken && nexttoken.value !== ".")  ? "(end)" : undefined);
            var markDefined = function (name, context) {
                do {
                    if (typeof context[name] === "string") {
                        if (context[name] === "unused")
                            context[name] = "var";
                        else if (context[name] === "unction")
                            context[name] = "closure";
                        return true;
                    }
                    context = context["(context)"];
                } while (context);
                return false;
            };
            var clearImplied = function (name, line) {
                if (!implied[name])
                    return;
                var newImplied = [];
                for (var i = 0; i < implied[name].length; i += 1) {
                    if (implied[name][i] !== line)
                        newImplied.push(implied[name][i]);
                }
                if (newImplied.length === 0)
                    delete implied[name];
                else
                    implied[name] = newImplied;
            };
            var warnUnused = function (name, token) {
                var line = token.line;
                var chr  = token.character;
                if (option.unused)
                    warningAt("'{a}' is defined but never used.", line, chr, name);
                unuseds.push({
                    name: name,
                    line: line,
                    character: chr
                });
            };
            var checkUnused = function (func, key) {
                var type = func[key];
                var token = func["(tokens)"][key];
                if (key.charAt(0) === "(")
                    return;
                if (type !== "unused" && type !== "unction")
                    return;
                if (func["(params)"] && func["(params)"].indexOf(key) !== -1)
                    return;
                warnUnused(key, token);
            };
            for (i = 0; i < JSHINT.undefs.length; i += 1) {
                k = JSHINT.undefs[i].slice(0);
                if (markDefined(k[2].value, k[0])) {
                    clearImplied(k[2].value, k[2].line);
                } else {
                    warning.apply(warning, k.slice(1));
                }
            }
            functions.forEach(function (func) {
                for (var key in func) {
                    if (is_own(func, key)) {
                        checkUnused(func, key);
                    }
                }
                if (!func["(params)"])
                    return;
                var params = func["(params)"].slice();
                var param  = params.pop();
                var type;
                while (param) {
                    type = func[param];
                    if (param === "undefined")
                        return;
                    if (type !== "unused" && type !== "unction")
                        return;
                    warnUnused(param, func["(tokens)"][param]);
                    param = params.pop();
                }
            });
            for (var key in declared) {
                if (is_own(declared, key) && !is_own(global, key)) {
                    warnUnused(key, declared[key]);
                }
            }
        } catch (e) {
            if (e) {
                var nt = nexttoken || {};
                JSHINT.errors.push({
                    raw       : e.raw,
                    reason    : e.message,
                    line      : e.line || nt.line,
                    character : e.character || nt.from
                }, null);
            }
        }
        if (JSHINT.scope === "(main)") {
            o = o || {};
            for (i = 0; i < JSHINT.internals.length; i += 1) {
                k = JSHINT.internals[i];
                o.scope = k.elem;
                itself(k.value, o, g);
            }
        }
        return JSHINT.errors.length === 0;
    };
    itself.data = function () {
        var data = {
            functions: [],
            options: option
        };
        var implieds = [];
        var members = [];
        var fu, f, i, j, n, globals;
        if (itself.errors.length) {
            data.errors = itself.errors;
        }
        if (jsonmode) {
            data.json = true;
        }
        for (n in implied) {
            if (is_own(implied, n)) {
                implieds.push({
                    name: n,
                    line: implied[n]
                });
            }
        }
        if (implieds.length > 0) {
            data.implieds = implieds;
        }
        if (urls.length > 0) {
            data.urls = urls;
        }
        globals = Object.keys(scope);
        if (globals.length > 0) {
            data.globals = globals;
        }
        for (i = 1; i < functions.length; i += 1) {
            f = functions[i];
            fu = {};
            for (j = 0; j < functionicity.length; j += 1) {
                fu[functionicity[j]] = [];
            }
            for (j = 0; j < functionicity.length; j += 1) {
                if (fu[functionicity[j]].length === 0) {
                    delete fu[functionicity[j]];
                }
            }
            fu.name = f["(name)"];
            fu.param = f["(params)"];
            fu.line = f["(line)"];
            fu.character = f["(character)"];
            fu.last = f["(last)"];
            fu.lastcharacter = f["(lastcharacter)"];
            data.functions.push(fu);
        }
        if (unuseds.length > 0) {
            data.unused = unuseds;
        }
        members = [];
        for (n in member) {
            if (typeof member[n] === "number") {
                data.member = member;
                break;
            }
        }
        return data;
    };
    itself.jshint = itself;
    return itself;
}());
if (typeof exports === "object" && exports) {
    exports.JSHINT = JSHINT;
}
