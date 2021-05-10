<?php

namespace Drush\dmt_structure_export;

use Drush\dmt_structure_export\Exception\UnknownTableBuilderException;
use Drush\dmt_structure_export\TableBuilder\TableBuilderInterface;

/**
 * Class TableBuilderManager.
 */
class TableBuilderManager {

  /**
   * Contains the array of available table TableBuilder objects.
   *
   * @var \Drush\dmt_structure_export\TableBuilder\TableBuilderInterface[]
   */
  protected $tableBuilders = [];

  /**
   * Adds all default TableBuilder objects.
   */
  public function addDefaultTableBuilders() {
    $defaultTableBuilders = [
      'entity_bundles' => '\Drush\dmt_structure_export\TableBuilder\EntityBundlesTableBuilder',
      'entity_properties' => '\Drush\dmt_structure_export\TableBuilder\EntityPropertiesTableBuilder',
      'fields' => '\Drush\dmt_structure_export\TableBuilder\FieldsTableBuilder',
      'modules' => '\Drush\dmt_structure_export\TableBuilder\ModulesTableBuilder',
      'taxonomy_terms' => '\Drush\dmt_structure_export\TableBuilder\TaxonomyTermsTableBuilder',
      'menu_site_tree_items' => '\Drush\dmt_structure_export\TableBuilder\MenuSiteTreeItemsTableBuilder',
    ];
    foreach ($defaultTableBuilders as $id => $classname) {
      $tableBuilder = new $classname();
      $this->addTableBuilder($id, $tableBuilder);
    }
  }

  /**
   * Adds a TableBuilder.
   *
   * @param string $key
   *   The identifier of the TableBuilder to add.
   * @param \Drush\dmt_structure_export\TableBuilder\TableBuilderInterface $tableBuilder
   *   A TableBuilder instance to add.
   *
   * @return self
   *   This TableBuilderManager.
   */
  public function addTableBuilder($key, TableBuilderInterface $tableBuilder) {
    $this->tableBuilders[$key] = $tableBuilder;

    return $this;
  }

  /**
   * Returns the requested TableBuilder.
   *
   * @param string $id
   *   Identifier for requested TableBuilder.
   *
   * @return \Drush\dmt_structure_export\TableBuilder\TableBuilderInterface
   *   A TableBuilder instance.
   *
   * @throws \Drush\dmt_structure_export\Exception\UnknownTableBuilderException
   */
  public function getTableBuilder($id) {
    if (empty($this->tableBuilders)) {
      $this->addDefaultTableBuilders();
    }
    if (!$this->hasTableBuilder($id)) {
      throw new UnknownTableBuilderException($id);
    }

    return $this->tableBuilders[$id];
  }

  /**
   * Returns all defined TableBuilder instances.
   *
   * @return \Drush\dmt_structure_export\TableBuilder\TableBuilderInterface[]
   *   An associative array of TableBuilder id and instances.
   */
  public function getTableBuilders() {
    if (empty($this->tableBuilders)) {
      $this->addDefaultTableBuilders();
    }

    return $this->tableBuilders;
  }

  /**
   * Checks whether the given TableBuilder id exists or not.
   *
   * @param string $id
   *   The TableBuilder id.
   *
   * @return bool
   *   The response on whether the TableBuilder id exists or not.
   */
  public function hasTableBuilder($id) {
    return array_key_exists($id, $this->tableBuilders);
  }

}
