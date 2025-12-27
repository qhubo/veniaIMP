<?php

class consultaProductoPrecioForm extends sfForm {

    public function configure() {
$listab = TiendaQuery::TiendaActivas();
           $tiendaQuery = TiendaQuery::create()
                 ->filterById($listab, Criteria::IN)
                ->orderByNombre("Desc")
                ->filterByActivo(true)
                ->find();
            $lineaTienda=null;
        $lineaTienda[null] = '[Seleccione]';
        foreach ($tiendaQuery as $regis) {
            $lineaTienda[$regis->getId()] = $regis->getNombre();
        }
                $this->setWidget('tienda', new sfWidgetFormChoice(array(
            "choices" => $lineaTienda,
                ), array("class" => "form-control")));
        $this->setValidator('tienda', new sfValidatorString(array('required' => false)));
  

        $tipo[0] = 'No publicados';
        $tipo[1] = 'Publicado Web';
        $tipo[2] = 'Todos los Productos';
        $this->setWidget('estatus', new sfWidgetFormChoice(array(
            "choices" => $tipo,
                ), array("class" => "form-control")));
        $this->setValidator('estatus', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle',
"placeholder"=>"buscar..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));

              $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $proveedorQuery = TipoAparatoQuery::create()
                ->filterByEmpresaId($empresaId)
                ->orderByDescripcion("Asc")
                ->find();
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
                $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));
             $lineaProve=null;
              $proveedorQuery = MarcaQuery::create()
                ->filterByEmpresaId($empresaId)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
                $this->setWidget('marca', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));
        $this->setValidator('marca', new sfValidatorString(array('required' => false)));
  
        $this->setValidator('marca', new sfValidatorString(array('required' => false)));
            $lineaProve=null;
                $proveedorQuery = ModeloQuery::create()
                ->filterByEmpresaId($empresaId)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaProve[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaProve[$regis->getId()] = $regis->getDescripcion();
        }
                $this->setWidget('modelo', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));
        
        $this->setValidator('modelo', new sfValidatorString(array('required' => false)));
        
        
         $this->setWidget('porcentaje', new sfWidgetFormInputText(array(), array('class' => 'form-control ',
        )));
        $this->setValidator('porcentaje', new sfValidatorString(array('required' => false)));
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
