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
        <?php include("./include/table.php"); ?>
      </div>
      <div class="content">
        <h2 class="content-subhead">web : World Wide Web</h2>
        <p class="p-content">Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Il est composé de milliards de pages web interconnectées qui sont accessibles via des navigateurs web tels que Chrome, Firefox, Safari, etc.</p>
        <h2 class="content-subhead">snt : Sciences Numériques et Technologie</h2>
        <p class="p-content">La matière <q>SNT</q> est l'acronyme de <q>Sciences Numériques et Technologie</q>. C'est une matière enseignée dans le système éducatif français au lycée. Les cours de SNT visent à sensibiliser les élèves aux enjeux liés à l'informatique, à la technologie et à la société numérique. Cette matière a été introduite dans le programme scolaire pour aider les élèves à mieux comprendre le monde numérique dans lequel nous vivons, y compris les aspects techniques, éthiques et sociaux.</p>
        <h2 class="content-subhead">nsi : Numérique et Sciences Informatiques</h2>
        <p class="p-content"><q>Numérique et Sciences Informatiques</q>, est une spécialité enseignée dans dans les lycées français à partir de la classe de 1ère. Elle fait partie de la réforme du baccalauréat et du programme de lycée qui a été mis en place en 2019. L'objectif de la NSI est d'initier les élèves aux concepts fondamentaux de l'informatique et de la programmation, ainsi qu'aux enjeux liés au numérique.</p>
        <h2 class="content-subhead">xyz : extension de domaine de premier niveau (TLD)</h2>
        <p class="p-content">Le terme <q>.xyz</q> fait référence à une extension de domaine de premier niveau (TLD) utilisée pour les adresses Internet. Les TLD sont les parties finales des noms de domaine, telles que <q>.com</q>, <q>.org</q>, <q>.net</q>, et ainsi de suite. <q>.xyz</q> est l'un de ces TLD, et il a été introduit en 2014.</p>
        <h2 class="content-subhead">web.snt.nsi.xyz</h2>
        <p class="p-content">web.snt.nsi.xyz est un site web qui propose 10 petites énigmes.</p>
        <h2 class="content-subhead">42 minutes pour résoudre 10 énigmes.</h2>
        <p class="p-content">Des informations ont été cachées sur chacune des pages de ce site, à toi de les retrouver et pour cela tu ne dispose que de 42 minutes. Les pages étant générées aléatoirement, inutile de regarder sur l'écran de ton voisin. Pour les 9 premières énigmes, tout ce dont tu as besoin se trouve quelque part, dans les fichiers de ce site web qui contient 12 pages et 10 énigmes.</p>
      </div>
    </div>
    <?php include("./include/footer.php"); ?>
  </div>
  <script>
    const currentPuzzle = null;
  </script>
  <script src="./js/ui.js"></script>
  <?php include("./include/timer.php"); ?>
</body>
</html>