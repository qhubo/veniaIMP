<?php

class ConsultaFechaProveedorForm extends sfForm {

    public function configure() {

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));

        $proveeedores = ProveedorQuery::create()
                ->filterByActivo(true)
                ->orderByNombre("Desc")
                ->find();
        $opcionb[null]='[Seleccione Proveedor]';
        foreach ($proveeedores as $registr) {
            $opcionb[$registr->getId()]=$registr->getNombre();
        }
        
        $this->setWidget('proveedor', new sfWidgetFormChoice(array(
                    "choices" => $opcionb,
                        ), array("class" => "mi-selector  form-control")));

        $this->setValidator('proveedor', new sfValidatorString(array('required' => true)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
