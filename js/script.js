function throwSuccess(message) {
    let msg = document.querySelector("msg");
    msg.setAttribute("class", "success-message");
    msg.textContent = message;
}

function throwError(message) {
    let msg = document.querySelector("msg");
    msg.setAttribute("class", "error-message");
    msg.textContent = message;
}

function throwInfo(message) {
    let msg = document.querySelector("msg");
    msg.setAttribute("class", "info-message");
    msg.textContent = message;
}