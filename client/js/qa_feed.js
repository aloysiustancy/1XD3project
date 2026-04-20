/**
 * Name: Brian, Aloysius, Haoxuan, Jason
 * Date: March 21, 2026
 * Description: Runs the daily Q&A feed on the community page. Loads today's
 *              question and existing answers, lets users submit one answer per day,
 *              and lets admins post a new question via a modal.
 */

document.addEventListener("DOMContentLoaded", () => {
    loadQA();
});

let currentQuestionID = null;
let answered = false;

/**
 * Fetches today's question and answers from the server and renders them.
 * Shows the answer input if the user hasn't answered yet, or their previous
 * answer and other responses if they have.
 */
function loadQA() {
    fetch("qanda/get_qa.php")
        .then(res => res.json())
        .then(data => {

            const questionEl      = document.getElementById("qa-question");
            const answerBox       = document.getElementById("qa-answer-box");
            const userAnswerEl    = document.getElementById("qa-user-answer");
            const othersContainer = document.getElementById("qa-others");

            answerBox.classList.add("hidden");
            userAnswerEl.classList.add("hidden");
            othersContainer.innerHTML = "";

            if (!data.question) {
                questionEl.textContent = "Moderators did not upload any questions today.";
                return;
            }

            const q = data.question;
            questionEl.textContent = q.questionText;
            currentQuestionID = q.questionID;

            if (data.userAnswer) {
                answered = true;
                userAnswerEl.textContent = "Your answer: " + data.userAnswer.answerText;
                userAnswerEl.classList.remove("hidden");
            } else {
                answered = false;
                answerBox.classList.remove("hidden");
            }

            // Show other people's answers
            if (answered && data.others && data.others.length > 0) {
            if (data.others && data.others.length > 0) {
                let html = `
                    <table class="qa-table">
                        <tr>
                            <th>Other Answers</th>
                        </tr>
                        <tr><th>UserID</th><th>Answer</th></tr>
                `;
                data.others.forEach(a => {
                    html += `
                        <tr>
                            <td>${a.answerText}</td>
                        </tr>
                    `;
                    html += `<tr><td>${a.userID}</td><td>${a.answerText}</td></tr>`;
                });
                html += "</table>";
                othersContainer.innerHTML = html;
            } else if(answered) {

            } else if (data.userAnswer) {
                othersContainer.innerHTML = `
                    <p style="color:red; font-size:20px; margin-top:10px;">
                        No other responses yet. Be the first!
                    </p>
                `;
            } 
            if (!answered) {
                othersContainer.innerHTML = `
                    <p style="color:gray; margin-top:10px;">
                        Answer the question to see others' responses.
                    </p>
                `;
            }
        });
}

/**
 * Reads the user's answer from the input and sends it to the server.
 * Blocks submission if the user already answered today or the field is empty.
 */
function submitAnswer() {

    if (answered) {
        showModal("Locked", "You already answered today.");
        return;
    }

    const input = document.getElementById("qa-input");

    if (!input || !input.value.trim()) {
        showModal("Error", "Please enter an answer.");
        return;
    }

    fetch("qanda/submit_answer.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ questionID: currentQuestionID, answerText: input.value })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "exists") {
            answered = true;
            showModal("Locked", "You already answered today.");
            return;
        }
        showModal("Saved!", "Your answer has been recorded.");
        loadQA();
    });
}

/**
 * Opens the "Submit a Question" modal.
 */
function showQuestionModal() {
    document.getElementById("question-modal").classList.remove("hidden");
}

/**
 * Closes the "Submit a Question" modal.
 */
function closeQuestionModal() {
    document.getElementById("question-modal").classList.add("hidden");
}

document.querySelectorAll(".close-modal").forEach(btn => {
    btn.onclick = () => btn.closest(".modal").classList.add("hidden");
});

document.getElementById("submit-question").onclick = async () => {

    const text = document.getElementById("question-input").value;

    const res  = await fetch("qanda/set_question.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ text })
    });

    const data = await res.json();

    if (data.success) {
        showModal("Success", "Question added!");
        document.getElementById("question-modal").classList.add("hidden");
        document.getElementById("question-input").value = "";
        loadQA();
    } else {
        closeQuestionModal();
        showModal("Error", data.error || "Error");
    }
};