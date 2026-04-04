<?php

class CreaDevolucionForm extends sfForm {

    public function configure() {
//        $MEdioPago = MedioPagoQuery::create()
//                ->filterByPagoProveedor(true)
//                ->filterByActivo(true)
//                ->orderByNombre()
//                ->find();

        $listaPM['Cheque'] = 'Cheque';
//        foreach ($MEdioPago as $rege) {
//            $listaPM[$rege->getNombre()] = $rege->getNombre();
//        }
        $listaPM['Vale'] = 'Vale';
//        $listaPM['Cambio'] = 'Cambio';
        $this->setWidget('medio', new sfWidgetFormChoice(array("choices" => $listaPM,), array("class" => " form-control ")));
        $this->setValidator('medio', new sfValidatorString(array('required' => true)));

        $opcionesta['Cliente'] = 'Cliente';
        $opcionesta['Proveedor'] = 'Proveedor';
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $opcionesta,), array("class" => " form-control ")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));

        $proveddores = ProveedorQuery::create()->orderByNombre()->filterByActivo(true)->find();
        $listaP[null] = '[Seleccione Proveedor]';
        foreach ($proveddores as $deta) {
            $listaP[$deta->getId()] = $deta->getNombre();
        }
        $this->setWidget('proveedor_id', new sfWidgetFormChoice(array( "choices" => $listaP,), array("class" => " form-control  mi-selector", "style"=>"width:100%")));
        $this->setValidator('proveedor_id', new sfValidatorString(array('required' => false)));

        $clientes = ClienteQuery::create()->orderByNombre()->filterByActivo(true)->find();
        $listaC[null] = '[Seleccione Cliente]';
        foreach ($clientes as $deta) {
            $listaC[$deta->getId()] =$deta->getCodigo()." ".$deta->getNombre();
        }
        $this->setWidget('cliente_id', new sfWidgetFormChoice(array( "choices" => $listaC,), array("class" => " form-control  mi-selector " , "style"=>"width:100%")));
        $this->setValidator('cliente_id', new sfValidatorString(array('required' => false)));
        $this->setWidget('retorna_inventario', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('retorna_inventario', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Nombre",  "style"=>"background-color:whitesmoke")));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        $this->setWidget('referencia_factura', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Factura', 'max_length' => 150,)));
        $this->setValidator('referencia_factura', new sfValidatorString(array('required' => true)));

        $this->setWidget('concepto', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('concepto', new sfValidatorString(array('required' => true)));

        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'onkeypress' => 'validate(event)', 'placeholder' => '00.00', 'max_length' => 150,)));

        $this->setValidator('valor', new sfValidatorString(array('required' => true)));

        $this->setWidget("archivo2", new sfWidgetFormInputFile(array(), array()));
        $this->setValidator('archivo2', new sfValidatorFile(array('required' => false), array()));


        $this->setWidget("archivo", new sfWidgetFormInputFile(array(), array()));
        $this->setValidator('archivo', new sfValidatorFile(array('required' => $obligatorio), array()));

//         vendedor:                          { type: varchar(50) }
//     referencia_nota:                   { type: varchar(50) }
//     no_hollander:                      { type: varchar(50) }
//     no_stock:                          { type: varchar(50) }
//     descripcion: 
        //$obligatorio=false;
        $listaVen[null] = "[Seleccione]";
        $vendedoresQ = VendedorQuery::create()
                ->filterByActivo(true)
                ->find();
        foreach ($vendedoresQ as $registro) {
            $listaVen[$registro->getNombre()] = $registro->getNombre();
        }

        $this->setWidget('vendedor', new sfWidgetFormChoice(array("choices" => $listaVen,), array("class" => " form-control ")));


        $this->setValidator('vendedor', new sfValidatorString(array('required' => $obligatorio)));

        $this->setWidget('referencia_nota', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Nota', 'max_length' => 50,)));
        $this->setValidator('referencia_nota', new sfValidatorString(array('required' => $obligatorio)));

 
                $productos = ProductoQuery::create();
        $listado= $productos->select(['Id','CodigoSku', 'Nombre'])->find()->getData();
        $listadoProductos  = $listado;
         $listaT[null]='Seleccione';
        foreach ($listadoProductos as $regi) {
            $listaT[$regi['Id']]=$regi['CodigoSku']." ".$regi['Nombre'];
        }
        
          $this->setWidget('no_hollander', new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => "mi-selector  form-control ")));
        $this->setValidator('no_hollander', new sfValidatorString(array('required' => true)));

        
        
        $this->setWidget('no_stock', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'placeholder' => 'Stock', 'max_length' => 50,)));
        $this->setValidator('no_stock', new sfValidatorString(array('required' => $obligatorio)));

        $this->setWidget('descripcion', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => $obligatorio)));

        $this->setWidget('retencion', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('retencion', new sfValidatorString(array('required' => false)));

        $this->setWidget('porcentaje_retenie', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'onkeypress' => 'validate(event)', 'placeholder' => '0', 'max_length' => 150,)));
        $this->setValidator('porcentaje_retenie', new sfValidatorString(array('required' => false)));


        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => $obligatorio)));



        $this->setWidget('cantidad', new sfWidgetFormInputText(array(), array('type'=>'number', 'class' => 'form-control', 'placeholder' => '00', 'max_length' => 50,)));
        $this->setValidator('cantidad', new sfValidatorString(array('required' => true)));

        
        $tiendas  = TiendaQuery::create()->orderByNombre()->filterByActivo(true)->find();
        $listaTi[null] = '[Seleccione Tienda]';
        foreach ($tiendas as $deta) {
            $listaTi[$deta->getId()] = $deta->getNombre();
        }
        $this->setWidget('tienda_id', new sfWidgetFormChoice(array( "choices" => $listaTi,), array("class" => " form-control ", "style"=>"width:100%")));
        $this->setValidator('tienda_id', new sfValidatorString(array('required' => false)));

        

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }



}
