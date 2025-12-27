<?php

class CreaCampoUsuarioForm extends sfForm {

    public function configure() {


        
       $tipo[null]='Todos los Documentos';
       $tipo['OrdenCompra'] = 'Orden Compra';
       $tipo['Cotizacion']='Cotización';
       $tipo['Venta']='Venta';
       $tipo['MovimientoBanco']='Movimiento Banco';
       $tipo['Ahorro']='Pago';
//       $tipo['Facturar']='Facturar';
       $tipo['Caja']='Caja';
 $tipo['Gasto']='Gasto';
       $tipo['Cliente']='Cliente';
       
        $this->setWidget('tipo_documento', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tipo_documento', new sfValidatorString(array('required' => false)));
        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150, "placeholder" => "Titulo del campo",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));
        
        $tipoc['texto']="Texto (150 caracteres)";
        $tipoc['texto_largo']="Texto Largo";
        $tipoc['entero']='Numero Entero';
        $tipoc['decimal']="Numero con Decimal";
        $tipoc['fecha']="Fecha";
        $tipoc['lista']="Selección de Lista";
        
        $this->setWidget('tipo_campo', new sfWidgetFormChoice(array("choices" => $tipoc,), array("class" => "form-control")));
        $this->setValidator('tipo_campo', new sfValidatorString(array('required' => true)));
        

        $this->setWidget('valores', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce')));
        $this->setValidator('valores', new sfValidatorString(array('required' => false)));
        $this->setWidget('activo', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));

        $this->setWidget('requerido', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('requerido', new sfValidatorString(array('required' => false)));


         
        for ($i = 1; $i <= 10; $i++) {
            $listaO[$i]=$i;
        }
                 
        
        $this->setWidget('orden', new sfWidgetFormChoice(array("choices" => $listaO,), array("class" => "form-control")));
        $this->setValidator('orden', new sfValidatorString(array('required' => true)));
        
$tiendaQ = TiendaQuery::create()
        ->filterByActivo(true)
        ->find();
$LISTAT[null]='[Todas las tiendas]';
foreach ($tiendaQ as $regist)   {
    $LISTAT[$regist->getId()]=$regist->getNombre();
    
}
        
        $this->setWidget('tiendaId', new sfWidgetFormChoice(array("choices" => $LISTAT,), array("class" => "form-control")));
        $this->setValidator('tiendaId', new sfValidatorString(array('required' =>false)));
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
