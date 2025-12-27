<?php


class EditaTipoAparatoForm extends sfForm {

    public function configure() {
  
                
        $filtro ="(CuentaErpContable.Nombre like '%invent%' ";
        $filtro .=" or  CuentaErpContable.Nombre like '%produc%'";
        $filtro .=" or  CuentaErpContable.Nombre like '%venta%'";
        $filtro .=") ";
		
           $nombreBanco = CuentaErpContableQuery::create()
                // ->where('length(CuentaErpContable.CuentaContable) >6 ')
                 ->where($filtro)
                ->orderByCuentaContable("Asc")
                ->find();
           
           
 
        $listaC[null]='[Seleccione]';
        foreach ($nombreBanco as $linea) {
            if (strlen($linea->getCuentaContable()) >4) {
            $listaC[$linea->getCuentaContable()]= $linea->getCuentaContable()." ". $linea->getNombre();
            }
        }
        
        $this->setWidget('cuenta_contable', new sfWidgetFormChoice(array("choices" => $listaC,), array("class" => "mi-selector form-control")));
        $this->setValidator('cuenta_contable', new sfValidatorString(array('required' => false)));

        
        
        
        $this->setWidget("archivo" , new sfWidgetFormInputFile(array(), array()));
        $this->setValidator('archivo',  new sfValidatorFile(array('required' => false), array()) );
        $this->setWidget('limpia', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('limpia', new sfValidatorString(array('required' => false)));
        

        $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            "placeholder" => "Ingrese nombre ",
        )));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => true)));

       $this->setWidget('venta', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('venta', new sfValidatorString(array('required' => false)));
     
             
           $this->setWidget('activo', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('activo', new sfValidatorString(array('required' => false)));
     
           $this->setWidget('receta', new sfWidgetFormInputCheckbox()); // new sfWidgetFormInputText(array(), array('class' => 'form-control','data-provide'=>'datepicker')));// check
        $this->setValidator('receta', new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
