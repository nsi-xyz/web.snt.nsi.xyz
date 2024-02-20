function openPopup() {
    document.getElementById("popup").style.display = "block";
    document.body.style.overflow = "hidden";
}

function closePopup() {
    document.getElementById("popup").style.display = "none";
    document.body.style.overflow = "auto";
}

openPopup();
console.log("popup opened")