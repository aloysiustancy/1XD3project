async function loadQuote() {
    const textEl = document.getElementById("wow-text");
    const authorEl = document.getElementById("wow-author");

    try {
        const res = await fetch("quotes/get_quote.php");
        const data = await res.json();

        if (data.error) throw new Error();

        textEl.innerText = `"${data.quoteText}"`;
        authorEl.innerText = `— ${data.author || "Unknown"}`;

    } catch {
        textEl.innerText = "Could not load quote.";
    }
}

loadQuote();


// ===== MODAL LOGIC =====
const btn = document.getElementById("add-quote-btn");
const modal = document.getElementById("quote-modal");
const closeBtn = document.getElementById("close-modal");
const submitBtn = document.getElementById("submit-quote");
const message = document.getElementById("modal-message");

btn.onclick = () => {
    modal.classList.remove("hidden");
};

closeBtn.onclick = () => modal.classList.add("hidden");

submitBtn.onclick = async () => {
    const text = document.getElementById("quote-input").value;
    const author = document.getElementById("author-input").value;

    try {
        const res = await fetch("quotes/set_quote.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ text, author })
        });

        const data = await res.json();

        if (data.success) {
            message.innerText = "Quote added successfully!";
            message.className = "success";

            document.getElementById("quote-input").value = "";
            document.getElementById("author-input").value = "";

            loadQuote();
        } else {
            message.innerText = data.error || "Failed to add quote";
            message.className = "error";
        }

    } catch {
        showMessage("Server error");
    }
};

function showMessage(msg) {
    message.innerText = msg;
}