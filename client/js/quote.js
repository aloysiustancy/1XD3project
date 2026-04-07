/* ── Toast ── */
let toastTimer;
function showToast(msg, isError = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'show' + (isError ? ' error' : '');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { t.className = ''; }, 3000);
}

/* ── Add quote ── */
async function addQuote() {
    const text = document.getElementById('q-text').value.trim();
    const author = document.getElementById('q-author').value.trim();
    if (!text) { showToast('Please enter quote text.', true); return; }

    const btn = document.getElementById('btn-add-quote');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Adding…';

    try {
        const res = await fetch('quotes/add_quote.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ text, author })
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        showToast('Quote added!');
        document.getElementById('q-text').value = '';
        document.getElementById('q-author').value = '';
        loadQuotes();
    } catch (err) {
        showToast(err.message || 'Failed to add quote.', true);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Quote';
    }
}

/* ── Import quotes ── */
async function importQuotes() {
    const count = parseInt(document.getElementById('import-count').value, 10) || 10;
    const btn = document.getElementById('btn-import');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner" style="border-color:rgba(44,95,46,0.3);border-top-color:#2c5f2e;"></span> Importing…';

    try {
        const res = await fetch('quotes/import_quote.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ count })
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        showToast(data.message || 'Import complete!');
        loadQuotes();
    } catch (err) {
        showToast(err.message || 'Import failed.', true);
    } finally {
        btn.disabled = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="21" x2="12" y2="3"/></svg> Import';
    }
}

/* ── Load quotes ── */
async function loadQuotes() {
    const list = document.getElementById('quote-list');
    const countEl = document.getElementById('quote-count');
    list.innerHTML = '<div class="quote-list-empty">Loading…</div>';

    try {
        const res = await fetch('quotes/get_quote.php');
        const data = await res.json();
        if (data.error) throw new Error(data.error);

        countEl.textContent = data.length + ' quote' + (data.length !== 1 ? 's' : '');

        if (data.length === 0) {
            list.innerHTML = '<div class="quote-list-empty">No quotes yet.</div>';
            return;
        }

        list.innerHTML = data.map(q => `
                    <div class="quote-item" id="quote-${q.id}">
                        <div class="q-text">"${esc(q.text)}"</div>
                        <div class="q-meta">
                            <span>— ${esc(q.author || 'Unknown')}</span>
                            <span class="q-source-badge">${esc(q.source || 'admin')}</span>
                            ${q.created_at ? '<span>' + esc(q.created_at.slice(0, 10)) + '</span>' : ''}
                            <button class="q-delete-btn" onclick="deleteQuote(${q.id}, this)" title="Delete quote">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </div>
                `).join('');
    } catch (err) {
        countEl.textContent = '';
        list.innerHTML = '<div class="quote-list-empty">Could not load: ' + esc(err.message) + '</div>';
    }
}

function esc(str) {
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

loadQuotes();

/* ── Delete quote ── */
async function deleteQuote(id, btn) {
    btn.disabled = true;
    try {
        const res = await fetch('quotes/delete_quote.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        const item = document.getElementById('quote-' + id);
        if (item) item.remove();
        const remaining = document.querySelectorAll('#quote-list .quote-item').length;
        const countEl = document.getElementById('quote-count');
        if (countEl) countEl.textContent = remaining + ' quote' + (remaining !== 1 ? 's' : '');
        if (remaining === 0) {
            document.getElementById('quote-list').innerHTML = '<div class="quote-list-empty">No quotes yet.</div>';
        }
        showToast('Quote deleted.');
    } catch (err) {
        showToast(err.message || 'Failed to delete quote.', true);
        btn.disabled = false;
    }
}

async function loadRandomQuote() {
    const textEl = document.getElementById('wow-text');
    const authorEl = document.getElementById('wow-author');
    if (!textEl) return;
    textEl.textContent = 'Loading\u2026';
    authorEl.textContent = '';
    try {
        const res = await fetch('quotes/random_quote.php');
        const quote = await res.json();
        if (quote.error) throw new Error(quote.error);
        textEl.textContent = '\u201c' + quote.text + '\u201d';
        authorEl.textContent = '\u2014 ' + (quote.author || 'Unknown');
    } catch (err) {
        textEl.textContent = 'Could not load quote.';
        authorEl.textContent = '';
    }
}
loadRandomQuote();