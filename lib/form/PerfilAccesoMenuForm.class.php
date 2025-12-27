<?php
class PerfilAccesoMenuForm extends sfForm {
    public function configure() {
        
      $menus = MenuSeguridadQuery::create()->filterBySuperior(null, Criteria::NOT_EQUAL)
              ->orderByDescripcion()
              ->find();
      foreach($menus as $registro){
        $this->setWidget('menu_'.$registro->getId(), new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// ccheck
        $this->setValidator('menu_'.$registro->getId(), new sfValidatorString(array('required' => false)));
        
      }
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
}