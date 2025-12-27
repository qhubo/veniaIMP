<?php

class ConsultaFechaDatosForm extends sfForm {

    public function configure() {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));

        
        
        $vendedores= VendedorQuery::create()->orderByNombre()->find();       
        $listaVe[null]='Seleccione';
        foreach ($vendedores as $vende) {
            $listaVe[$vende->getId()]=$vende->getNombre();
            
        }                
        $this->setWidget('vendedor', new sfWidgetFormChoice(array("choices" => $listaVe), array("class" => " form-control")));
        $this->setValidator('vendedor', new sfValidatorString(array('required' => false)));


             $this->setWidget('busqueda', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                 'placeholder'=>'Nombre Factura',
                 )));
        $this->setValidator('busqueda', new sfValidatorString(array('required' => false)));

       
             $this->setWidget('cliente', new sfWidgetFormInputText(array(), array(
                   'placeholder'=>'Codigo/Nombre Cliente',
                 'class' => 'form-control')));
        $this->setValidator('cliente', new sfValidatorString(array('required' => false)));

        
              $this->setWidget('producto', new sfWidgetFormInputText(array(), array(
                   'placeholder'=>'Codigo/Nombre Producto',
                 'class' => 'form-control')));
        $this->setValidator('producto', new sfValidatorString(array('required' => false)));
         $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $bodegas = TiendaQuery::create()
                ->orderByNombre()
                ->find();
        $opcionb[null] = '[Todas las tiendas]';
        foreach ($bodegas as $litabo) {
            $opcionb[$litabo->getId()] = $litabo->getNombre();
        }

        $this->setWidget('bodega', new sfWidgetFormChoice(array(
            "choices" => $opcionb,
                ), array("class" => " form-control")));

        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));

       
        
         $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $consulta = "select tipo from operacion_pago where empresa_id =".$empresaId."  group by tipo";
        $con = Propel::getConnection();
        $stmt = $con->prepare($consulta);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
        $opciones[null] = '[Seleccione]';
        foreach ($result as $cate) {
            $opciones[$cate['tipo']] = $cate['tipo'];
      
        }
        
        
                      
        $this->setWidget('medio_pago', new sfWidgetFormChoice(array("choices" => $opciones), array("class" => " form-control")));
        $this->setValidator('medio_pago', new sfValidatorString(array('required' => false)));

        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
