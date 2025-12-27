<?php

class ConsultaFechaVentaForm extends sfForm {

    public function configure() {
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');

        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(),
                        array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        $estatuOP[null] = "Todos los estatus";
        $estatuOP['Procesados'] = "Procesados";
        $estatuOP['Anulados'] = "Anulados";
        $estatuOP['Pagados'] = "Pagados";
        $estatuOP['PendientesPago'] = "Pendientes Pago";

        $this->setWidget('estatus_op', new sfWidgetFormChoice(array("choices" => $estatuOP), array("class" => " form-control")));
        $this->setValidator('estatus_op', new sfValidatorString(array('required' => false)));

        $bodegas = TiendaQuery::create()->find();
        $opcionb[null] = '[Todas las tiendas]';
        foreach ($bodegas as $litabo) {
            $opcionb[$litabo->getId()] = $litabo->getNombre();
        }
        $this->setWidget('bodega', new sfWidgetFormChoice(array( "choices" => $opcionb), array("class" => " form-control")));
        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));
        $usuarioQ = UsuarioQuery::create()->find();
            $ListaU[] = 'Todos los usuarios';
            foreach ($usuarioQ as $data) {
                $ListaU[$data->getUsuario()] = $data->getUsuario();
            }
       
        $this->setWidget('usuario', new sfWidgetFormChoice(array("choices" => $ListaU), array("class" => " form-control")));
        $this->setValidator('usuario', new sfValidatorString(array('required' => false)));

        

        $listave = VendedorQuery::create()
                ->orderByNombre()
                ->find();
        $ListaV[null] = 'Vendedores y No Vendedores';
        $ListaV[-99] = 'Solo los vendedores';
        foreach($listave as $ven) {
                $ListaV[$ven->getId()] = $ven->getNombre();
        }
        
         $this->setWidget('vendedor', new sfWidgetFormChoice(array("choices" => $ListaV), array("class" => " form-control")));
        $this->setValidator('vendedor', new sfValidatorString(array('required' => false)));

    
            $this->setWidget('busqueda', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                 'placeholder'=>'Nombre Factura',
                 )));
        $this->setValidator('busqueda', new sfValidatorString(array('required' => false)));

       
             $this->setWidget('cliente', new sfWidgetFormInputText(array(), array(
                   'placeholder'=>'Codigo/Nombre Cliente',
                 'class' => 'form-control')));
        $this->setValidator('cliente', new sfValidatorString(array('required' => false)));


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
