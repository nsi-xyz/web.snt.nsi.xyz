<?php
require_once '../include/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title><?= $translator->getMessage('panel_website_title') ?></title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include './include/nav_panel.php'; ?>
    <div id="main">
      <div class="header">
        <h1><?= $translator->getMessage("panel_header_h1") ?></h1>
        <h2><?= $translator->getMessage("panel_header_h2") ?></h2>
      </div>
      <div class="content">
        <msg></msg>
        <h2 class="content-subhead">Panneau d'administration</h2>
        <p class="p-content">Bienvenue sur le panneau d'administration de web.snt.nsi.xyz !</p>
        <p class="p-content">Ce panneau vous permet de créer des sessions, par exemple pour vos élèves si vous êtes enseignant, de parcourir vos anciennes sessions et d'avoir des statistiques détaillés sur ces dernières.</p>
        <?php if ($session->getCurrentUser()->hasPermission(Permission::VIEW_GLOBAL_STATS)) : ?>
          <h2 class="content-subhead">En quelques chiffres</h2>
          <p class="p-content">web.snt.nsi.xyz c'est :</p>
          <ul>
            <?php
            $sessions_nbr = count($gameSessionRepository->getAll());
            $users_nbr = count($userRepository->getAll());
            $puzzles_resolved_nbr = /*rowsCount($db, "users_session_logs", "1")*/'?';
            ?>
            <li><strong><?= $sessions_nbr ?></strong> sessions créées</li>
            <li><strong><?= $users_nbr ?></strong> utilisateurs inscrits</li>
            <li><strong><?= $puzzles_resolved_nbr ?></strong> énigmes résolues</li>
          </ul>
        <?php endif; ?>
        <h2 class="content-subhead">Gestion des données</h2>
        <p class="p-content">Toutes les données enregistrées le sont de manière sécurisée. Cela concerne les données de votre compte, ou encore les données relatives à vos sessions (pseudos des participants, résultats, etc.). Vous pouvez à tout moment demander la suppression de vos données et celles de vos sessions. Pour exercer ce droit, veuillez nous contacter.</p>
        <h2 class="content-subhead">Nous contacter</h2>
        <p class="p-content">Pour contacter un administrateur du site (laisser un avis, signaler un bug, suggérer des fonctionnalités, ou autres), utilisez le <a class="link" href="<?php echo traduction("external_contact_link"); ?>" target="_blank">formulaire de contact</a>.</p>
      </div>
    </div>
    <?php include '../include/footer.php'; ?>
  </div>
  <script src="../js/ui.js"></script>
</body>
</html>