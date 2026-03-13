async function addQuote() {
    const text = document.getElementById('quoteText').value;
    const author = document.getElementById('quoteAuthor').value;

    const res = await fetch('add_quote.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ text, author })
    });
    const data = await res.json();
    document.getElementById('message').textContent = data.message;
    loadQuotes();
}

async function importQuotes() {
    const count = document.getElementById('importCount').value;

    const res = await fetch('import_quotes.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ count })
    });
    const data = await res.json();
    document.getElementById('message').textContent = data.message;
    loadQuotes();
}

async function loadQuotes() {
    const res = await fetch('get_quotes.php');
    const quotes = await res.json();

    const tbody = document.getElementById('quoteList');
    tbody.innerHTML = quotes.map(q => `
    <tr>
      <td>${q.text}</td>
      <td>${q.author}</td>
      <td>${q.source === 'api' ? '🌐 API' : '👤 Admin'}</td>
    </tr>
  `).join('');
}

loadQuotes();