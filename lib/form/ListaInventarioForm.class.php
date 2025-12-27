<?php
class ListaInventarioForm extends sfForm {
    
    public function configure() {
              $return= InventarioVenceQuery::create()
                    ->filterByDespachado(false)
                    ->groupByFechaVence()
                     ->withColumn('count(InventarioVence.Id)', 'TotalGeneral')
                      ->groupByProductoId()
                      ->groupByTiendaId()
                     ->find();
            
              
        foreach($return as $data) {
        $name = $data->getFechaVence('dmY')."_".$data->getProductoId()."_".$data->getTiendaId();
//        echo $name;
//        echo "<br>";
            $this->setWidget($name, new sfWidgetFormInputText(array(), array('class' => 'form-control',
              'step'=>'any', 'type'=>'number','placeholder'=>'0.00' ,  'max'=> $data->getTotalGeneral()  )));
        $this->setValidator($name, new sfValidatorString(array('required' => false)));
        
               $this->setWidget($name."existe", new sfWidgetFormInputText(array(), array('class' => 'form-control',
                   'value'=>$data->getTotalGeneral(),
              'step'=>'any', 'type'=>'hidden','placeholder'=>'0.00' ,  'max'=> $data->getTotalGeneral()  )));
        $this->setValidator($name."existe", new sfValidatorString(array('required' => false)));
        }
        $this->widgetSchema->setNameFormat('ingreso[%s]');
    }
}