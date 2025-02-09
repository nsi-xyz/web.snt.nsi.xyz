<div class="footer">
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
<?php if ((strpos(traduction("info_home"), "Missing Translation") === false) && (traduction("info_home") != "")) : ?>
  <script src="./js/script.js"></script>
  <script>
    throwInfo("<?php echo traduction("info_home"); ?>");
  </script>
<?php endif; ?>