# Data Migrate Tool - Structure Export

This project contains Drush command(s) to export a Drupal 7 or Drupal 8 website structure to CSV files.
Those CSV files can then be used to build mappings for a website migration.

The `dmt-se:export` command can be used to generate a single export.

The `dmt-se:export-all` command will run all exports and generate CSV files:
- `entity_bundles.csv`: All entity types and bundles (+ several settings)
- `entity_properties.csv`: All entity properties for each entity type and bundle
- `fields.csv`: All field bases
- `modules.csv`: The list of modules
- `taxonomy_terms.csv`: All taxonomy terms (with language_none/und or EN)

# Requirements

* PHP 5.6 or higher
* Drush 8.1.18 or higher is required:
  *  this tool uses [Consolidation\AnnotatedCommand](https://github.com/consolidation/annotated-command) and [Consolidation\OutputFormatters](https://github.com/consolidation/output-formatters) 

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

Finally: `composer require ioannis-ampatzis/dmt_structure_export:7.x-1.x-dev`

Sample of final main composer.json file, for a D7 NextEuropa website:

    {
        "name": "[WEBSITE_NAME]",
        "description": "[WEBSITE_DESCRIPTION]",
        "type": "project",
        "keywords": ["fpfis", "nexteuropa", "subsite"],
        "homepage": "[WEBSITE_URL]",
        "require": {
            "ec-europa/toolkit": "3.*",
            "ioannis-ampatzis/dmt_structure_export": "7.x-1.x-dev"
        },
        "support": {
            "email": "[WEBSITE_EMAIL]",
            "source": "https://github.com/ec-europa/[WEBSITE_REPOSITORY]"
        },
        "scripts": {
            "post-install-cmd": "@toolkit-install",
            "post-update-cmd": "@toolkit-install",
            "toolkit-install": "PROJECT=$(pwd) composer run-script toolkit-install -d ./vendor/ec-europa/toolkit"
        },
        "require": {
            "ioannis-ampatzis/dmt_structure_export": "dev-7.x-1.x"
        },
        "repositories": {
            "dmt_migrate":{
                "type": "vcs",
                "url": "https://github.com/ioannis-ampatzis/dmt_structure_export"
            }
        },
        "extra": {
            "installer-paths": {
                "drush/Commands/{$name}": ["type:drupal-drush"]
            }
        }
    }
