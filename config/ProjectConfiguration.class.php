<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->setWebDir($this->getRootDir().'/public_html');
    // $this->enablePlugins('sfPropelPlugin');
    $this->enablePlugins('sfFormExtraPlugin');
    $this->enablePlugins('sfJQueryUIPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('sfTCPDFPlugin');
    //setup the location for our phing and propel libs
    sfConfig::set('sf_phing_path', sfConfig::get('sf_root_dir').'/plugins/sfPropelORMPlugin/lib/vendor/phing/');
    sfConfig::set('sf_propel_path', sfConfig::get('sf_root_dir').'/plugins/sfPropelORMPlugin/lib/vendor/propel/');
    sfConfig::set('sf_propel_generator_path', sfConfig::get('sf_root_dir').'/plugins/sfPropelORMPlugin/lib/vendor/propel/generator/lib/');
    $this->enablePlugins('sfPropelORMPlugin');
  }
}
