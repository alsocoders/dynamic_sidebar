<?php

function getMenu($parent = null)
{
  global $conn;
  $menus = [];
  $sql = "SELECT * FROM menus WHERE ";
  $sql .= $parent === null ? "parent IS NULL" : "parent = $parent";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $row['menus'] = getMenu($row['id']);
    $row['subMenus'] = getSubMenus($row['id']);
    $menus[] = $row;
  }
  return $menus;
}

function getSubMenus($parent)
{
  global $conn;
  $subMenus = [];
  $sql = "SELECT * FROM subMenus WHERE parent = $parent";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_assoc($result)) {
    $subMenus[] = $row;
  }
  return $subMenus;
}

function renderMenu($menus)
{
  echo "<ul>";
  foreach ($menus as $menu) {
    echo "<li>{$menu['name']}";
    if (!empty($menu['menus'])) {
      renderMenu($menu['menus']);
    }
    if (!empty($menu['subMenus'])) {
      echo "<ul>";
      foreach ($menu['subMenus'] as $subMenu) {
        echo "<li>{$subMenu['name']}</li>";
      }
      echo "</ul>";
    }
    echo "</li>";
  }
  echo "</ul>";
}