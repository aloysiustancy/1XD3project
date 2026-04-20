document.addEventListener("DOMContentLoaded", () => {
    loadQA();
});

let currentQuestionID = null;
let answered = false;

function loadQA() {
    fetch("qanda/get_qa.php")
        .then(res => res.json())
        .then(data => {

            const questionEl = document.getElementById("qa-question");
            const answerBox = document.getElementById("qa-answer-box");
            const userAnswerEl = document.getElementById("qa-user-answer");
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

            // Answered
            if (data.userAnswer) {
                answered = true;

                userAnswerEl.textContent = "Your answer: " + data.userAnswer.answerText;
                userAnswerEl.classList.remove("hidden");

            } else {
                answered = false;
                answerBox.classList.remove("hidden");
            }

            // Show other people's answers
            if (data.others && data.others.length > 0) {
                let html = `
                    <table class="qa-table">
                        <tr>
                            <th>UserID</th>
                            <th>Answer</th>
                        </tr>
                `;

                data.others.forEach(a => {
                    html += `
                        <tr>
                            <td>${a.userID}</td>
                            <td>${a.answerText}</td>
                        </tr>
                    `;
                });

                html += "</table>";

                othersContainer.innerHTML = html;
            } else if(data.userAnswer) {

                othersContainer.innerHTML = `
                    <p style="color:red; font-size:20px; margin-top:10px;">
                        No other responses yet. Be the first!
                    </p>
                `;
            }
        });
}

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

    const text = input.value;

    fetch("qanda/submit_answer.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            questionID: currentQuestionID,
            answerText: text
        })
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

    // ===== QUESTION MODAL =====
function showQuestionModal() {
    document.getElementById("question-modal").classList.remove("hidden");
}

    // Close button
document.querySelectorAll(".close-modal").forEach(btn => {
    btn.onclick = () => {
        btn.closest(".modal").classList.add("hidden");
    };
});

// Submit an issue
document.getElementById("submit-question").onclick = async () => {
    const text = document.getElementById("question-input").value;

    const res = await fetch("qanda/set_question.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ text })
    });

    const data = await res.json();

    const msg = document.getElementById("question-message");

    if (data.success) {

        showModal("Success", "Question added!");

        // Close pop-up window
        document.getElementById("question-modal").classList.add("hidden");

        // Clear input box
        document.getElementById("question-input").value = "";

        // Refresh page data
        loadQA();

    } else {
        closeQuestionModal();

        showModal("Error", data.error || "Error");
    }
};

function closeQuestionModal() {
    document.getElementById("question-modal").classList.add("hidden");
}
