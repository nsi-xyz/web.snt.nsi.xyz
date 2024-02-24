<?php
include("./include/checksession.php");
include("./include/functions.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title>Accueil • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav.php"); ?>
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 énigmes à résoudre pour découvrir le web</h2>
      </div>
      <div class="content">
        <h2 id="Que contient cette page d'aide" class="content-subhead">Que contient cette page d'aide</h2>
        <p class="p-content">Cette page d'aide te permet de comprendre comment résoudre les énigmes.<br>Certaines énigmes te proposeront un lien hypertexte pointant directement vers la section jugée utile, mais il est probable que pour chaque énigme il te faudra lire l'aide si tu n'es pas familier avec les langages HTML, CSS, ou JavaScript.</p>
        <h2 id="Comment afficher le code source HTML d'une page web" class="content-subhead">Comment afficher le code source HTML d'une page web</h2>
        <p class="p-content"><strong>L'une des méthodes les plus simples</strong> pour afficher le code source d'une page web est d'utiliser le raccourci clavier <kbd>Ctrl</kbd> + <kbd>U</kbd> (ou <kbd>Cmd</kbd> + <kbd>U</kbd> sur Mac) dans de nombreux navigateurs. Ce raccourci ouvre une nouvelle fenêtre ou un nouvel onglet contenant le code source HTML de la page web.</p>
        <h2 id="Structure de base en HTML" class="content-subhead">Structure de base en HTML</h2>
        <p class="p-content">Le code HTML est composé de balises (encadrées par des <span class="p-code">&lt;</span> <span class="p-code">&gt;</span>) qui décrivent la structure de la page web.<br>Vous y trouverez des balises telles que <span class="p-code">&lt;html&gt;</span>, <span class="p-code">&lt;head&gt;</span>, et <span class="p-code">&lt;body&gt;</span>, qui définissent la structure de la page.</p>
        <h2 id="Contenu d'une page HTML" class="content-subhead">Contenu d'une page HTML</h2>
        <p class="p-content">Le texte, les images, les liens, et d'autres éléments visibles sur la page sont inclus dans le code source à l'intérieur de balises HTML.<br>Par exemple, <span class="p-code">&lt;p&gt;</span> pour les paragraphes, <span class="p-code">&lt;img&gt;</span> pour les images, <span class="p-code">&lt;a&gt;</span> pour les liens, etc.</p>
        <h2 id="Intégration des CSS (Cascading Style Sheets)" class="content-subhead">Intégration des CSS (Cascading Style Sheets)</h2>
        <p class="p-content">Les règles de style qui définissent l'apparence de la page web peuvent être intégrées directement dans le code source HTML.<br>Vous les trouverez dans la section <span class="p-code">&lt;head&gt;</span> du HTML, à l'intérieur de balises <span class="p-code">&lt;style&gt;</span> ou intégrées dans des balises <span class="p-code">&lt;link&gt;</span>.<br>Les CSS décrivent la police, les couleurs, les marges, le positionnement des éléments, etc.<br>Les règles de style peuvent également être définies par un fichier externe.</p>
        <h2 id="Inclusion des scripts JavaScript" class="content-subhead">Inclusion des scripts JavaScript</h2>
        <p class="p-content">Les scripts JavaScript, qui ajoutent des fonctionnalités dynamiques à la page, peuvent être intégrés directement dans le code HTML.<br>Vous les trouverez souvent à l'intérieur de balises <span class="p-code">&lt;script&gt;</span> dans la section <span class="p-code">&lt;head&gt;</span> ou à la fin du code HTML, à l'intérieur de la section <span class="p-code">&lt;body&gt;</span>.<br>Ils peuvent également être inclus via des fichiers externes, en utilisant la balise <span class="p-code">&lt;script&gt;</span> avec l'attribut <span class="p-code">src</span> pour spécifier l'emplacement du fichier JavaScript.</p>
        <h2 id="Localiser des fichiers externes" class="content-subhead">Localiser des fichiers externes</h2>
        <p class="p-content">Les fichiers CSS et JavaScript peuvent également être inclus en tant que fichiers externes.<br>Les balises <span class="p-code">&lt;link&gt;</span> pour les fichiers CSS et <span class="p-code">&lt;script&gt;</span> avec l'attribut src pour les fichiers JavaScript sont utilisées pour lier ces fichiers depuis des emplacements distants.</p>
        <h2 id="L'utilité des commentaires en HTML, CSS, et JavaScript" class="content-subhead">L'utilité des commentaires en HTML, CSS, et JavaScript</h2>
        <p class="p-content">Les commentaires dans le code source servent à expliquer, documenter et organiser le code, facilitant ainsi sa compréhension, sa maintenance, et la collaboration entre développeurs.<br><strong>En HTML :</strong> Les commentaires sont entourés de <span class="p-code">&lt;!--</span> et <span class="p-code">--&gt;</span>.<br>Par exemple : <span class="p-code">&lt;!-- Ceci est un commentaire --&gt;</span>.<br><strong>En CSS :</strong> Les commentaires sont inclus entre <span class="p-code">/*</span> et <span class="p-code">*/</span>.<br>Par exemple : <span class="p-code">/* Commentaire CSS */</span>.<br><strong>En JavaScript :</strong> Les commentaires d'une ligne commencent par <span class="p-code">//</span>, tandis que les commentaires multi-lignes sont encadrés par <span class="p-code">/*</span> et <span class="p-code">*/</span>.</p>
        <h2 id="Chercher un terme sur une page web" class="content-subhead">Chercher un terme sur une page web</h2>
        <p class="p-content">Pour rechercher rapidement un élément spécifique sur une page, vous pouvez utiliser une fonctionnalité pratique appelée <q>Recherche sur la page</q>. Pour ce faire, appuyez sur les touches <kbd>Ctrl</kbd> et <kbd>F</kbd> simultanément sur votre clavier (ou <kbd>Cmd</kbd> et <kbd>F</kbd> sur un Mac). Cela fera apparaître une petite boîte de recherche où vous pouvez taper le mot ou la phrase que vous cherchez. Ensuite, le navigateur marquera toutes les occurrences de cet élément sur la page, vous permettant de les trouver facilement sans avoir à faire défiler tout le contenu. C'est une astuce utile pour gagner du temps lors de la navigation sur le web.</p>
        <h2 id="Comment rafraîchir / actualiser une page web" class="content-subhead">Comment rafraîchir / actualiser une page web</h2>
        <p class="p-content">Actualiser une page web est une action simple qui permet de mettre à jour le contenu affiché dans votre navigateur. Voici comment procéder :</p>
        <p class="p-content"><strong>Utiliser la touche de rafraîchissement :</strong> La méthode la plus courante consiste à utiliser la touche <kbd>F5</kbd> de votre clavier.</p>
        <p class="p-content"><strong>Raccourci clavier :</strong> Un raccourci clavier pratique consiste à appuyer simultanément sur <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> sur Mac) et la touche <kbd>R</kbd> pour actualiser la page en cours.</p>
        <p class="p-content"><strong>Clic droit et actualiser :</strong> En effectuant un clic droit n'importe où sur la page web (sauf sur des liens ou des images), sélectionnez l'option <q>Actualiser</q> dans le menu contextuel.</p>
        <p class="p-content"><strong>Bouton d'actualisation :</strong> La plupart des navigateurs disposent d'un bouton <q>Actualiser</q> dans leur barre d'outils. Cliquez simplement sur ce bouton pour actualiser la page.</p>
        <h2 id="Visualiser les cookies déposés par un site web" class="content-subhead">Visualiser les cookies déposés par un site web</h2>
        <p class="p-content">Pour visualiser les cookies d'un site web, on va devoir installer une extension au navigateur. Une extension, également appelée module complémentaire ou add-on, est un petit programme informatique qui s'intègre dans votre navigateur web pour ajouter des fonctionnalités ou modifier son comportement. Ces extensions sont conçues pour personnaliser votre expérience de navigation en vous permettant d'ajouter des fonctionnalités supplémentaires, de bloquer des publicités, de gérer des cookies, de traduire des pages web, et bien plus encore.<br>L'extension à installer pour visualiser les cookies dépend de votre navigateur actuel.</p>
        <table class="pure-table">
          <thead>
            <tr>
              <th>Edge</th>
              <th>Firefox</th>
              <th>Chrome</th>
              <th>Safari</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a class="link" href="https://microsoftedge.microsoft.com/addons/detail/cookieeditor/neaplmfkghagebokkhpjpoebhdledlfi">Cookie-Editor</a></td>
              <td><a class="link" href="https://addons.mozilla.org/fr/firefox/addon/cookie-quick-manager/">Cookie Quick Manager</a></td>
              <td><a class="link" href="https://chrome.google.com/webstore/detail/editthiscookie/fngmhnnpilhplaeedifhccceomclgfbg">EditThisCookie</a></td>
              <td><a class="link" href="https://apps.apple.com/fr/app/cookie-editor/id6446215341">Cookie-Editor</a></td>
            </tr>
          </tbody>
        </table>
        <p class="p-content">Une fois l'extension installée, vous pouvez y accéder via une icône ressemblant à une pièce de puzzle dans la barre supérieure de votre navigateur.</p>
        <h2 id="Modifier / supprimer un cookie" class="content-subhead">Modifier / supprimer un cookie</h2>
        <p class="p-content">Pour modifier ou supprimer un cookie, vous devrez passer par l'extension préalablement installée.</p>
        <h2 id="Bloquer les publicités" class="content-subhead">Bloquer les publicités</h2>
        <p class="p-content">Pour bloquer les publicités des sites web, il suffit d'installer une extension au navigateur. L'extension à installer est <q>uBlock Origin</q> sur la plupart des navigateurs.</p>
        <table class="pure-table">
          <thead>
            <tr>
              <th>Edge</th>
              <th>Firefox</th>
              <th>Chrome</th>
              <th>Safari</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><a class="link" href="https://microsoftedge.microsoft.com/addons/detail/ublock-origin/odfafepnkmbhccpbejgmiehpchacaeak">uBlock Origin</a></td>
              <td><a class="link" href="https://addons.mozilla.org/fr/firefox/addon/ublock-origin/">uBlock Origin</a></td>
              <td><a class="link" href="https://chrome.google.com/webstore/detail/ublock-origin/cjpalhdlnbpafiamejdnhcphjbkeiagm">uBlock Origin</a></td>
              <td><a class="link" href="https://apps.apple.com/fr/app/adblock-pour-safari/id1402042596">AdBlock</a></td>
            </tr>
          </tbody>
        </table>
        <h2 id="Effacer sa progression et recommencer les énigmes" class="content-subhead">Effacer sa progression et recommencer les énigmes</h2>
        <p class="p-content">En cliquant sur le bouton si dessous, vous effacez votre progression et recommencez de zéro. Cette action est irréversible.</p>
        <button class ="reset-button" type="button" onclick="reset()">Effacer / Recommencer</button>
        <?php
        if (isset($_COOKIE["reset-js"])) {
          resetSession("./index.php");
        }
        ?>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
  </div>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
  <script>
    function reset() {
      let date = new Date();
      date.setTime(date.getTime() + 1000);
      let expiration = "expires=" + date.toUTCString();
      document.cookie = "reset-js=ok;" + expiration + ";path=/";
      window.location.replace((window.location.href).replace("#" + encodeURIComponent("Effacer sa progression et recommencer les énigmes"), ""));
    }
    </script>
</body>
</html>
