<?php

class IngresoClienteForm extends sfForm {

    public function configure() {
        $DepartamentoId = sfContext::getInstance()->getUser()->getAttribute("departamento", null, 'seleccion');
        $this->setWidget("archivo", new sfWidgetFormInputFile(array(), array('label' => 'label', 'accept' => 'application/pdf, application/pdf',)));
        $this->setValidator('archivo', new sfValidatorFile(array('required' => false,), array()));
        $paisQ = PaisQuery::create()->filterByActivo(true)->find();
        $listaP[null] = '[Seleccione]';
        foreach ($paisQ as $reg) {
            $listaP[$reg->getId()] = $reg->getNombre();
        }


        $this->setWidget('pais', new sfWidgetFormChoice(array("choices" => $listaP), array("class" => " form-control")));
        $this->setValidator('pais', new sfValidatorString(array('required' => false)));

        $lis[null] = '[Seleccione]';
        $depar = DepartamentoQuery::create()->find();
        foreach ($depar as $reg) {
            $lis[$reg->getId()] = $reg->getNombre();
        }

        $this->setWidget('departamento', new sfWidgetFormChoice(array("choices" => $lis), array("class" => " form-control")));
        $this->setValidator('departamento', new sfValidatorString(array('required' => false)));


        $lisv[null] = '[Seleccione]';
        $municipios = MunicipioQuery::create()
                ->filterByDepartamentoId($DepartamentoId)
                ->find();
        foreach ($municipios as $dat) {
            $lisv[$dat->getId()] = $dat->getDescripcion();
        }
//        $this->setWidget('municipio', new sfWidgetFormPropelChoice(
//                array('model' => 'Municipio',
//            'add_empty' => '[ Seleccione Municipio ]',
//            'order_by' => array('Descripcion', 'asc'),
//                ), array('class' => 'form-control',
//        )));
        $this->setWidget('municipio', new sfWidgetFormChoice(array("choices" => $lisv), array("class" => " form-control")));
        $this->setValidator('municipio', new sfValidatorString(array('required' => false)));

        $vendedores = VendedorQuery::create()
                ->orderByNombre()
                ->find();
        $listaV[null] = 'Seleccione';
        foreach ($vendedores as $data) {
            $listaV[$data->getId()] = $data->getNombre();
        }
        $this->setWidget('vendedor_id', new sfWidgetFormChoice(array("choices" => $listaV), array("class" => " form-control")));
        $this->setValidator('vendedor_id', new sfValidatorString(array('required' => false)));


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Nombre")));
        $this->setWidget('pequeno_contribuye', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// cje
        $this->setValidator('pequeno_contribuye', new sfValidatorString(array('required' => false)));
        $this->setWidget('regimen_isr', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// cje
        $this->setValidator('regimen_isr', new sfValidatorString(array('required' => false)));
        $this->setValidator('direccion', new sfValidatorString(array('required' => FALSE)));
        $this->setWidget('direccion', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Dirección")));
        $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "0000-0000")));
        $this->setWidget('nit', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Identificación Tributaria")));
        $this->setWidget('correo_electronico', new sfWidgetFormInputText(array(), array('class' => 'form-control ', 'type' => "email", "placeholder" => "correo@correo.com")));
        $this->setValidator('correo_electronico', new sfValidatorString(array('required' => FALSE)));
        $this->setWidget('limite_credito', new sfWidgetFormInputText(array(), array('class' => 'form-control ',
        )));
        $this->setValidator('limite_credito', new sfValidatorString(array('required' => false)));
        $this->setWidget('tiene_credito', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// cje
        $this->setValidator('tiene_credito', new sfValidatorString(array('required' => false)));

//        $criteriaTecnico = new Criteria();
//       $criteriaTecnico->add(DepartamentoPeer::CODIGO, 'AAAA');
//        $criteriaMunicipio = new Criteria();
//        $criteriaMunicipio->add(MunicipioPeer::DEPARTAMENTO_ID, $DepartamentoId);

        $this->setValidator('nit', new sfValidatorString(array('required' => false)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('telefono_contacto', new sfWidgetFormInputText(array("type" => 'number'), array('class' => 'form-control ', "placeholder" => "0000-0000")));
        $this->setValidator('telefono_contacto', new sfValidatorString(array('required' => FALSE)));
        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('codigo', new sfValidatorString(array('required' => false)));


        $this->setValidator('telefono', new sfValidatorString(array('required' => FALSE)));

        $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// cje
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        $this->setWidget('nombre_factura', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Nombre Facturar")));
        $this->setValidator('nombre_factura', new sfValidatorString(array('required' => true)));


        $opcionesT[null] = 'SIN CALIFICACION';
//        $opcionesT[1] = 'NO TIENE RANGO';
//        $opcionesT[2] = 'PREMIER BAZAR';
//        $opcionesT[3] = 'GOLD BAZAR';
//        $opcionesT[4] = 'PLATINUM BAZAR';
//        $opcionesT[5] = 'BLACK BAZAR';
//        
//        


        $this->setWidget('tipificacion', new sfWidgetFormChoice(array(
                    "choices" => $opcionesT
                        ), array("class" => "form-control")));
        $this->setValidator('tipificacion', new sfValidatorString(array('required' => false)));


        $this->setWidget('observacion', new sfWidgetFormTextarea(array(), array('class' => 'form-control EditorMce'
                    , 'rows' => 25
        )));
        $this->setValidator('observacion', new sfValidatorString(array('required' => false)));



        $this->setWidget('porcentaje_negociado', new sfWidgetFormInputText(array(), array('class' => 'form-control ', 'type' => 'number',
                    'step' => 'any')));
        $this->setValidator('porcentaje_negociado', new sfValidatorString(array('required' => false)));


        $opcionesTx['PRODUCTO'] = 'PRODUCTO';
        $opcionesTx['SERVICIO'] = 'SERVICIO';
        $this->setWidget('tipo_producto', new sfWidgetFormChoice(array(
                    "choices" => $opcionesTx
                        ), array("class" => "form-control")));
        $this->setValidator('tipo_producto', new sfValidatorString(array('required' => false)));




        $this->setWidget('zona', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('zona', new sfValidatorString(array('required' => false)));
        $this->setWidget('avenida_calle', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('avenida_calle', new sfValidatorString(array('required' => false)));
        $this->setWidget('contacto', new sfWidgetFormInputText(array(), array('class' => 'form-control ', "placeholder" => "Persona para contactar")));
        $this->setValidator('contacto', new sfValidatorString(array('required' => FALSE)));
        $this->setWidget('correo_contacto', new sfWidgetFormInputText(array(), array('class' => 'form-control ', 'xtype' => "email", "placeholder" => "contacto@correo.com")));
        $this->setValidator('correo_contacto', new sfValidatorString(array('required' => FALSE)));
        $this->setWidget('token_visa', new sfWidgetFormTextarea(array(), array('class' => 'form-control ', 'rows' => 5)));
        $this->setValidator('token_visa', new sfValidatorString(array('required' => false)));
        $this->setWidget('token_visa_test', new sfWidgetFormTextarea(array(), array('class' => 'form-control ', 'rows' => 5)));
        $this->setValidator('token_visa_test', new sfValidatorString(array('required' => false)));
        $this->setWidget('test_visa', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('test_visa', new sfValidatorString(array('required' => false)));
        $this->setWidget('epay_terminal', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setWidget('epay_merchant', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setWidget('epay_user', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setWidget('epay_key', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setWidget('merchand_id', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setWidget('org_id', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setWidget('numero_cliente_vol', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));


        $this->setValidator('epay_terminal', new sfValidatorString(array('required' => FALSE)));
        $this->setValidator('epay_merchant', new sfValidatorString(array('required' => FALSE)));
        $this->setValidator('epay_user', new sfValidatorString(array('required' => FALSE)));
        $this->setValidator('epay_key', new sfValidatorString(array('required' => FALSE)));
        $this->setValidator('merchand_id', new sfValidatorString(array('required' => FALSE)));
        $this->setValidator('org_id', new sfValidatorString(array('required' => FALSE)));
        $this->setValidator('numero_cliente_vol', new sfValidatorString(array('required' => FALSE)));


        $this->setWidget('pos_integration', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('pos_integration', new sfValidatorString(array('required' => FALSE)));

        $this->setWidget('pos_user', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('pos_user', new sfValidatorString(array('required' => FALSE)));

        $this->setWidget('pos_pass', new sfWidgetFormInputText(array(), array('class' => 'form-control ')));
        $this->setValidator('pos_pass', new sfValidatorString(array('required' => FALSE)));


        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control', 'rows' => 2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));

        $listaPrecio = ListaPrecioQuery::create()->orderByNombre()->find();
        $listaPre['PUBLICO'] = 'PUBLICO';
        foreach ($listaPrecio as $reg) {
            $listaPre[$reg->getNombre()] = $reg->getNombre();
        }
        $this->setWidget('precio', new sfWidgetFormChoice(array("choices" => $listaPre), array("class" => "form-control")));
        $this->setValidator('precio', new sfValidatorString(array('required' => false)));

        $TIPOcLIENTE[NULL] = 'Seleccione';
        $TIPOcLIENTE['A'] = 'EXCELENTE';
        $TIPOcLIENTE['B'] = 'BUENO';
        $TIPOcLIENTE['C'] = 'REGULAR';
        $TIPOcLIENTE['D'] = 'MALO';
        $this->setWidget('tipo_cliente', new sfWidgetFormChoice(array("choices" => $TIPOcLIENTE), array("class" => "form-control")));
        $this->setValidator('tipo_cliente', new sfValidatorString(array('required' => false)));


        $TIPOFUENTE[NULL] = 'Seleccione';
        $TIPOFUENTE['VISITA DIRECTA'] = 'VISITA DIRECTA';
        $TIPOFUENTE['REFERIDO'] = 'REFERIDO';
        $TIPOFUENTE['TIENDA FISICA'] = 'TIENDA FISICA';
        $TIPOFUENTE['REDES SOCIALES'] = 'REDES SOCIALES';
        $TIPOFUENTE['PAGINA WEB'] = 'PAGINA WEB';


        $this->setWidget('fuente', new sfWidgetFormChoice(array("choices" => $TIPOFUENTE), array("class" => "form-control")));
        $this->setValidator('fuente', new sfValidatorString(array('required' => false)));




        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
