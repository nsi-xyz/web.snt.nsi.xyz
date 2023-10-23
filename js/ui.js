(function (window, document) {

    // Cette fonction récupère les éléments HTML que nous utilisons fréquemment, tels que le menu et les liens, en fonction de leurs identifiants.
    function getElements() {
        return {
            layout: document.getElementById('layout'),
            menu: document.getElementById('menu'),
            menuLink: document.getElementById('menuLink')
        };
    }

    // Cette fonction ajoute ou supprime une classe CSS d'un élément pour basculer son état actif.
    function toggleClass(element, className) {
        var classes = element.className.split(/\s+/);
        var length = classes.length;
        var i = 0;

        // Nous parcourons les classes existantes pour trouver la classe à ajouter ou supprimer.
        for (; i < length; i++) {
            if (classes[i] === className) {
                classes.splice(i, 1); // Si la classe existe, nous la supprimons.
                break;
            }
        }
        // Si la classe n'a pas été trouvée, nous l'ajoutons.
        if (length === classes.length) {
            classes.push(className);
        }

        // Nous mettons à jour la liste des classes de l'élément.
        element.className = classes.join(' ');
    }

    // Cette fonction bascule l'état actif de plusieurs éléments, comme le layout, le menu et le menuLink.
    function toggleAll() {
        var active = 'active'; // Le nom de la classe CSS "active".
        var elements = getElements();

        toggleClass(elements.layout, active);
        toggleClass(elements.menu, active);
        toggleClass(elements.menuLink, active);
    }
    
    // Cette fonction gère les événements de clic sur la page.
    function handleEvent(e) {
        var elements = getElements();
        
        // Si le clic se produit sur le lien du menu, nous basculons l'état actif.
        if (e.target.id === elements.menuLink.id) {
            toggleAll();
            e.preventDefault();
        } else if (elements.menu.className.indexOf('active') !== -1) {
            toggleAll();
        }
    }
    
    document.addEventListener('click', handleEvent);

}(this, this.document));