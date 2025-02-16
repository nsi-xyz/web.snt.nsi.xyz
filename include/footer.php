<div id="footer">
  <p class="footer-content"><?php echo traduction("footer_description_line_1"); ?></p>
  <p class="footer-content"><?php echo traduction("footer_description_line_2"); ?></p>
  <p class="footer-content"><?php echo traduction("footer_version"); ?> <?php echo VERSION; ?></p>
  <div class="pure-menu-horizontal">
    <ul>
      <li class="pure-menu-item"><a href="<?php echo traduction("external_nsixyz_link"); ?>" class="pure-menu-link-footer" target="_blank"><?php echo traduction("external_nsixyz_name"); ?></a></li>
      <li class="pure-menu-item"> </li>
      <li class="pure-menu-item"><a href="<?php echo traduction("external_purecss_link"); ?>" class="pure-menu-link-footer" target="_blank"><?php echo traduction("external_purecss_name"); ?></a></li>
      <li class="pure-menu-item"> </li>
      <li class="pure-menu-item"><a href="<?php echo traduction("external_contact_link"); ?>" class="pure-menu-link-footer" target="_blank"><?php echo traduction("external_contact_name"); ?></a></li>
    </ul>
  </div>
</div>
<?php if (isset($_SESSION["message"])) : ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      <?php
      switch ($_SESSION["message"][1]) {
        case "success":
          echo 'throwSuccess("'.$_SESSION["message"][0].'", "'.$_SESSION["message"][2].'");';
          unset($_SESSION["message"]);
          break;
        case "error":
          echo 'throwError("'.$_SESSION["message"][0].'", "'.$_SESSION["message"][2].'");';
          unset($_SESSION["message"]);
          break;
        case "info":
          echo 'throwInfo("'.$_SESSION["message"][0].'", "'.$_SESSION["message"][2].'");';
          unset($_SESSION["message"]);
          break;
      }
      ?>
  });
  </script>
<?php endif; ?>