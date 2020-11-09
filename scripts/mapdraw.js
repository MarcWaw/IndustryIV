function drawPoint(cordX, cordY, canvasID, name, color){
    var x = (cordX-49.5)*150;
    var y = (cordY-13.5)*75;
    var c = document.getElementById(canvasID);
    var ctx = c.getContext("2d");
    ctx.beginPath();
    ctx.font = "10px Arial";
    ctx.strokeStyle = color;
    ctx.fillStyle = color;
    ctx.fillText(name,  y + 10, -x+850);
    ctx.arc(y, -x+850, 2, 0, 2 * Math.PI);
    ctx.stroke();
}

function connectPoints(cordX1, cordY1, cordX2, cordY2, canvasID, color){
    var x1 = (cordX1-49.5)*150;
    var y1 = (cordY1-13.5)*75;
    var x2 = (cordX2-49.5)*150;
    var y2 = (cordY2-13.5)*75;
    var c = document.getElementById(canvasID);
    var ctx = c.getContext("2d");
    ctx.strokeStyle = color;
    ctx.moveTo(y1, -x1+850);
    ctx.lineTo(y2, -x2+850);
    ctx.stroke();
}

function moveCanvas(canvasID){
    var canvas = document.getElementById(canvasID),
    context = canvas.getContext('2d');
    
    context.translate(0,850);
    context.rotate(270 * Math.PI / 180);
}



