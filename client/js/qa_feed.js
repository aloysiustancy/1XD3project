document.addEventListener("DOMContentLoaded", () => {
    loadQA();
});

let currentQuestionID = null;
let answered = false;

function loadQA() {
    fetch("Q&A/get_qa.php")
        .then(res => res.json())
        .then(data => {

            const questionEl = document.getElementById("qa-question");
            const answerBox = document.getElementById("qa-answer-box");
            const userAnswerEl = document.getElementById("qa-user-answer");

            answerBox.classList.add("hidden");
            userAnswerEl.classList.add("hidden");

            if (!data.question) {
                questionEl.textContent = "No question today.";
                return;
            }

            const q = data.question;
            questionEl.textContent = q.questionText;
            currentQuestionID = q.questionID;

            console.log("questionID:", currentQuestionID); // 👈 加这里

            // 已回答
            if (data.userAnswer) {
                answered = true;

                userAnswerEl.textContent = "Your answer: " + data.userAnswer.answerText;
                userAnswerEl.classList.remove("hidden");

            } else {
                answered = false;

                answerBox.classList.remove("hidden");
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

    fetch("Q&A/submit_answer.php", {
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

        loadQA(); // 🔥刷新
    });
}

    // ===== QUESTION MODAL =====
function showQuestionModal() {
    document.getElementById("question-modal").classList.remove("hidden");
}

    // 关闭按钮
document.querySelectorAll(".close-modal").forEach(btn => {
    btn.onclick = () => {
        btn.closest(".modal").classList.add("hidden");
    };
});

// 提交问题
document.getElementById("submit-question").onclick = async () => {
    const text = document.getElementById("question-input").value;

    const res = await fetch("Q&A/set_question.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ text })
    });

    const data = await res.json();

    const msg = document.getElementById("question-message");

    if (data.success) {
        msg.innerText = "Question added!";
        msg.style.color = "green";

        document.getElementById("question-input").value = "";
    } else {
            msg.innerText = data.error || "Error";
            msg.style.color = "red";
    }
};
