<?php

class salidaInventarioForm extends sfForm {

    public function configure() {
        $listab = TiendaQuery::TiendaActivas();
        $bodegas = TiendaQuery::create()
                ->filterById($listab)
                ->filterByActivo(true)
                ->find();
        $opcion[null] = '[Seleccione Tienda]';
        foreach ($bodegas as $deta) {
            $opcion[$deta->getId()] = $deta->getNombre();
        }

        $this->setWidget('tienda', new sfWidgetFormChoice(array(
                    "choices" => $opcion,
                        ), array("class" => "form-control")));
        $this->setValidator('tienda', new sfValidatorString(array('required' => true)));

 $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
     
        $this->setWidget('documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Documento', 'maxlength'=>20 )));
        $this->setWidget('observaciones', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Observaciones',)));

        $this->setValidator('documento', new sfValidatorString(array('required' => false)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
