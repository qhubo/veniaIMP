<?php

class CreaCapturaDatosForm extends sfForm {

    public function configure() {

        $this->setWidget('establecimiento', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'Nombre Establecimiento', 'max_length' => 150,)));
        $this->setValidator('establecimiento', new sfValidatorString(array('required' => true)));

        $listaMedio[null] = '[Seleccione]';
        $listaMedio['ACEITERA'] = 'ACEITERA';
        $listaMedio['CENTRO SERVICIOS'] = 'CENTRO SERVICIOS';
        $listaMedio['VENTA REPUESTOS'] = 'VENTA RESPUESTOS';
        $listaMedio['OTROS'] = 'OTROS';

        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $listaMedio,), array("class" => " form-control ")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));

//propietario
        $this->setWidget('propietario', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'Nombre Propietario', 'max_length' => 150,)));
        $this->setValidator('propietario', new sfValidatorString(array('required' => false)));

        $this->setWidget('contacto', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'Nombre Contacto', 'max_length' => 150,)));
        $this->setValidator('contacto', new sfValidatorString(array('required' => false)));

        $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => '00000000', 'max_length' => 8, 'min_length' => 8)));
        $this->setValidator('telefono', new sfValidatorString(array('required' => true)));

//email
        $this->setWidget('email', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => '@', 'type' => 'mail')));
        $this->setValidator('email', new sfValidatorString(array('required' => false)));

        $listaRegion[null] = '[Seleccione]';
        $regionq = RegionQuery::create()
                ->find();
        foreach ($regionq as $data) {
            $listaRegion[$data->getId()] = $data->getDetalle();
        }

        $this->setWidget('region', new sfWidgetFormChoice(array("choices" => $listaRegion,), array("class" => " form-control ")));
        $this->setValidator('region', new sfValidatorString(array('required' => false)));

        $regionID = sfContext::getInstance()->getUser()->getAttribute('regionID', null, 'seguridad');
        $listaDep[null] = '[Seleccione]';
        $viviendas = RegionDetalleQuery::create()
                ->useDepartamentoQuery()
                ->endUse()
                ->filterByRegionId($regionID)
                ->orderBy("Departamento.Nombre", "Asc")
                ->find();

        foreach ($viviendas as $valor) {
            $pre = substr($valor->getDepartamento()->getNombre(), 0, 1);
            $listaDep[$pre . $valor->getDepartamentoId()] = $valor->getDepartamento()->getNombre();
        }

        $departaId = sfContext::getInstance()->getUser()->getAttribute('DepID', null, 'seguridad');
        $listaMun[null] = '[Seleccione]';

        $departaId = substr($departaId, 1, 5);
        $departaId = trim($departaId);

        $Municipio = MunicipioQuery::create()
                ->filterByDepartamentoId($departaId)
                ->orderByDescripcion()
                ->find();

        $listado = array();

        foreach ($Municipio as $valor) {
            $pre = substr($valor->getDescripcion(), 0, 3);
            $listaMun[$pre . $valor->getId()] = $valor->getDescripcion();
        }



        $this->setWidget('departamento', new sfWidgetFormChoice(array("choices" => $listaDep,), array("class" => " form-control ")));
        $this->setValidator('departamento', new sfValidatorString(array('required' => false)));

        $this->setWidget('municipio', new sfWidgetFormChoice(array("choices" => $listaMun,), array("class" => " form-control ")));
        $this->setValidator('municipio', new sfValidatorString(array('required' => true)));

        $this->setWidget('direccion', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('direccion', new sfValidatorString(array('required' => false)));

        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => true)));

//nit
        $this->setWidget('nit', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'No Nit',)));
        $this->setValidator('nit', new sfValidatorString(array('required' => false)));

        $this->setWidget('WhtasApp', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => '00000000', 'max_length' => 8, 'min_length' => 8)));
        $this->setValidator('WhtasApp', new sfValidatorString(array('required' => false)));

        $this->setWidget('hollander', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'hollander', 'max_length' => 150,)));
        $this->setValidator('hollander', new sfValidatorString(array('required' => false)));

        $this->setWidget('repuesto', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'repuesto sugerido', 'max_length' => 150,)));
        $this->setValidator('repuesto', new sfValidatorString(array('required' => false)));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
