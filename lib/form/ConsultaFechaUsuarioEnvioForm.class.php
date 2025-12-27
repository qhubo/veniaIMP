<?php

class ConsultaFechaUsuarioEnvioForm extends sfForm {

    public function configure() {
//        $criteriaDos = new Criteria();
//        $criteriaDos->add(PublicidadPeer::NOMBRE, 'xx-xx');
        
        
         $operaciones = OperacionQuery::create() 
                 ->where("Operacion.TipoPago <> ''")
                ->groupByTipoPago()
                ->find();
        $opciones[''] = '[Todos los pagos]';
        foreach($operaciones as $li){
            $opciones[$li->getTipoPago()]=$li->getTipoPago();
        }        
        $this->setWidget('estado', new sfWidgetFormChoice(array(
            "choices" => $opciones,
                ), array("class" => " form-control")));        
        $this->setValidator('estado', new sfValidatorString(array('required' => false)));
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        $this->setWidget('usuario', new sfWidgetFormPropelChoice(array('model' => 'Usuario',
            'add_empty' => '[Todos los Usuarios]',
            // , 'method' => 'getUsuario',
            //, 'criteria' => $criteriaDos,
            'order_by' => array('Usuario', 'desc'),
                ), array('class' => 'form-control #actualizar_combo',
                )
        ));
        
        
        $this->setValidator('usuario', new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
