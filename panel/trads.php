<?php
include("./include/db.php");
include("../include/functions.php");
include("../include/checksession.php");

if (isset($_POST["new_trad"], $_POST["id_trad"])) {
  //updateTrad($db, "fr", $_POST["key_trad"], $_POST["new_trad"]);
  $new = $_POST["new_trad"];
  $id_trad = $_POST["id_trad"];
  updateRow($db, "traductions_fr", array("value" => $new), "id = \"$id_trad\"");
  echo json_encode(["success" => true]);
  exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Le web, également connu sous le nom de World Wide Web (WWW), est un système d'information en ligne qui permet de consulter et de partager des documents et des ressources sur Internet. Sa découverte est au programme de SNT, en classe de seconde en France.">
  <title>Accueil • web.snt.nsi.xyz</title>
  <link rel="stylesheet" href="../css/pure-min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
  <div id="layout">
    <a href="#menu" id="menuLink" class="menu-link">
      <span></span>
    </a>
    <?php include("./include/nav_panel.php"); ?>
    <div id="main">
      <div class="header">
        <h1>web.snt.nsi.xyz</h1>
        <h2>10 énigmes à résoudre pour découvrir le web</h2>
      </div>
      <div class="content">
        <h2 class="content-subhead">Panneau d'édition des traductions (bêta)</h2>
        <p class="p-content">Ce panneau permet de créer et d'éditer des traductions utilisées partout sur le site.</p>
        <h2 class="content-subhead">Obtenir une clée de traduction</h2>
        <p class="p-content">Pour afficher les clés des traductions au lieu de leur valeur, définissez la langue du site sur <span class="p-code">debug</span>.</p>
      </div>
      <div class="trad-box">
        <form method="GET" action="" class="pure-form">
          <input type="text" name="key" placeholder="<?php echo traduction("trads_search_key_placeholder"); ?>" value="<?php echo isset($_GET["key"]) ? $_GET["key"] : ""; ?>" required>
          <button type="submit" class="pure-button"><?php echo traduction("trads_search_key_button"); ?></button>
        </form>
        <div class="box">
          <div class="key-box">
            <h3>Clés de traduction</h3>
            <ul class="key-list">
              <?php
              if (isset($_GET["key"])) {
                $trads = getRows($db, "traductions_".$_SESSION["locale"], "*", "trad", 1, "\"%".$_GET["key"]."%\"");
                $trads_research = null;
                $trads_id = null;
                foreach ($trads as $trad) {
                  $trads_research[$trad['trad']] = $trad['value'];
                  $trads_research[$trad['id']] = $trad['value'];
                  $trads_id[$trad['trad']] = $trad['id'];
                }
                if ($trads_research != null) {
                  foreach ($trads_research as $trad => $value) {
                    if (!is_int($trad)) {
                      echo "<li class=\"key-item\"><button class=\"key-button-item\" data-key=\"".$trads_id[$trad]."\" onclick=\"editTrad(".$trads_id[$trad].")\">".$trad."</button></li>";
                    }
                  }
                } else {
                  echo "Aucune clé ne correspond à votre recherche.";
                }
              }
              ?>
            </ul>
          </div>
          <div class="value-box">
            <h3>Modifier la traduction</h3>
            <textarea id="new-trad" rows="30" cols="70"><?php
            if (isset($_GET["key"], $_GET["selection"])) {
              echo $trads_research[$_GET["selection"]];
            }
          ?></textarea>
            <?php
            $button_save_status;
            $button_delete_status;
            ?>
            <button class="button-success pure-button" onclick="updateTrad()"><?php echo traduction("trads_edit_save_button"); ?></button>
            <button class="button-error pure-button" disabled="" onclick="updateTrad()"><?php echo traduction("trads_edit_delete_button"); ?></button>
          </div>
        </div>
      </div>    
    </div>
    <?php include("../include/footer.php"); ?>
  </div>
  <script>
    function editTrad(key) {
      const url = new URL(window.location.href);
      url.searchParams.set('selection', key);
      localStorage.setItem("scrollPosition", window.scrollY);
      document.querySelectorAll('.key-item').forEach(item => {
        item.classList.remove('selected');
      });
      const selectedItem = document.querySelector(`.key-button-item[data-key="${key}"]`).parentElement;
      selectedItem.classList.add('selected');
      window.location.href = url.toString();
}

    function updateTrad() {
      trad = document.getElementById("new-trad").value;
      const urlParams = new URLSearchParams(window.location.search);
      id_trad = urlParams.get("selection");
      jQuery.ajax({
        type: "POST",
        url: "trads.php",
        data: {new_trad: trad, id_trad: id_trad},
        success: function(response) {
          const data = JSON.parse(response);
          if (data.success) {
            window.location.href = window.location.href;
          } 
        }
      });
    }
    
    window.onload = function () {
      const scrollPosition = localStorage.getItem("scrollPosition");
      if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition));
        localStorage.removeItem("scrollPosition");
      }
      const urlParams = new URLSearchParams(window.location.search);
      const selectionKey = urlParams.get("selection");
      if (selectionKey) {
        const selectedItem = document.querySelector(`.key-button-item[data-key="${selectionKey}"]`);
        if (selectedItem) {
          selectedItem.parentElement.classList.add('selected');
        }
      }
    }

  </script>
  <script src="../js/ui.js"></script>
</body>
</html>