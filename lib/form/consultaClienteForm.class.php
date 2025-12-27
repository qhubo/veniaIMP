<?php

class consultaClienteForm extends sfForm {

    public function configure() {


        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle',
            "placeholder" => "buscar..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));


        $paisQ = PaisQuery::create()->filterByActivo(true)->find();
    $listaP[null]='[Seleccione]';
        foreach($paisQ as $reg) {
            $listaP[$reg->getId()]=$reg->getNombre(); 
        }
        
        $this->setWidget('pais', new sfWidgetFormChoice(array( "choices" => $listaP), array("class" => " form-control")));
        $this->setValidator('pais', new sfValidatorString(array('required' => false)));

        $lis[null]='[Seleccione]';
        
        
//        
//        $this->setWidget('departamento', new sfWidgetFormPropelChoice(
//                array('model' => 'Departamento',
//            'add_empty' => '[ Seleccione Departamento  ]',
//            'order_by' => array('Nombre', 'asc'),
//                ), array('class' => 'form-control',
//        )));
        $this->setWidget('departamento', new sfWidgetFormChoice(array( "choices" => $lis), array("class" => " form-control")));
        $this->setValidator('departamento', new sfValidatorString(array('required' => false)));


//        $this->setWidget('municipio', new sfWidgetFormPropelChoice(
//                array('model' => 'Municipio',
//            'add_empty' => '[ Seleccione Municipio ]',
//            'order_by' => array('Descripcion', 'asc'),
//                ), array('class' => 'form-control',
//        )));
        $this->setWidget('municipio', new sfWidgetFormChoice(array( "choices" => $lis), array("class" => " form-control")));
        $this->setValidator('municipio', new sfValidatorString(array('required' => false)));

        $lista[NULL]='TODOS';
        $lista['ACTIVO']='ACTIVOS';
        $lista['NOACTIVO']='NO ACTIVO';        
         $this->setWidget('estado', new sfWidgetFormChoice(array(
            "choices" => $lista,
                ), array("class" => " form-control")));

        $this->setValidator('estado', new sfValidatorString(array('required' => false)));

        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
