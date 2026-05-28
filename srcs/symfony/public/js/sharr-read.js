const $ = id => document.getElementById(id);

const input   = $('input');
const output  = $('output');
const linesEl = $('lines');
const stLang  = $('stLang');
const stChars = $('stChars');

const ROOM_TOKEN = document.body.dataset.roomToken;

/* ══ THEME ══════════════════════════════════════════════════════ */

function setTheme(t) {
    document.body.setAttribute('data-theme', t);
    $('themeIcon').className = t === 'light' ? 'fi fi-sr-moon' : 'fi fi-sr-sun';
    try { localStorage.setItem('sharr-theme', t); } catch {}
}

$('themeToggle').addEventListener('click', function () {
    setTheme(document.body.dataset.theme === 'dark' ? 'light' : 'dark');
});

(function () {
    var t = 'light';
    try { t = localStorage.getItem('sharr-theme') || 'light'; } catch {}
    setTheme(t);
})();

/* ══ COPY LINK ───────────────────────────────────────────────── */

$('copyLinkBtn').addEventListener('click', function () {
    var lbl = $('copyLinkLabel');
    var url = window.location.href;

    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function () {
            lbl.textContent = 'Copié !';
            setTimeout(function () { lbl.textContent = 'Lien'; }, 2000);
        }).catch(function () { fallbackCopy(url, lbl); });
    } else {
        fallbackCopy(url, lbl);
    }
});

function fallbackCopy(text, lbl) {
    var ta = document.createElement('textarea');
    ta.value = text;
    ta.style.cssText = 'position:fixed;top:0;left:0;opacity:0';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
        document.execCommand('copy');
        lbl.textContent = 'Copié !';
        setTimeout(function () { lbl.textContent = 'Lien'; }, 2000);
    } catch {}
    document.body.removeChild(ta);
}

/* ══ LANGUAGE DETECTION ──────────────────────────────────────── */

function detectLang(s) {
    if (!s.trim()) return 'txt';
    if (/^<!DOCTYPE\s+html|^<html[\s>]|<\/html>|<head>|<body>|<div|<span|<script>|<style>/i.test(s)) return 'html';
    if (/^<\?php/.test(s.trim()) || (/\$[a-zA-Z_][a-zA-Z0-9_]*\s*=/.test(s) && /->|echo\s|print\s/.test(s))) return 'php';
    if (/^\s*[\{\[]/.test(s) && /"[^"]+"\s*:\s*/.test(s) && !/function|const|let|var|class|import/.test(s)) return 'json';
    if (/^@(media|keyframes|import|font-face)|^[.#]?[\w-]+\s*\{[\s\S]*:\s*[\w-]+/.test(s) && !/function|const|let|var|class/.test(s)) return 'css';
    if (/fn\s+\w+|let\s+mut\s+|impl\s+\w+|pub\s+fn|use\s+\w+::|mod\s+\w+/.test(s) && !/function|const\s+\w+\s*=/.test(s)) return 'rust';
    if (/^package\s+\w+|func\s+\w+\([^)]*\)\s+\w+\s*\{|:=\s*|fmt\.Print/.test(s)) return 'go';
    if (/import\s+(Foundation|UIKit|SwiftUI)|func\s+\w+\([^)]*\)\s*->/.test(s)) return 'swift';
    if (/#include\s*<iostream>|std::|using\s+namespace\s+std|cout\s*<<|cin\s*>>/.test(s)) return 'cpp';
    if (/#include\s*<stdio\.h>|printf\s*\(|scanf\s*\(/.test(s) && !/std::|cout|cin/.test(s)) return 'c';
    if (/public\s+class\s+\w+|public\s+static\s+void\s+main|import\s+java\.|System\.out\.print/.test(s)) return 'java';
    if (/\bend\b/.test(s) && /^def\s+\w+|puts\s+|require\s+['"]/.test(s) && !/function|const|let/.test(s)) return 'ruby';
    if (/(^|\n)(def\s+\w+|class\s+\w+|import\s+\w+|from\s+\w+\s+import)\s*[:(]|if\s+__name__|print\s*\(/.test(s) && !/function|const|let|var|;$/.test(s)) return 'python';
    if (/^(const|let|var)\s+\w+\s*=/m.test(s) || /function\s+\w+\s*\(|=>\s*{|console\.(log|error)|require\s*\(|module\.exports|export\s+(default|const|function)/.test(s)) return 'javascript';
    return 'txt';
}

/* ══ TOKENIZER ───────────────────────────────────────────────── */

var KW = {
    javascript: ['function','const','let','var','return','if','else','for','while','class','new','this','super','extends','import','export','from','async','await','try','catch','finally','throw','typeof','instanceof','break','continue','switch','case','default','do'],
    python:     ['def','class','if','elif','else','for','while','return','import','from','as','try','except','finally','with','lambda','yield','pass','break','continue','and','or','not','in','is'],
    swift:      ['func','var','let','class','struct','enum','protocol','extension','import','return','if','else','for','while','guard','switch','case','default','break','continue','in','where','self','init','deinit','override','public','private','internal','static','mutating'],
    rust:       ['fn','let','mut','use','mod','pub','impl','trait','struct','enum','match','if','else','for','while','loop','break','continue','return','const','static','self','Self','crate','super'],
    php:        ['function','echo','print','return','if','else','elseif','for','foreach','while','class','new','public','private','protected','static','const','namespace','use','require','include'],
    ruby:       ['def','class','module','if','elsif','else','unless','case','when','for','while','until','begin','end','rescue','ensure','return','yield','self','super','attr_accessor','attr_reader','attr_writer','private','public','protected','require','include'],
    go:         ['func','var','const','package','import','return','if','else','for','range','switch','case','default','break','continue','goto','type','struct','interface','map','chan','go','defer','select'],
    cpp:        ['int','void','char','float','double','bool','class','struct','public','private','protected','return','if','else','for','while','do','switch','case','default','break','continue','new','delete','this','namespace','using','template','typename','const','static','virtual','override'],
    c:          ['int','void','char','float','double','return','if','else','for','while','do','switch','case','default','break','continue','struct','union','enum','typedef','const','static','extern','sizeof','printf','scanf','malloc','free'],
    java:       ['public','private','protected','class','interface','extends','implements','import','package','return','if','else','for','while','do','switch','case','default','break','continue','new','this','super','static','final','void','int','boolean','String','try','catch','finally','throw','throws'],
    html: [], css: [], json: [], txt: []
};

var MOP = ['===','!==','==','!=','<=','>=','&&','||','++','--','+=','-=','*=','/=','%=','=>','...'];
var SOP = {'+':1,'-':1,'*':1,'/':1,'%':1,'=':1,'<':1,'>':1,'!':1,'&':1,'|':1};
var PUN = {'(':1,')':1,'{':1,'}':1,'[':1,']':1,';':1,',':1,':':1,'.':1};

function esc(s) {
    return String(s)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
        .replace(/"/g,'&quot;').replace(/'/g,'&#039;');
}

function tokenize(code, l) {
    var kw = KW[l] || [];
    var toks = [];
    var i = 0;

    while (i < code.length) {
        var c = code[i], ok = false;

        if (c === '"' || c === "'" || c === '`') {
            var q = c, s = c; i++;
            while (i < code.length) {
                if (code[i] === '\\') { s += code[i] + code[i+1]; i += 2; }
                else if (code[i] === q) { s += code[i++]; break; }
                else if (code[i] === '\n' && q !== '`') break;
                else s += code[i++];
            }
            toks.push({t:'string',v:s}); ok = true;
        } else if (c === '/' && code[i+1] === '/') {
            var s = '';
            while (i < code.length && code[i] !== '\n') s += code[i++];
            toks.push({t:'comment',v:s}); ok = true;
        } else if (c === '/' && code[i+1] === '*') {
            var s = c + code[i+1]; i += 2;
            while (i < code.length) {
                if (code[i] === '*' && code[i+1] === '/') { s += code[i] + code[i+1]; i += 2; break; }
                s += code[i++];
            }
            toks.push({t:'comment',v:s}); ok = true;
        } else if (l === 'python' && c === '#') {
            var s = '';
            while (i < code.length && code[i] !== '\n') s += code[i++];
            toks.push({t:'comment',v:s}); ok = true;
        }

        if (!ok && /[0-9]/.test(c)) {
            var s = '';
            if (c === '0' && /[xX]/.test(code[i+1])) {
                s = c + code[i+1]; i += 2;
                while (i < code.length && /[0-9a-fA-F]/.test(code[i])) s += code[i++];
            } else {
                while (i < code.length && /[0-9.]/.test(code[i])) s += code[i++];
            }
            toks.push({t:'number',v:s}); ok = true;
        }

        if (!ok) {
            var op = null;
            for (var oi = 0; oi < MOP.length; oi++) {
                if (code.substr(i, MOP[oi].length) === MOP[oi]) { op = MOP[oi]; break; }
            }
            if (op) { toks.push({t:'operator',v:op}); i += op.length; ok = true; }
        }
        if (!ok && SOP[c]) { toks.push({t:'operator',v:c}); i++; ok = true; }
        if (!ok && PUN[c]) { toks.push({t:'punctuation',v:c}); i++; ok = true; }

        if (!ok && /[a-zA-Z_$]/.test(c)) {
            var w = '';
            while (i < code.length && /[a-zA-Z0-9_$]/.test(code[i])) w += code[i++];

            if      (kw.indexOf(w) >= 0)                                  toks.push({t:'keyword',  v:w});
            else if (w === 'true' || w === 'false')                       toks.push({t:'boolean',  v:w});
            else if (w === 'null' || w === 'undefined' || w === 'None')   toks.push({t:'null',     v:w});
            else if (i < code.length && code[i] === '(')                  toks.push({t:'function', v:w});
            else if (toks.length && toks[toks.length-1].v === '.')        toks.push({t:'property', v:w});
            else                                                           toks.push({t:'text',     v:w});
            ok = true;
        }

        if (!ok) { toks.push({t:'text',v:c}); i++; }
    }
    return toks;
}

function render(toks) {
    var out = '';
    for (var i = 0; i < toks.length; i++) {
        out += '<span class="' + toks[i].t + '">' + esc(toks[i].v) + '</span>';
    }
    return out;
}

/* ══ LINE NUMBERS ────────────────────────────────────────────── */

function renderLines(n) {
    var h = '';
    for (var i = 1; i <= n; i++) h += '<span class="ln">' + i + '</span>';
    linesEl.innerHTML = h;
}

/* ══ SCROLL SYNC ─────────────────────────────────────────────── */

input.addEventListener('scroll', function () {
    output.scrollTop  = input.scrollTop;
    output.scrollLeft = input.scrollLeft;
    linesEl.scrollTop = input.scrollTop;
});

/* ══ BOOT ────────────────────────────────────────────────────── */

function init() {
    var code = input.value;

    if (!code.trim()) {
        output.innerHTML = '';
        linesEl.innerHTML = '';
        stLang.textContent  = 'Txt';
        stChars.textContent = '0 car.';
        return;
    }

    var l = detectLang(code);
    stLang.textContent  = l.charAt(0).toUpperCase() + l.slice(1);
    stChars.textContent = code.length + ' car.';
    output.innerHTML    = render(tokenize(code, l));
    renderLines(code.split('\n').length);
histSave(ROOM_TOKEN, window.location.href);
}

init();