<?php

class ConsultaReporteBancoForm extends sfForm {

    public function configure() {
        $bancoq = BancoQuery::create()
                ->orderByNombre("Desc")
                ->find();
        $opcionBan[null]='[ Todos los Bancos ]';
        foreach ($bancoq as $reg) {
            $opcionBan[$reg->getId()] = $reg->getNombre();
        }

        $this->setWidget('banco', new sfWidgetFormChoice(array(
                    "choices" => $opcionBan,
                        ), array("class" => " form-control")));

        $this->setValidator('banco', new sfValidatorString(array('required' => false)));

        $opcionesP[null] = '[Todos los tipos]';
        $opcionesP['Ventas'] = 'Ventas';
        $opcionesP['NoVentas']='No Ventas';  // tipo_movimiento
        $opcionesP['Cheque'] = 'Cheques';
        $opcionesP['Credito']='Credito';
        $opcionesP['Debito'] = 'Debito';
        $opcionesP['Transferencia']='Transferencia';  // tipo_movimiento
        
        
        
        $this->setWidget('tipo', new sfWidgetFormChoice(array(
                    "choices" => $opcionesP,
                        ), array("class" => " form-control")));

        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

   
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));

 
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
