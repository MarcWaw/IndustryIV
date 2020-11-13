function drawPoint(cordX, cordY, canvasID, name, color){
    var x = (cordX-49.5)*150;//(cordX-24.0)*40;
    var y = (cordY-13.5)*75;//(cordY+104)*30;
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
    var x1 = (cordX1-49.5)*150;//(cordX1-24.0)*40;
    var y1 = (cordY1-13.5)*75;//(cordY1+104)*30;
    var x2 = (cordX2-49.5)*150;//(cordX2-24.0)*40;
    var y2 = (cordY2-13.5)*75;//(cordY2+104)*30;
    var c = document.getElementById(canvasID);
    var ctx = c.getContext("2d");
    ctx.strokeStyle = color;
    ctx.beginPath();
    ctx.moveTo(y1, -x1+850);
    ctx.lineTo(y2, -x2+850);
    ctx.stroke();
}




