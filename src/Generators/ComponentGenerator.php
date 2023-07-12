<?php

namespace Drupal\generators\Generators;

use Drupal\Core\Extension\ModuleHandlerInterface;
use DrupalCodeGenerator\Command\ModuleGenerator;
use DrupalCodeGenerator\Command\ThemeGenerator;
use DrupalCodeGenerator\Utils;

class ComponentGenerator extends ThemeGenerator {

  protected string $name = 'custom:component';
  protected string $description = 'Generates component';
  protected string $alias = 'component';
  protected string $templatePath = 'modules/custom/generators/src/Templates/component';
  protected bool $isNewExtension = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function generate(&$vars): void
  {
    $this->collectDefault($vars);
    // $vars['theme_name'] = $this->ask('Theme machine name', 'MyTheme');
    $vars['theme_name'] = 'Blarg'; // temp
    $vars['component_name'] = Utils::human2machine($this->ask('Component name', 'MyComponent'));
    $vars['library'] = $this->confirm('Would you like to attach a custom library?');

    if ($vars['library']) {
      $this->addFile('{machine_name}.libraries.yml', 'custom.library.yml')
        ->appendIfExists();
    }
    $this->addDirectory('src/components/' . $vars['component_name']);
    $this->addFile('src/components/' . $vars['component_name'] . '/' . $vars['component_name'] . '.sass', 'componentSass');
    $this->addFile('src/components/' . $vars['component_name'] . '/' . $vars['component_name'] . '.twig', 'componentTwig');
    $this->addFile('templates/' . $vars['component_name'] . '.html.twig', 'componentTemplate');
  }
}

// Default the theme name to whatever is enabled and/or skip theme name question
// subdirectory option (choices api)
