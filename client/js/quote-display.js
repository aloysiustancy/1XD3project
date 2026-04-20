/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Handles the quote display and user submission on the community page.
 *              Loads a quote on page load, and lets users suggest a new quote
 *              through a modal popup.
 */

document.addEventListener("DOMContentLoaded", () => {

    /**
     * Fetches a quote from the server and displays the text and author.
     */
    async function loadQuote() {
        const textEl   = document.getElementById("wow-text");
        const authorEl = document.getElementById("wow-author");

        try {
            const res  = await fetch("quotes/get_quote.php");
            const data = await res.json();
            if (data.error) throw new Error();
            textEl.innerText   = `"${data.quoteText}"`;
            authorEl.innerText = `— ${data.author || "Unknown"}`;
        } catch {
            textEl.innerText = "Could not load quote.";
        }
    }

    loadQuote();

    const btn       = document.getElementById("add-quote-btn");
    const modal     = document.getElementById("quote-modal");
    const submitBtn = document.getElementById("submit-quote");
    const message   = document.getElementById("modal-message");

    btn.onclick = () => modal.classList.remove("hidden");

    document.querySelectorAll(".close-modal").forEach(btn => {
        btn.onclick = () => btn.closest(".modal").classList.add("hidden");
    });

    submitBtn.onclick = async () => {
        const text   = document.getElementById("quote-input").value;
        const author = document.getElementById("author-input").value;

        try {
            const res  = await fetch("quotes/set_quote.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ text, author })
            });
            const data = await res.json();

            if (data.success) {
                showMessage("Quote added successfully!");
                message.className = "success";
                document.getElementById("quote-input").value  = "";
                document.getElementById("author-input").value = "";
                loadQuote();
            } else {
                showMessage(data.error || "Failed to add quote");
                message.className = "error";
            }
        } catch {
            showMessage("Server error");
        }
    };

    /**
     * Displays a status message inside the modal.
     *
     * @param {String} msg - The message to show
     */
    function showMessage(msg) {
        message.innerText = msg;
    }

});