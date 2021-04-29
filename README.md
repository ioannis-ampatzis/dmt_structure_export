# Data Migrate Tool - Structure Export

This project contains Drush command(s) to export a Drupal 7 or Drupal 8 website structure to CSV files.
Those CSV files can then be used to build mappings for a website migration.

The `dmt-se:export` command can be used to generate a single export.

The `dmt-se:export-all` command will run all exports and generate CSV files:
- `entity_bundles.csv`: All entity types and bundles (+ several settings)
- `entity_properties.csv`: All entity properties for each entity type and bundle
- `fields.csv`: All field bases
- `modules.csv`: The list of modules

# Requirements

* PHP 7.1 or higher
* Drush 8.2 / 9.0 or higher

# Installation

This Drush tool has to be installed per Drupal instance.

If the installers are not present in composer.json: `composer require composer/installers`

Add the following, if not present in the composer.json's "extra" section:

    "installer-paths": {
        "drush/Commands/{$name}": ["type:drupal-drush"]
    }
    
Add the following in the composer.json's "repositories" section:

    "repositories": {
        "dmt_migrate":{
            "type": "vcs",
            "url": "https://github.com/ioannis-ampatzis/dmt_structure_export"
        }
    }

Finally: `composer require ioannis-ampatzis/dmt_structure_export:8.x-1.x-Light-dev`
