<?php

class ConsultaFechaDevoluciForm extends sfForm {

    public function configure() {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));

        $tipoUsua = sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad');
        $usuarioa = sfContext::getInstance()->getUser()->getAttribute("usuarioNombre", null, 'seguridad');
        if ((strtoupper($tipoUsua) == 'ADMINISTRADOR') or (strtoupper($usuarioa) == 'LMARTINEZ')) {
            $usuarioQ = UsuarioQuery::create()
                    //  ->filterByActivo(true)
                    ->find();
            $ListaU[] = 'Todos los usuarios';
            foreach ($usuarioQ as $data) {
                $ListaU[$data->getUsuario()] = $data->getUsuario();
            }
        }
        $ListaU[$usuarioa] = $usuarioa;

        $this->setWidget('usuario', new sfWidgetFormChoice(array("choices" => $ListaU,  ), array("class" => " form-control")));

        $this->setValidator('usuario', new sfValidatorString(array('required' => false)));

        $estatusd[null] = "Todos los estatus";
        $estatusd['Autorizado'] = "Autorizado";
        $estatusd['Rechazado'] = "Rechazado";
        $estatusd['Nuevo'] = "Nuevo";
        $estatusd['ANULADO'] = 'Anulado';
        $this->setWidget('estatus_devolucion', new sfWidgetFormChoice(array(
                    "choices" => $estatusd,
                        ), array("class" => " form-control")));

        $this->setValidator('estatus_devolucion', new sfValidatorString(array('required' => false)));

        $estatusdv[null] = "Todos";
        $estatusdv['Nuevo'] = "Nuevo";
        $estatusdv['Usado'] = "Usado";
        $this->setWidget('tipo_repuesto', new sfWidgetFormChoice(array("choices" => $estatusdv,), array("class" => " form-control")));
        $this->setValidator('tipo_repuesto', new sfValidatorString(array('required' => false)));

        $catalogoM= MotivoMovimientoProductoQuery::create()
                ->orderByNombre()
                ->find();
        $motivo[null]="Todos";
        foreach ($catalogoM as $regi) {
            $motivo[$regi->getNombre()]=$regi->getNombre();
        }
        
         $this->setWidget('motivo', new sfWidgetFormChoice(array("choices" => $motivo,), array("class" => " form-control")));
        $this->setValidator('motivo', new sfValidatorString(array('required' => false)));
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
