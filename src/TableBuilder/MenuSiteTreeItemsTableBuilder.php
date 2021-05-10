<?php

namespace Drush\dmt_structure_export\TableBuilder;

/**
 * MenuSiteTreeItemsTableBuilder class.
 */
class MenuSiteTreeItemsTableBuilder extends TableBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'reason' => dt('Reason'),
      'menu_name' => dt('Menu name'),
      'mlid' => dt('Menu item ID'),
      'plid' => dt('Parent menu item ID'),
      'link_path' => dt('Link path'),
      'router_path' => dt('Router path'),
      'link_title' => dt('Link title'),
    ];

    $this->setHeader($header);
  }

  /**
   * {@inheritdoc}
   */
  public function buildRows() {
    $sql = <<<SQL

-- All absolute URLs, aliases
SELECT
  'Absolute URL, Alias' as reason,
  menu_name,
  mlid,
  plid,
  link_path,
  router_path, link_title
FROM {menu_links}
WHERE router_path != 'node/%'
AND menu_name NOT IN ('menu-service-tools', 'management', 'navigation', 'user-menu')

UNION

-- Duplicated menu items
SELECT
  'Duplicated' as reason,
  menu_name,
  mlid,
  plid,
  link_path,
  router_path,
  link_title
FROM {menu_links} ml2
WHERE ml2.router_path = 'node/%'
AND ml2.menu_name NOT IN ('menu-service-tools', 'management', 'navigation', 'user-menu')
AND ml2.mlid IN (
  SELECT mlid FROM {menu_links}
  GROUP BY link_path
  HAVING count(link_path) > 1
)

UNION

-- Parent and child at the same time
SELECT
  'Parent - Child' as reason,
  ml1.menu_name,
  ml1.mlid,
  ml1.plid,
  ml1.link_path,
  ml1.router_path,
  ml1.link_title
FROM {menu_links} as ml1
WHERE ml1.link_path = (SELECT ml2.link_path FROM {menu_links} as ml2 WHERE ml2.mlid = ml1.plid)
AND ml1.menu_name NOT IN ('menu-service-tools', 'management', 'navigation', 'user-menu')
SQL;

    $rows = db_query($sql)->fetchAllAssoc('mlid', \PDO::FETCH_ASSOC);

    $this->setRows($rows);
  }

}
