function throwSuccess(message, tag) {
    let msg = document.querySelector(tag);
    msg.setAttribute("class", "success-message");
    msg.innerHTML = message;
}

function throwError(message, tag) {
    let msg = document.querySelector(tag);
    msg.setAttribute("class", "error-message");
    msg.innerHTML = message;
}

function throwInfo(message, tag) {
    let msg = document.querySelector(tag);
    msg.setAttribute("class", "info-message");
    msg.innerHTML = message;
}