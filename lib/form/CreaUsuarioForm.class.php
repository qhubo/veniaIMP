<?php

class CreaUsuarioForm extends sfForm {

    public function configure() {
        $this->setWidget('usuario', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 50,)));
        $this->setValidator('usuario', new sfValidatorString(array('required' => true)));

        $this->setWidget('nombre_completo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'max_length' => 50, "placeholder" => "Nombre Completo",
        )));
        $this->setValidator('nombre_completo', new sfValidatorString(array('required' => true)));

        $tipo['Administrador'] = 'Administrador';
        $tipoUsu = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario'));
        if ($tipoUsu == 'SUPERADMINISTRADOR') {
            $tipo['SUPERADMINISTRADOR'] = 'Super Administrador';
        }
        $perfiles = PerfilQuery::create()->find();
        foreach ($perfiles as $acceso) {
            $tipo[$acceso->getId()] = $acceso->getDescripcion();
        }



        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));
        $this->setWidget('clave', new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
        $this->setValidator('clave', new sfValidatorString(array('required' => false)));

        $this->setWidget('correo', new sfWidgetFormInputText(array(), array('class' => 'form-control', "type" => "email",)));
        $this->setValidator('correo', new sfValidatorString(array('required' => false)));

        $tipoN['Administrador'] = 'Administrador';
        $tipoN['Supervisor'] = 'Supervisor';
        $tipoN['Usuario'] = 'Usuario';
        $this->setWidget('nivel', new sfWidgetFormChoice(array("choices" => $tipoN,), array("class" => "form-control")));
        $this->setValidator('nivel', new sfValidatorString(array('required' => false)));


        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        $empresaID = sfContext::getInstance()->getUser()->getAttribute('empresa', null, 'sele');
     
        $opcionb = null;
        $opcionb[null] = '[Seleccione Tienda]';
        $empresId = 0;
        if (sfContext::getInstance()->getUser()->getAttribute('empresa', null, 'sele')) {
            $empresId = sfContext::getInstance()->getUser()->getAttribute('empresa', null, 'sele');
        }
//     
$listab = TiendaQuery::TiendaActivas();
           $bodegas = TiendaQuery::create()
                   ->filterById($listab)
                   ->filterByEmpresaId($empresId)->orderByNombre()->find();
        $opcionb = null;
        $opcionb[null] = '[Seleccione Empresa]';
        foreach ($bodegas as $litabo) {
            $opcionb[$litabo->getId()] = $litabo->getNombre();
        }
        $this->setWidget('bodega', new sfWidgetFormChoice(array("choices" => $opcionb,
                ), array("class" => " form-control")));
        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));
        
        
        
        $sqlexp = 'select id,nombre from tienda where empresa_id= ' . $empresId;
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $rResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rResult as $reg) {
            $nombre = $reg['nombre'];
            $id = $reg['id'];
            $opcionb[$id] = $nombre;
        }

        $bodegas = EmpresaQuery::create()->orderByNombre()->find();
        $opcionb = null;
        $opcionb[null] = '[Seleccione Empresa]';
        foreach ($bodegas as $litabo) {
            $opcionb[$litabo->getId()] = $litabo->getNombre();
        }
        $this->setWidget('empresa', new sfWidgetFormChoice(array("choices" => $opcionb,
                ), array("class" => " form-control")));
        $this->setValidator('empresa', new sfValidatorString(array('required' => false)));

        
        $vendedorQ = VendedorQuery::create()->orderByNombre()->find();
         $listaV[null]='Seleccione';
        foreach($vendedorQ as $reg) {
            $listaV[$reg->getId()]=$reg->getNombre();
        }
        
        
           $this->setWidget('vendedor_id', new sfWidgetFormChoice(array("choices" => $listaV,
                ), array("class" => " form-control")));
        $this->setValidator('vendedor_id', new sfValidatorString(array('required' => false)));
        
        
        
        
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, "validaUsuario")
        )));

        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, "validaUsuario")
        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

    public function validaUsuario(sfValidatorBase $validator, array $values) {

        $tipo = $values['tipo'];
        if ($tipo == "Tienda") {
            if (!$values['bodega']) {
//            if (!$values['usuario']) {
//             $msg = 'Usuario Requerido';
//            throw new sfValidatorErrorSchema($validator, array("usuario" => new sfValidatorError($validator, $msg)));
//            }
                $msg = 'Para el tipo de usuario debe de asignar tienda';
                throw new sfValidatorErrorSchema($validator, array("bodega" => new sfValidatorError($validator, $msg)));
            }
        }
        return $values;
    }

}
