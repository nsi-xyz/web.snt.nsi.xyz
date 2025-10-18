<?php if ($session->getCurrentUser()->hasPermission(Permission::GROUP_CREATE)) : ?>
  <h2 class="content-subhead">Éditeur de rôle</h2>
  <form method="POST" action="" class="pure-form pure-form-stacked">
    <h3 class="content-subhead"><?= $translator->getMessage('groups_creator_h3') ?></h3>
    <div class="form-group">
      <label for="group_name">Nom du rôle</label>
      <input type="text" id="name" name="group_name" placeholder="Nom du rôle" required pattern="<?php echo HTMLPATTERN_GROUP; ?>" minlength="<?php echo GROUP_MIN_LENGTH; ?>" maxlength="<?php echo GROUP_MAX_LENGTH; ?>" />
    </div>
    <div class="form-group">
      <details>
        <summary><strong>Permissions</strong></summary>
        <?php
        $groupedPermissions = [];
        foreach (Permission::getAllWithDetails() as $key => $value) {
          $category = explode('.', $key)[0];
          $groupedPermissions[$category][$key] = $value;
        }
        foreach ($groupedPermissions as $category => $permissions) : ?>
        <details>
          <summary><?= ucfirst($category) ?></summary>
          <?php foreach ($permissions as $key => $value) : ?>
            <?php
            $disabled = !$session->getCurrentUser()->hasPermission($key) ? 'disabled' : '';
            $risk = match($value['level']) { 0 => 'Faible', 1 => 'Moyen', 2 => 'Élevé', 3 => 'Critique', default => '?' };
            ?>
            <label title="Risque : <?= $risk ?>" for="perm-<?= htmlspecialchars($key) ?>" style="display: block; margin-left: 20px;">
              <input <?= $disabled ?> type="checkbox" name="permissions[]" id="perm-<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($key) ?>" />
              <?= htmlspecialchars($value['description']) ?> (<?= htmlspecialchars($key) ?>)
            </label>
          <?php endforeach; ?>
        </details>
        <?php endforeach; ?>
      </details>
    </div>
    <button class ="button-success pure-button" name="create" type="submit">Créer</button>
  </form>
<?php endif; ?>