<?php

class ProcesoGrabaForm extends sfForm {

    public function configure() {


         $grabapago=     sfContext::getInstance()->getUser()->getAttribute("grabaPago", null, 'seguridad');

                      $editaFecha=true;

         if ($grabapago) {
             $editaFecha=false;
         }
         $grabapago=false;
        $this->setWidget('no_documento', new sfWidgetFormInputText(array(), array(
                    'class' => 'form-control', 'placeholder' => 'documento',)));
        $this->setValidator('no_documento', new sfValidatorString(array('required' => $grabapago)));
        
        
         $this->setWidget('usuario', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
             'readOnly'=>true
            )));
        $this->setValidator('usuario', new sfValidatorString(array('required' => false)));
       
        
        $this->setWidget('fecha', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'max_length' => 150,     'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy',
            'readOnly'=>$editaFecha )));
        $this->setValidator('fecha', new sfValidatorString(array('required' => false)));
        
        
        $this->setWidget('codigo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
         'max_length' => 150,  "readonly"=>true  )));
        $this->setValidator('codigo', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('valor', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'readOnly'=>true,  'max_length' => 150,  'readonly'=>true )));
        $this->setValidator('valor', new sfValidatorString(array('required' => false)));
        
        $this->setWidget('tipo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'max_length' => 150,  "readonly"=>true )));
        $this->setValidator('tipo', new sfValidatorString(array('required' => true)));
        
        
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce','rows'=>2)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
       
        $bancos = BancoQuery::create()->filterByActivo(true)
                        //->filterByPagoCheque(true)
                        ->orderByNombre()->find();
        $listaB[null] = '[Seleccione]';

        foreach ($bancos as $deta) {
            $listaB[$deta->getId()] = $deta->getNombre();
        }


        $this->setWidget('banco_id', new sfWidgetFormChoice(array("choices" => $listaB), array("class" => "form-control")));
        $this->setValidator('banco_id', new sfValidatorString(array('required' => $grabapago)));

        
               $this->setWidget('no_confirmacion', new sfWidgetFormInputText(array(), array(
                    'class' => 'form-control', 'placeholder' => 'No Documento Banco',)));
        $this->setValidator('no_confirmacion', new sfValidatorString(array('required' =>false)));
        
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
