<?php

class CapturaDatosBOleta extends sfForm {

    public function configure() {

         $listaRegion[null] = '[Seleccione]';
        $regionq = BancoQuery::create()
                ->filterById(6)
                ->find();
        
       $usuarioa=sfContext::getInstance()->getUser()->getAttribute("usuarioNombre",null, 'seguridad'); 
        if ( (strtoupper($usuarioa) =='ANDREA')) {
             $regionq = BancoQuery::create()
                ->find();
        }
        foreach ($regionq as $data) {
            $listaRegion[$data->getId()] = $data->getNombre();
        }
        $this->setWidget('banco_id', new sfWidgetFormChoice(array("choices" => $listaRegion,), array("class" => " form-control ")));
        $this->setValidator('banco_id', new sfValidatorString(array('required' => true)));
        
         $listaB = TiendaQuery::TiendaActivas();
         $listaT[null] = '[Seleccione]';
        $regionq = TiendaQuery::create()
                ->filterById($listaB)
                ->find();
        foreach ($regionq as $data) {
            $listaT[$data->getId()] = $data->getNombre();
        }
        
       
        
        $this->setWidget('tienda_id', new sfWidgetFormChoice(array("choices" => $listaT,), array("class" => "mi-selector  form-control ")));
        $this->setValidator('tienda_id', new sfValidatorString(array('required' => true)));

        
         $this->setWidget('fecha_deposito', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_deposito', new sfValidatorString(array('required' => true)));
        
        
        $this->setWidget('total', new sfWidgetFormInputText(array(), array('class' => 'form-control',
             'onkeypress' => 'validate(event)', 'placeholder' => '0.00', )));
        $this->setValidator('total', new sfValidatorString(array('required' => true)));

         $this->setWidget('boleta', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'No Boleta', 'max_length' => 50,)));
        $this->setValidator('boleta', new sfValidatorString(array('required' => false)));

                $listaVem[null]="[Seleccione]";
        $vendedorQ = VendedorQuery::create()
                ->filterByActivo(true)
                ->orderByNombre("Asc")
                ->find();
        foreach ($vendedorQ as $vende) {
            $nomb= trim(strtoupper($vende->getNombre()));
            $listaVem[$nomb]=$nomb;
        }

        $this->setWidget('vendedor', new sfWidgetFormChoice(array("choices" => $listaVem, ), array("class" => "mi-selector  mi-selector form-control ")));
        $this->setValidator('vendedor', new sfValidatorString(array('required' => true)));
         
        
        $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => '00000000', 'max_length' => 8, 'min_length' => 8)));
        $this->setValidator('telefono', new sfValidatorString(array('required' => true)));
              
        $this->setWidget('cliente', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'Nombre Completo', 'max_length' => 150,)));
        $this->setValidator('cliente', new sfValidatorString(array('required' => true)));

        
        


        $this->setWidget('pieza', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'No Pieza',)));
        $this->setValidator('pieza', new sfValidatorString(array('required' => true)));

        $this->setWidget('stock', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'placeholder' => 'Stock', 'max_length' => 8, 'min_length' => 8)));
        $this->setValidator('stock', new sfValidatorString(array('required' => true)));


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
