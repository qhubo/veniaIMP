<?php

class CreaOrdenProveedorForm extends sfForm {

    public function configure() {


        
           $this->setWidget('proveedor', new sfWidgetFormInputText(array(), array('class' => 'form-control')));
        $this->setValidator('proveedor', new sfValidatorString(array('required' => true)));
        
        
        $this->setWidget('serie', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 10,
            "placeholder" => "serie",)));
        $this->setValidator('serie', new sfValidatorString(array('required' => false)));

        $this->setWidget('no_documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "No Documento",)));
        $this->setValidator('no_documento', new sfValidatorString(array('required' => false)));

          $this->setWidget('exento_isr', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox' ,"onChange"=>"this.form.submit()")));
        $this->setValidator('exento_isr', new sfValidatorString(array('required' => false)));
       
        $this->setWidget('fecha_documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_documento', new sfValidatorString(array('required' => true)));
        $this->setWidget('fecha_contabilizacion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_contabilizacion', new sfValidatorString(array('required' => false)));

        $this->setWidget('dia_credito', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
         
            'type' => 'number',)));
        $this->setValidator('dia_credito', new sfValidatorString(array('required' => true)));

        $this->setWidget('nit', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "Nit",)));
        $this->setValidator('nit', new sfValidatorString(array('required' => false)));


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => false)));
        
        
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce','rows'=>2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
        $this->setWidget('exenta', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox',
            )));
        $this->setValidator('exenta', new sfValidatorString(array('required' => false)));
$listab = TiendaQuery::TiendaActivas();
        $vboedgas= TiendaQuery::create()
                ->filterById($listab)
                ->filterByActivo(true)
                ->orderByNombre()
                ->find();
        
        $tipo[null]='[Seleccione]';
        foreach ($vboedgas  as $registro) {
        $tipo[$registro->getId()]=$registro->getNombre();
            
        }
        
        $this->setWidget('tienda_id', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tienda_id', new sfValidatorString(array('required' => false)));
        
        
        $this->setWidget('aplica_isr', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox',
            "onChange"=>"this.form.submit()"
            )));
        $this->setValidator('aplica_isr', new sfValidatorString(array('required' => false)));
        $this->setWidget('aplica_iva', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox',
            "onChange"=>"this.form.submit()")));
        $this->setValidator('aplica_iva', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
