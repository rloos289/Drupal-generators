<?php declare(strict_types=1);

namespace Drupal\generators\Generators;

use DrupalCodeGenerator\Application;
use DrupalCodeGenerator\Utils;
use DrupalCodeGenerator\Command\ThemeGenerator;

/**
 * Implements theme command.
 *
 * @todo: Create a SUT test for this.
 * @todo: Clean-up.
 */
final class CustomThemeGenerator extends ThemeGenerator {

  protected string $name = 'custom:theme';
  protected string $alias = 'custom_theme';
  protected string $description = 'Generates Drupal theme';
  protected bool $isNewExtension = TRUE;
  protected string $templatePath = 'modules/custom/generators/src/Templates';

  /**
   * {@inheritdoc}
   */
  protected function generate(array &$vars): void {
    $this->collectDefault($vars);

    $vars['base_theme'] = 'stable9';
    $vars['description'] = $this->ask('Description', 'A flexible theme with a responsive, mobile-first layout.');
    $vars['lando_name'] = $this->ask('Name in .lando file');

    // Basic theme stuff
    $this->addFile('{machine_name}/{machine_name}.info.yml', 'theme/theme-info');
    $this->addFile('{machine_name}/{machine_name}.libraries.yml', 'theme/theme-libraries');
    $this->addDirectory('{machine_name}/assets');
    $this->addFile('{machine_name}/{machine_name}.theme', 'theme/theme');
    $this->addFile('{machine_name}/.nvmrc', 'theme/nvmrc');
    $this->addFile('{machine_name}/.env', 'theme/env');
    $this->addFile('{machine_name}/.prettierignore', 'theme/prettierignore');
    $this->addFile('{machine_name}/.prettierrc', 'theme/prettierrc');
    $this->addFile('{machine_name}/README.MD', 'theme/readme');
    $this->addFile('{machine_name}/package.json', 'theme/packagejson');
    $this->addFile('{machine_name}/webpack.mix.js', 'theme/webpackmix');

    // Includes Directory
    $this->addDirectory('{machine_name}/includes');
    $this->addFile('{machine_name}/includes/form.inc', 'includes/form');
    $this->addFile('{machine_name}/includes/node.inc', 'includes/node');
    $this->addFile('{machine_name}/includes/paragraph.inc', 'includes/paragraph');
    $this->addFile('{machine_name}/includes/views.inc', 'includes/views');

    // Src Directory
    $this->addDirectory('{machine_name}/src');

    // Js files
    $this->addDirectory('{machine_name}/src/js');
    $this->addFile('{machine_name}/src/js/{machine_name|u2h}.script.js')->content('');

    // SASS files
    $this->addDirectory('{machine_name}/src/sass');
    $this->addDirectory('{machine_name}/src/sass/base');
    $this->addDirectory('{machine_name}/src/sass/global');
    $this->addFile('{machine_name}/src/sass/global/_drupal.scss', 'src/_drupal');
    $style_sheets = [
      'base/_breakpoints',
      'base/_mixins',
      'base/_variables',
      'global/_animations',
      'global/_base-classes',
      'global/_base-elements',
      'global/_fonts',
      'global/_normalize',
    ];

    foreach ($style_sheets as $filename) {
      $this->addFile('{machine_name}/src/sass/' . $filename . '.scss')->content('');
    }

    // Templates Directory
    $this->addDirectory('{machine_name}/templates');
  }

}
