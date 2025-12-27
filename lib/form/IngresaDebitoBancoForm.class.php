<?php

class IngresaDebitoBancoForm extends sfForm {

    public function configure() {

        $vboedgas = BancoQuery::create()->filterByActivo(true)->orderByNombre()->find();
        $tipo[null] = '[Seleccione]';
        foreach ($vboedgas as $registro) {
            $tipo[$registro->getId()] = $registro->getNombre();
        }
        $this->setWidget('banco', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('banco', new sfValidatorString(array('required' =>true)));


        $mediopa = MedioPagoQuery::create()
                ->filterByAplicaMovBanco(true)->filterByActivo(true)->orderByNombre()->find();
        $tipoM[null] = '[Seleccione]';
        foreach ($mediopa as $registro) {
            $tipoM[$registro->getId()] = $registro->getNombre();
        }
        $this->setWidget('medio_pago', new sfWidgetFormChoice(array("choices" => $tipoM,), array("class" => "form-control")));
        $this->setValidator('medio_pago', new sfValidatorString(array('required' => true)));
        
        $listab = TiendaQuery::TiendaActivas();
        $tiendaQ = TiendaQuery::create()->filterByActivo(true)
                ->filterById($listab)
                ->orderByNombre()->find();
         $tipoT[null] = '[Seleccione]';
        foreach ($tiendaQ as $registro) {
            $tipoT[$registro->getId()] = $registro->getNombre();
        }
//        $this->setWidget('tienda_id', new sfWidgetFormChoice(array("choices" => $tipoT,), array("class" => "form-control")));
//        $this->setValidator('tienda_Id', new sfValidatorString(array('required' => false)));
//        
                $this->setWidget('fecha_movimiento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_movimiento', new sfValidatorString(array('required' => true)));

        
        
        
        $this->setWidget('referencia', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
            "placeholder" => "No Documento",)));
        $this->setValidator('referencia', new sfValidatorString(array('required' => true)));

        $this->setWidget('monto', new sfWidgetFormInputText(array(), array('class' => 'form-control',
       "placeholder"=>'0.00',    'type' => 'number', 'any' => 'step', 'step' => 'any')));
        $this->setValidator('monto', new sfValidatorString(array('required' => true)));

        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce', 'rows' => 2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));

        
            $this->setWidget(
        "archivo" , new sfWidgetFormInputFile(array(), array(
            "class" => "file-upload", 
           )));
       
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

 

}
