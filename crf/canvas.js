const signatureCanvas = document.getElementById("signature-canvas");
const signatureDataInput = document.getElementById("signature-data");
const canvasContext = signatureCanvas.getContext("2d");
let isDrawing = false;

signatureCanvas.addEventListener("mousedown", (e) => {
    isDrawing = true;
    const rect = signatureCanvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    canvasContext.beginPath();
    canvasContext.moveTo(x, y);
});

signatureCanvas.addEventListener("mousemove", (e) => {
    if (isDrawing) {
    const rect = signatureCanvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    canvasContext.lineTo(x, y);
    canvasContext.stroke();
    }
});

signatureCanvas.addEventListener("mouseup", () => {
    isDrawing = false;
    signatureDataInput.value = signatureCanvas.toDataURL();
});

function clearSignatureCanvas() {
    canvasContext.clearRect(0, 0, signatureCanvas.width, signatureCanvas.height);
    signatureDataInput.value = "";
}