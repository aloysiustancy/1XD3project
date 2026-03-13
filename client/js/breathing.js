const canvas = document.getElementById("breathingCanvas");
const ctx = canvas.getContext("2d");

const instruction = document.getElementById("instruction");
const startBtn = document.getElementById("startBtn");
const stopBtn = document.getElementById("stopBtn");

const centerX = canvas.width / 2;
const centerY = canvas.height / 2;
const radius = 90;

let animationId = null;
let phaseStart = 0;

const phases = [
    {name:"Inhale", duration:4000},
    {name:"Hold", duration:8000},
    {name:"Exhale", duration:7000}
];

let phaseIndex = 0;

function drawRing(progress){

    ctx.clearRect(0,0,canvas.width,canvas.height);

    // background ring
    ctx.beginPath();
    ctx.arc(centerX,centerY,radius,0,Math.PI*2);
    ctx.strokeStyle="#334155";
    ctx.lineWidth=15;
    ctx.stroke();

    // progress ring
    ctx.beginPath();
    ctx.arc(
        centerX,
        centerY,
        radius,
        -Math.PI/2,
        -Math.PI/2 + progress * Math.PI*2
    );
    ctx.strokeStyle="#38bdf8";
    ctx.lineWidth=15;
    ctx.lineCap="round";
    ctx.stroke();
}

function animate(timestamp){

    const phase = phases[phaseIndex];

    if(!phaseStart) phaseStart = timestamp;

    const elapsed = timestamp - phaseStart;
    const progress = Math.min(elapsed / phase.duration,1);

    drawRing(progress);

    if(progress >= 1){
        phaseIndex = (phaseIndex + 1) % phases.length;
        phaseStart = timestamp;
        instruction.textContent = phases[phaseIndex].name;
    }

    animationId = requestAnimationFrame(animate);
}

startBtn.onclick = () => {

    if(!animationId){
        phaseStart = 0;
        instruction.textContent = phases[phaseIndex].name;
        animationId = requestAnimationFrame(animate);
    }

};

stopBtn.onclick = () => {

    cancelAnimationFrame(animationId);
    animationId = null;
    instruction.textContent = "Paused";

};