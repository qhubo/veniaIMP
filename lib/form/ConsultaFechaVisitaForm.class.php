<?php

class ConsultaFechaVisitaForm extends sfForm {

    public function configure() {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));

        
        

        $listaMedio[null] = '[TODOS LOS TIPOS ]';
        $listaMedio['ACEITERA'] = 'ACEITERA';
        $listaMedio['CENTRO SERVICIOS'] = 'CENTRO SERVICIOS';
        $listaMedio['VENTA REPUESTOS'] = 'VENTA RESPUESTOS';
        $listaMedio['OTROS'] = 'OTROS';

        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $listaMedio,), array("class" => " form-control ")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));


        $listaRegi[null] = '[TODAS REGIONES ]';
        $REGISTOq = RegionQuery::create()
                ->orderByDetalle('Asc')
                ->find();
        foreach ($REGISTOq as $data) {
            $listaRegi[$data->getId()]=$data->getDetalle();
        }
        
        
        $this->setWidget('region', new sfWidgetFormChoice(array("choices" => $listaRegi,), array("class" => " form-control ")));
        $this->setValidator('region', new sfValidatorString(array('required' => false)));

        
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
