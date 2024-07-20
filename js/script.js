function throwError(message, id_widget) {
    let error = document.querySelector(`error-${id_widget}`);
    error.setAttribute("class", "error-message");
    error.textContent = message;
}