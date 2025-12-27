<?php

class ConsultaEncuestaForm extends sfForm {

    public function configure() {
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        $bodegas = EncuestaQuery::create()->orderByTitulo('Asc')->find();
        $opcionE[null] = '[Todas las Encuestas]';
        foreach ($bodegas as $deta) {
            $opcionE[$deta->getId()] = $deta->getTitulo();
        }

        $this->setWidget('encuesta', new sfWidgetFormChoice(array("choices" => $opcionE,), array("class" => " form-control")));
        $this->setValidator('encuesta', new sfValidatorString(array('required' => false)));
 $corpoID= sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'corporacion');
        
        

        $opcionb[null] = '[Todas las Empresas]';
         $bodegas = EmpresaQuery::create()
                 ->useCorporacionMenuQuery()
                 ->filterByCorporacionId($corpoID)
                 ->endUse()
                 ->orderByNombre('Asc')->find();
        foreach ($bodegas as $deta) {
           $opcionb[$deta->getId()] = $deta->getNombre();
        }

        $this->setWidget('empresa', new sfWidgetFormChoice(array("choices" => $opcionb,), array("class" => " form-control")));
        $this->setValidator('empresa', new sfValidatorString(array('required' => false)));


        $opcionT = null;
        $opcionT[null] = '[Todos los Tipos]';
        $opcionT[1] = 'MUY MALO';
        $opcionT[2] = 'MALO';
        $opcionT[3] = 'BUENO';
        $opcionT[4] = 'MUY BUENO';
        $opcionT[5] = 'EXCELENTE';
  
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $opcionT,), array("class" => " form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control ',
            "placeholder" => "buscar cliente..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));




        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
