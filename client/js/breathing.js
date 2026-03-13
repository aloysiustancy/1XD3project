const progress = document.getElementById("progress");
const instruction = document.getElementById("instruction");

const startBtn = document.getElementById("startBtn");
const stopBtn = document.getElementById("stopBtn");

const circumference = 2 * Math.PI * 90;

let timer = null;

const phases = [
    { name:"Inhale", duration:4000 },
    { name:"Hold", duration:7000 },
    { name:"Exhale", duration:8000 }
];

let phaseIndex = 0;

function animateRing(duration){

    progress.style.transition = "none";
    progress.style.strokeDashoffset = circumference;

    setTimeout(() => {

        progress.style.transition = `stroke-dashoffset ${duration}ms linear`;
        progress.style.strokeDashoffset = 0;

    }, 20);
}

function nextPhase(){

    const phase = phases[phaseIndex];

    instruction.textContent = phase.name;

    animateRing(phase.duration);

    timer = setTimeout(() => {

        phaseIndex = (phaseIndex + 1) % phases.length;
        nextPhase();

    }, phase.duration);
}

startBtn.onclick = () => {

    if(!timer){
        nextPhase();
    }

}

stopBtn.onclick = () => {

    clearTimeout(timer);
    timer = null;

    instruction.textContent = "Paused";

}