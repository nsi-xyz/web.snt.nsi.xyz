(function (window, document) {

    // This function retrieves HTML elements that we frequently use, such as the menu and links, based on their identifiers.
    function getElements() {
        return {
            layout: document.getElementById('layout'),
            menu: document.getElementById('menu'),
            menuLink: document.getElementById('menuLink')
        };
    }

    // This function adds or removes a CSS class from an element to toggle its active state.
    function toggleClass(element, className) {
        var classes = element.className.split(/\s+/);
        var length = classes.length;
        var i = 0;

        // We iterate through the existing classes to find the class to add or remove.
        for (; i < length; i++) {
            if (classes[i] === className) {
                classes.splice(i, 1); // If the class exists, we remove it.
                break;
            }
        }
        // If the class has not been found, we add it.
        if (length === classes.length) {
            classes.push(className);
        }

        // We update the list of classes for the element.
        element.className = classes.join(' ');
    }

    // This function toggles the active state of multiple elements, such as the layout, menu, and menuLink.
    function toggleAll() {
        var active = 'active'; // The name of the CSS class is "active".
        var elements = getElements();

        toggleClass(elements.layout, active);
        toggleClass(elements.menu, active);
        toggleClass(elements.menuLink, active);
    }
    
    // This function handles click events on the page.
    function handleEvent(e) {
        var elements = getElements();
        
        // If the click occurs on the menu link, we toggle the active state.
        if (e.target.id === elements.menuLink.id) {
            toggleAll();
            e.preventDefault();
        } else if (elements.menu.className.indexOf('active') !== -1) {
            toggleAll();
        }
    }
    
    document.addEventListener('click', handleEvent);

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


}(this, this.document));