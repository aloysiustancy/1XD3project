/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Handles the quotes section of the admin dashboard. Admins can
 *              add a quote manually, bulk-import quotes, and view all quotes
 *              in the database. Also loads a random quote into the display spot.
 */

let toastTimer;

/**
 * Shows a brief notification at the bottom of the screen for 3 seconds.
 *
 * @param {String}  msg     - Message to display
 * @param {Boolean} isError - If true, styles the toast as an error (default: false)
 */
function showToast(msg, isError = false) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'show' + (isError ? ' error' : '');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { t.className = ''; }, 3000);
}

/**
 * Reads the quote text and author fields and sends a new quote to the server.
 * Refreshes the quote list on success.
 */
async function addQuote() {
    const text   = document.getElementById('q-text').value.trim();
    const author = document.getElementById('q-author').value.trim();
    if (!text) { showToast('Please enter quote text.', true); return; }

    const btn = document.getElementById('btn-add-quote');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner"></span> Adding…';

    try {
        const res  = await fetch('quotes/add_quote.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ text, author })
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        showToast('Quote added!');
        document.getElementById('q-text').value   = '';
        document.getElementById('q-author').value = '';
        loadQuotes();
    } catch (err) {
        showToast(err.message || 'Failed to add quote.', true);
    } finally {
        btn.disabled  = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg> Add Quote';
    }
}

/**
 * Imports a batch of quotes from an external source.
 * The count comes from the import-count input field.
 */
async function importQuotes() {
    const count = parseInt(document.getElementById('import-count').value, 10) || 10;
    const btn   = document.getElementById('btn-import');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner" style="border-color:rgba(44,95,46,0.3);border-top-color:#2c5f2e;"></span> Importing…';

    try {
        const res  = await fetch('quotes/import_quote.php', {
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
        btn.disabled  = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="8 17 12 21 16 17"/><line x1="12" y1="21" x2="12" y2="3"/></svg> Import';
    }
}

/**
 * Fetches all quotes from the server and renders them as a list on the page.
 */
async function loadQuotes() {
    const list    = document.getElementById('quote-list');
    const countEl = document.getElementById('quote-count');
    list.innerHTML = '<div class="quote-list-empty">Loading…</div>';

    try {
        const res  = await fetch('quotes/get_quote.php');
        const data = await res.json();
        if (data.error) throw new Error(data.error);

        countEl.textContent = data.length + ' quote' + (data.length !== 1 ? 's' : '');

        if (data.length === 0) {
            list.innerHTML = '<div class="quote-list-empty">No quotes yet.</div>';
            return;
        }

        list.innerHTML = data.map(q => `
            <div class="quote-item">
                <div class="q-text">"${esc(q.text)}"</div>
                <div class="q-meta">
                    <span>— ${esc(q.author || 'Unknown')}</span>
                    <span class="q-source-badge">${esc(q.source || 'admin')}</span>
                    ${q.created_at ? '<span>' + esc(q.created_at.slice(0, 10)) + '</span>' : ''}
                </div>
            </div>
        `).join('');
    } catch (err) {
        countEl.textContent = '';
        list.innerHTML = '<div class="quote-list-empty">Could not load: ' + esc(err.message) + '</div>';
    }
}

/**
 * Escapes special HTML characters in a string to prevent XSS.
 *
 * @param {String} str - Raw string to sanitize
 * @returns {String} HTML-safe version of the string
 */
function esc(str) {
    return String(str)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;')
        .replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

loadQuotes();

/**
 * Fetches one random quote and displays it in the quote-of-the-day spot.
 */
async function loadRandomQuote() {
    const textEl   = document.getElementById('wow-text');
    const authorEl = document.getElementById('wow-author');
    if (!textEl) return;
    textEl.textContent   = 'Loading\u2026';
    authorEl.textContent = '';
    try {
        const res   = await fetch('quotes/random_quote.php');
        const quote = await res.json();
        if (quote.error) throw new Error(quote.error);
        textEl.textContent   = '\u201c' + quote.text + '\u201d';
        authorEl.textContent = '\u2014 ' + (quote.author || 'Unknown');
    } catch (err) {
        textEl.textContent   = 'Could not load quote.';
        authorEl.textContent = '';
    }
}

loadRandomQuote();