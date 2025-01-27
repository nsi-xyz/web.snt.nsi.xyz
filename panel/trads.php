<?php
include("./include/db.php");
include("../include/functions.php");
include("../include/checksession.php");

if (isset($_POST["new_trad"])) {
  //updateTrad($db, "fr", $_POST["key_trad"], $_POST["new_trad"]);
  $new = $_POST["new_trad"];
  $key = $_POST["key_trad"];
  echo $key;
  updateRow($db, "traductions_fr", array("value" => $new), "trad = \"$key\"");
  echo json_encode(["success" => false]);
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
        <form method="GET" action="" class="pure-form">
          <input type="text" name="key" placeholder="<?php echo traduction("trads_search_key_placeholder"); ?>" value="<?php echo isset($_GET["key"]) ? $_GET["key"] : ""; ?>" required>
          <button type="submit" class="pure-button"><?php echo traduction("trads_search_key_button"); ?></button>
        </form>
        <div class="trad-box">
          <div class="key-box">
            <ul class="key-list">
              <?php
              if (isset($_GET["key"])) {
                $trads = getRows($db, "traductions_".$_SESSION["locale"], "*", "trad", 1, "\"%".$_GET["key"]."%\"");
                $trads_research;
                $trads_id;
                foreach ($trads as $trad) {
                  $trads_research[$trad['trad']] = $trad['value'];
                  $trads_research[$trad['id']] = $trad['value'];
                  $trads_id[$trad['trad']] = $trad['id'];
                }
                foreach ($trads_research as $trad => $value) {
                  if (!is_int($trad)) {
                    echo "<li>".$trad."<button onclick=\"editTrad(".$trads_id[$trad].")\">".traduction("trads_edit_button")."</button></li>";
                  }
                }
              }
              ?>
            </ul>
          </div>
          <div class="value-box">
            <textarea id="new-trad" rows="30" cols="70"><?php
              if (isset($_GET["key"], $_GET["selection"])) {
                echo $trads_research[$_GET["selection"]];
              }
              ?></textarea>
            <button onclick="updateTrad('<?php echo $trads_research[$_GET['selection']]; ?>')"><?php echo traduction("trads_edit_save_button"); ?></button>
          </div>
          <?php 
          if (isset($_POST["new_trad"])) {
            echo $_POST["new_trad"];
          } else {
            echo "not set";
          }
          ?>
        </div>
      </div>
    </div>
    <?php include("../include/footer.php"); ?>
  </div>
  <script>
    function editTrad(key) {
      console.log(key);
      window.location.href += `&selection=${key}`;
    }

    function updateTrad() {
      trad = document.getElementById("new-trad").value;
      key = "<?php echo $trads_research[$_GET["selection"]]; ?>";
      jQuery.ajax({
        type: "POST",
        url: "trads.php",
        data: {new_trad: trad, key_trad: key},
        success: function(response) {
          const data = JSON.parse(response);
          if (data.success) {
            window.location.href = window.location.href;
          } 
        }
      });
    }
  </script>
  <script src="../js/ui.js"></script>
</body>
</html>