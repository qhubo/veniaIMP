<?php
class CreaComboForm extends sfForm {
    public function configure() {
                     $this->setWidget(
        "archivo" , new sfWidgetFormInputFile(array(), array(
      //      "class" => "file-upload", 
           )));       
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        
              $this->setWidget('codigo_sku', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                   "placeholder" => "* Código Automatico ",
        )));
        $this->setValidator('codigo_sku', new sfValidatorString(array('required' => false)));
                $this->setWidget('codigo_barras', new sfWidgetFormInputText(array(), array('class' => 'form-control',
      
        )));
        $this->setValidator('codigo_barras', new sfValidatorString(array('required' => false)));
         
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control',        )));
        $this->setValidator('nombre', new sfValidatorString(array('required' => false)));
        
                $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
       $this->setValidator('descripcion', new sfValidatorString(array('required' => false)));

        
        
        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        
        $this->setWidget('vence', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('vence', new sfValidatorString(array('required' => false)));
       
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => false)));

        
        
                
        $this->setWidget('precio_variable', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('precio_variable', new sfValidatorString(array('required' => false)));

        $this->setWidget('precio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'step'=>'any', 'type'=>'number'       )));
        $this->setValidator('precio', new sfValidatorString(array('required' => false)));

        $this->setWidget('afecto_inventario', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('afecto_inventario', new sfValidatorString(array('required' => false)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
        
    }
}