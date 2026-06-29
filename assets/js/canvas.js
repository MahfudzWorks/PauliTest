const canvas=document.getElementById("pauliCanvas");

const ctx=canvas.getContext("2d");

canvas.width=900;
canvas.height=1700;

const startX=50;

const startY=40;

const rowHeight=24;

const colWidth=40;

function draw(){

ctx.clearRect(0,0,canvas.width,canvas.height);

ctx.font="18px Arial";

ctx.fillStyle="#111";

for(let c=0;c<COLS;c++){

for(let r=0;r<ROWS;r++){

let x=startX+c*colWidth;

let y=startY+r*rowHeight;

ctx.fillText(

numbers[c][r],

x,

y

);

}

}

}

function draw(){

    ctx.clearRect(0,0,canvas.width,canvas.height);

    ctx.font="18px Arial";

    ctx.fillStyle="#111";

    for(let c=0;c<COLS;c++){

        for(let r=0;r<ROWS;r++){

            let x=startX+c*colWidth;

            let y=startY+r*rowHeight;

            ctx.fillText(numbers[c][r],x,y);

        }

    }

    drawCursor();

}