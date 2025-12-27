<?php

class EditaMarcaForm extends sfForm {

    public function configure() {
  
                $this->setWidget("archivo" , new sfWidgetFormInputFile(array(), array()));
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        $this->setWidget('limpia', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('limpia', new sfValidatorString(array('required' => false)));
        

           $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
      
            $proveedorQuery = TipoAparatoQuery::create()
                   
                    ->filterByDescripcion(array('Receta','Combo'), Criteria::NOT_IN)
                    ->orderByDescripcion("Desc")
                    ->find();
            $lineaProve[null]='[Seleccione Grupo]';
        foreach ($proveedorQuery as $regis) {
            
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }

        $this->setWidget('tipo_aparato_id', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));

        $this->setValidator('tipo_aparato_id', new sfValidatorString(array('required' => true)));


        $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => "Ingrese nombre ",
        )));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => true)));

        
           $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
     
           $this->setWidget('receta', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('receta', new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
