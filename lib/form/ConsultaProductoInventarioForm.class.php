<?php

class consultaProductoInventarioForm extends sfForm {

    public function configure() {
        
        
        $tipoP['']='Todas las Proveedores';
      $query="select  pp.id, pp.nombre from proveedor pp inner join producto p on p.proveedor_id=pp.id  order by pp.nombre";
        $con = Propel::getConnection();
        $stmt = $con->prepare($query);
        $resource = $stmt->execute();
        $proveedorDe = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($proveedorDe as $result){
            $tipoP[$result['id']]=$result['nombre'];
        }
        
        
         $this->setWidget('proveedor', new sfWidgetFormChoice(array(
            "choices" => $tipoP,
                ), array("class" => "form-control mi-selector ")));
        $this->setValidator('proveedor', new sfValidatorString(array('required' => false)));
        
            $tipoId = sfContext::getInstance()->getUser()->getAttribute('tipo_id', null, 'seguridad');
        $marcaId = sfContext::getInstance()->getUser()->getAttribute('marca_id', null, 'seguridad');

    $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
    $listab = TiendaQuery::TiendaActivas();
        $bodegaQuery = TiendaQuery::create()
                ->filterByEmpresaId($empresaId)
                ->filterById($listab, Criteria::IN)
                ->orderByNombre()
                ->find();
        $tipo['']='Todas las bodegas';
        foreach($bodegaQuery as $List){
            $tipo[$List->getId()]=$List->getNombre();
        }
                $criteriaMarca = new Criteria();
        $criteriaMarca->add(MarcaPeer::TIPO_APARATO_ID, $tipoId);


        $criteria = new Criteria();
        $criteria->add(ModeloPeer::MARCA_ID, $marcaId);

        $this->setWidget('bodega', new sfWidgetFormChoice(array(
            "choices" => $tipo,
                ), array("class" => "form-control")));
        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control input-circle',
"placeholder"=>"buscar..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));

            $filtro[] = 'COMBO';
        $filtro[] = 'RECETA';
        $proveedorQuery = TipoAparatoQuery::create()
                                ->filterByEmpresaId($empresaId)
                ->filterByDescripcion($filtro, Criteria::NOT_IN)
                ->orderByDescripcion("Desc")
                ->find();
        $lineaTipo[null] = '[Seleccione]';
        foreach ($proveedorQuery as $regis) {
            $lineaTipo[$regis->getId()] = $regis->getDescripcion();
        }
                $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $lineaTipo,
                ), array("class" => "form-control")));
                $this->setWidget('marca', new sfWidgetFormPropelChoice(
                array('model' => 'Marca',
                       'criteria' => $criteriaMarca,
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::marca() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
                
                  $this->setWidget('modelo', new sfWidgetFormPropelChoice(
                array('model' => 'Modelo',
                      'criteria' => $criteria,
            'add_empty' => '[ Seleccione ' . TipoAparatoQuery::modelo() . ' ]',
            'order_by' => array('Descripcion', 'asc'),
                ), array('class' => 'form-control',
        )));
                  
                  
        
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

        $this->setValidator('marca', new sfValidatorString(array('required' => false)));

        $this->setValidator('modelo', new sfValidatorString(array('required' => false)));
    
        $line[null]='Todos';
        $line['existencia']='PRODUCTOS CON EXISTENCIA';
       // $line['transito']='EXCLUIR PRODUCTOS TRANSITO';
        
        
        $this->setWidget('tipo_filtro', new sfWidgetFormChoice(array( "choices" => $line,), array("class" => "form-control")));
        $this->setValidator('tipo_filtro', new sfValidatorString(array('required' => false)));
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
