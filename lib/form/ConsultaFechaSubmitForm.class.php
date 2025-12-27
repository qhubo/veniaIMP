<?php

class ConsultaFechaSubmitForm extends sfForm
{

    public function configure()
    {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(
            array(),
            array('class' => 'form-control datepicker_bottom',   "onChange" => "this.form.submit()",  'data-date-format' => 'dd/mm/yyyy',)
        ));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array(
            'class' => 'form-control datepicker_bottom',   "onChange" => "this.form.submit()",
            'data-date-format' => 'dd/mm/yyyy', 'orientation' => 'bottom'
        )));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));

        $vendedo = VendedorQuery::create()
            ->filterByActivo(true)
            ->find();
        $listaVe[null] = '[Todos Vendedores]';
        foreach ($vendedo as $reg) {
            $listaVe[$reg->getNombre()] = $reg->getNombre();
        }

        $this->setWidget('vendedor', new sfWidgetFormChoice(array(
            "choices" => $listaVe,
        ), array("class" => " form-control",  "onChange" => "this.form.submit()",)));

        $this->setValidator('vendedor', new sfValidatorString(array('required' => false)));

        $opcionesta[null] = '[Todos los Medios]';
        $opcionesta['Cambio'] = 'CAMBIO';
        $opcionesta['CHEQUE'] = 'CHEQUE';
        $opcionesta['Del Dia'] = 'DEL DIA';
        $opcionesta['DEPOSITO'] = 'DEPOSITO';
        $opcionesta['Efectivo'] = 'EFECTIVO';
        $opcionesta['Vale'] = 'VALE';
        $this->setWidget('medio_pago', new sfWidgetFormChoice(array(
            "choices" => $opcionesta,
        ), array("class" => " form-control",  "onChange" => "this.form.submit()",)));

        $this->setValidator('medio_pago', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
}
