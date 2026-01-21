<?php if ($session->getCurrentUser()->hasPermission(Permission::GROUP_VIEWER)) : ?>
  <h2 class="content-subhead">Liste des rôles</h2>
  <table class="pure-table">
    <thead>
      <tr>
        <th>Nom du rôle</th>
        <th>Permissions</th>
        <th>Hiérarchie (debug)</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="users-list">
      <?php
      $groups = $groupRepository->getAll();
      $currentUser = $session->getCurrentUser();
      $groupCount = count($groups);
      $canChangeOrder = $currentUser->hasPermission(Permission::GROUP_EDIT);
      foreach ($groups as $index => $group) {
        $isFirst = $index === 1;
        $canMoveAbove = $canChangeOrder && !$group->isRoot() && !$currentUser->getGroup()->isLowerThan($group) && !$isFirst;
        $isLast = $index === ($groupCount - 1);
        $canMoveBelow = $canChangeOrder && !$group->isRoot() && !$currentUser->getGroup()->isLowerThan($group) && !$isLast;
        $interact_above_status = !$canMoveAbove ? 'disabled' : '';
        $interact_below_status = !$canMoveBelow ? 'disabled' : '';
        $interact_edit_status = !$currentUser->canEditGroup($group) ? 'disabled' : '';
        $interact_delete_status = !$currentUser->canDeleteGroup($group) ? 'disabled' : '';
        echo '<tr id="group-' . $group->getId() . '">';
        echo '<td id="group-name-' . $group->getId() . '">' . $group->getName() . '</td>';
        echo '<td id="user-permissions-' . $group->getId() . '">' . ($group->isRoot() ? 'ALL' : json_encode($group->getPermissions())).'</td>';
        echo '<td id="group-level-' . $group->getId() . '">' . $group->getHierarchyLevel() . '</td>';
        echo '<td><div class="actions">';
        echo '<button title="Move above" type="button" class="pure-button"' . $interact_above_status . ' onclick="up(' . $group->getId() . ')">↑</button>';
        echo '<button title="Move below" type="button" class="pure-button"' . $interact_below_status . ' onclick="down(' . $group->getId() . ')">↓</button>';
        echo '<button type="button" class="button-primary pure-button"' . $interact_edit_status . ' onclick="edit(' . $group->getId() . ')">Modifier</button>';
        echo '<button type="button" class="button-error pure-button"' . $interact_delete_status . ' onclick="del(' . $group->getId() . ')">Supprimer</button>';
        echo '</div></td>';
        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
<?php endif; ?>