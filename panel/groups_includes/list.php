<?php if ($session->getCurrentUser()->hasPermission(Permission::GROUP_VIEWER)) : ?>
  <h2 class="content-subhead">Liste des rôles</h2>
  <table class="pure-table">
    <thead>
      <tr>
        <th>Nom du rôle</th>
        <th>Permissions</th>
        <th>Hiérarchie</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="users-list">
      <?php
      $groups = $groupRepository->getAll();
      foreach ($groups as $group) {
        $interact_moreinfos_status = '';
        $interact_edit_status = !$session->getCurrentUser()->hasPermission(Permission::GROUP_EDIT) ? 'disabled' : '';
        $interact_delete_status = !$session->getCurrentUser()->hasPermission(Permission::GROUP_DELETE) ? 'disabled' : '';
        echo '<tr id="group-'.$group->getId().'">';
        echo '<td id="group-name-'.$group->getId().'">'.$group->getName().'</td>';
        echo '<td id="user-permissions-'.$group->getId().'">'.($group->isRoot() ? 'ALL' : json_encode($group->getPermissions())).'</td>';
        echo '<td id="group-level-'.$group->getId().'">'.$group->getHierarchyLevel().'</td>';
        echo '<td><div class="actions">';
        echo '<button title="Insert above" type="button" class="pure-button" onclick="">↑</button>';
        echo '<button title="Insert below" type="button" class="pure-button" onclick="">↓</button>';
        echo '<button type="button" class="button-more-infos pure-button"'.$interact_moreinfos_status.' onclick="">En savoir plus</button>';
        echo '<button type="button" class="button-primary pure-button"'.$interact_edit_status.' onclick="">Modifier</button>';
        echo '<button type="button" class="button-error pure-button"'.$interact_delete_status.' onclick="">Supprimer</button>';
        echo '</div></td>';
        echo '</tr>';
      }
      ?>
    </tbody>
  </table>
<?php endif; ?>