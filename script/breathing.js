function genRandom(){
    return Math.floor(Math.random() * 201) - 100;
}

function sum(a, b){
    return a + b;
}

let playAgain = true;

while (playAgain) {

    let num1 = genRandom();
    let num2 = genRandom();
    let result = sum(num1, num2);

    let answer;

  
    while (true) {
        answer = prompt(`What is the sum of ${num1} and ${num2}?`);

        if (parseInt(answer) === result){
            alert("Correct!");
            break;   t
        } else {
            alert("Incorrect. Try again.");
        }
    }
    playAgain = confirm("Do you want to play again?");
}

alert("Goodbye!");
