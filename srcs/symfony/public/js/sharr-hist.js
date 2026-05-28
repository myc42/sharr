/* ═══════════════════════════════════════════════════════════════
   SHARR — HISTORIQUE LOCAL (localStorage, ES5, autonome)
   ═══════════════════════════════════════════════════════════════ */

var HIST_KEY = 'sharr-hist';
var HIST_TTL = 24 * 60 * 60 * 1000;
var HIST_MAX = 50;

/* ── Storage ─────────────────────────────────────────────────── */

var Store = {
    get: function () {
        try {
            var raw = localStorage.getItem(HIST_KEY);
            return raw ? JSON.parse(raw) : [];
        } catch (e) { return []; }
    },
    set: function (val) {
        try { localStorage.setItem(HIST_KEY, JSON.stringify(val)); } catch (e) {}
    }
};

/* ── Lecture + purge 24 h ────────────────────────────────────── */

function histGet() {
    var raw    = Store.get();
    var now    = Date.now();
    var active = [];
    for (var i = 0; i < raw.length; i++) {
        if (raw[i] && raw[i].ts && (now - raw[i].ts) < HIST_TTL) {
            active.push(raw[i]);
        }
    }
    if (active.length !== raw.length) Store.set(active);
    return active;
}

/* ── Extraction du token depuis plusieurs sources ────────────── */

function histGetToken() {
    // 1. data-room-token sur le body (auteur)
    var body = document.body;
    if (body && body.dataset && body.dataset.roomToken) {
        return body.dataset.roomToken;
    }
    // 2. data-room-token via getAttribute (fallback IE)
    if (body && body.getAttribute('data-room-token')) {
        return body.getAttribute('data-room-token');
    }
    // 3. Dernier segment de l'URL
    var parts = window.location.pathname.split('/');
    for (var i = parts.length - 1; i >= 0; i--) {
        if (parts[i].length > 0) return parts[i];
    }
    return null;
}

/* ── Enregistrement ──────────────────────────────────────────── */

function histSave(token, url) {
    token = token || histGetToken();
    url   = url   || window.location.href;
    if (!token || !url) return;

    var h   = histGet();
    var now = Date.now();

    for (var i = 0; i < h.length; i++) {
        if (h[i].token === token) {
            h[i].ts  = now;
            h[i].url = url;
            Store.set(h);
            return;
        }
    }

    h.unshift({ token: token, url: url, ts: now });
    Store.set(h.slice(0, HIST_MAX));
}

/* ── Suppression ─────────────────────────────────────────────── */

function histDelete(token, e) {
    if (e && e.stopPropagation) e.stopPropagation();
    var h = histGet(), out = [];
    for (var i = 0; i < h.length; i++) {
        if (h[i].token !== token) out.push(h[i]);
    }
    Store.set(out);
    histRender();
}

window.__histDelete = histDelete;

/* ── Temps relatif ───────────────────────────────────────────── */

function histRelTime(ts) {
    var d  = Date.now() - ts;
    var m  = Math.floor(d / 60000);
    var hr = Math.floor(d / 3600000);
    if (m < 1)   return 'À l\'instant';
    if (m < 60)  return m + ' min';
    if (hr < 24) return hr + 'h';
    return Math.floor(d / 86400000) + 'j';
}

/* ── Échappement ─────────────────────────────────────────────── */

function histEsc(s) {
    return String(s)
        .replace(/&/g,  '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;')
        .replace(/'/g,  '&#039;');
}

/* ── Rendu ───────────────────────────────────────────────────── */

function histRender() {
    var list = document.getElementById('historyList');
    if (!list) return;

    var h = histGet();

    if (!h.length) {
        list.innerHTML =
            '<div class="empty-state">' +
                '<div class="empty-icon"><i class="fi fi-sr-document-signed"></i></div>' +
                '<p class="empty-title">Aucun historique</p>' +
                '<p class="empty-sub">Les liens visités apparaissent ici pendant 24 h.</p>' +
            '</div>';
        return;
    }

    var html = '';
    for (var i = 0; i < h.length; i++) {
        var e = h[i];
        html +=
            '<div class="hist-card" onclick="window.location.href=\'' + histEsc(e.url) + '\'">' +
                '<div class="hist-card-top">' +
                    '<div class="hist-time">' +
                        '<i class="fi fi-sr-clock"></i>' + histRelTime(e.ts) +
                    '</div>' +
                    '<button class="hist-delete" onclick="window.__histDelete(\'' + histEsc(e.token) + '\',event)" title="Supprimer">' +
                        '<i class="fi fi-sr-trash"></i>' +
                    '</button>' +
                '</div>' +
                '<div class="hist-token">' +
                    '<i class="fi fi-sr-link"></i>' + histEsc(e.token) +
                '</div>' +
            '</div>';
    }
    list.innerHTML = html;
}

/* ── Sidebar ─────────────────────────────────────────────────── */

function histBindSidebar() {
    var btn      = document.getElementById('historyBtn');
    var closeBtn = document.getElementById('closeSidebar');
    var sidebar  = document.getElementById('sidebar');
    if (!btn || !sidebar) return;

    // Clonage pour éliminer tout listener concurrent
    var newBtn = btn.cloneNode(true);
    btn.parentNode.replaceChild(newBtn, btn);
    newBtn.addEventListener('click', function () {
        if (sidebar.classList.contains('open')) {
            sidebar.classList.remove('open');
        } else {
            sidebar.classList.add('open');
            histRender();
        }
    });

    if (closeBtn) {
        var newClose = closeBtn.cloneNode(true);
        closeBtn.parentNode.replaceChild(newClose, closeBtn);
        newClose.addEventListener('click', function () {
            sidebar.classList.remove('open');
        });
    }
}

/* ── Initialisation automatique ──────────────────────────────── */

window.addEventListener('load', function () {
    // Enregistre la visite courante sans attendre les autres scripts
    histSave();
    // Bind la sidebar après que tous les scripts ont tourné
    histBindSidebar();
});