<?php

class grabaVentaForm extends sfForm {

    public function configure() {
        $pideBanco = sfContext::getInstance()->getUser()->getAttribute("pideBanco", null, 'seguridad');
        $listab = TiendaQuery::TiendaActivas();
        $bodegas = TiendaQuery::create()
                ->filterById($listab)
                ->filterByActivo(true)
                ->find();
        $opcion[null] = '[Seleccione Tienda]';
        foreach ($bodegas as $deta) {
            $opcion[$deta->getId()] = $deta->getNombre();
        }

        $this->setWidget('tienda', new sfWidgetFormChoice(array("choices" => $opcion,), array("class" => " form-control")));
        $this->setValidator('tienda', new sfValidatorString(array('required' => true)));

        $this->setWidget('documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Documento',)));
        $this->setWidget('observaciones', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Observaciones',)));

        $this->setValidator('documento', new sfValidatorString(array('required' => false)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
        
        
        $opcionB[null]='[ Seleccione Banco ]';
        $bancos= BancoQuery::create()
                ->filterByActivo(true)
                ->orderByNombre("Desc")
                ->find();
          foreach ($bancos as $deta) {
            $opcionB[$deta->getId()] = $deta->getNombre();
        }

        
        $this->setWidget('banco', new sfWidgetFormChoice(array("choices" => $opcionB,), array("class" => " form-control")));
        $this->setValidator('banco', new sfValidatorString(array('required' => $pideBanco)));

        
        $this->setWidget('cuota0', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 0,
                    'onkeypress' => 'validate(event)',
                    'xtype' => 'number', 'step' => 'any')));
        $this->setValidator('cuota0', new sfValidatorString(array('required' => false)));
        for ($i = 1; $i <= 36; $i++) {
            $this->setWidget('cuota' . $i, new sfWidgetFormInputText(array(), array('placeholder' => 0,
                        'class' => 'form-control',
                        'onkeypress' => 'validate(event)',
                        'xtype' => 'number', 'step' => 'any')));
            $this->setValidator('cuota' . $i, new sfValidatorString(array('required' => false)));
        }

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
