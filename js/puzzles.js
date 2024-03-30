if (currentPuzzle == 6) {
    let help = "help";
    document.addEventListener('keypress', function (e) {
        key = e.key.toLowerCase();
        if (key == magic_word[index]) {
            index++;
            if (index == magic_word.length) {
                index = 0;
                let date = new Date();
                date.setTime(date.getTime() + 1000);
                let expiration = "expires=" + date.toUTCString();
                document.cookie = "puzzle6=ok;" + expiration + ";path=/";
                window.location.replace(window.location.href);
            }
        }
        if (key == help[index]) {
            index++;
            if (index == help.length) {
                index = 0;
                alert("Le code source JavaScript contient le mot clé, qu'il faudra taper sur cette page, pour réussir cette énigme.");
            }
        }
    });
}

if (currentPuzzle == 9) {
    const testAd = document.createElement("div");
    testAd.innerHTML = "&nbsp;";
    testAd.className = "ad-slot";
    document.body.appendChild(testAd);
    setTimeout(() => {
        const adBlockerActive = testAd.clientHeight === 0;
        document.body.removeChild(testAd);
        if (adBlockerActive) {
            jQuery.ajax({
                type: "POST",
                url: "puzzle9.php",
                data: {puzzle9: null},
                success: function(response) {
                    window.location.replace(window.location.href);
                }
            });
        }
    }, 333);
}