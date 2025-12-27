<?php

class CreaMenuForm extends sfForm {

    public function configure() {
        $this->setWidget('icono', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 250, "placeholder" => "Título",)));
        $this->setValidator('icono', new sfValidatorString(array('required' => false)));

        $this->setWidget('descripcion', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 250, "placeholder" => "Título",)));
        $this->setValidator('descripcion', new sfValidatorString(array('required' => true)));
     
        $this->setWidget('modulo', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 250, "placeholder" => "Modulo",)));
        $this->setValidator('modulo', new sfValidatorString(array('required' => false)));
      

        $this->setWidget('orden', new sfWidgetFormInputText(array(), array('class' => 'form-control', 
            'type'=>'number')));
        $this->setValidator('orden', new sfValidatorString(array('required' => true)));

        $this->setWidget('submenu', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('submenu', new sfValidatorString(array('required' => false)));
//     
        
        
         $lineaProve[null]='';

        $mennuseguridad = MenuSeguridadQuery::create()
                ->filterBySuperior(0)
                ->find();
        foreach ($mennuseguridad as $regist) {
            $lineaProve[$regist->getId()]= $regist->getDescripcion();
        }
        
        $mennuseguridad = MenuSeguridadQuery::create()
                ->filterByModulo('')
                ->filterBySubMenu(true)
                ->find();
        foreach ($mennuseguridad as $regist) {
            $text='';
            $superioq = MenuSeguridadQuery::create()->findOneById($regist->getSuperior());
            if ($superioq) {
                $text=$superioq->getDescripcion();
            }
                    
            
            $lineaProve[$regist->getId()]= $text." | ".$regist->getDescripcion();
        }

        
           $this->setWidget('superior', new sfWidgetFormChoice(array(
            "choices" => $lineaProve,
                ), array("class" => "form-control")));

           
           
//         $criteria = new Criteria();
//            $criteria->add(MenuSeguridadPeer::SUPERIOR, 0, Criteria::EQUAL);
//            
//        $this->setWidget('superior', new sfWidgetFormPropelChoice(array('model' => 'MenuSeguridad',
//            
//             'criteria'=>$criteria,
//            'add_empty'=>'',),
//                array('add_empty'=>'', 'class'=> 'form-control',)));
        
        $this->setValidator('superior', new sfValidatorString(array('required' => false)));
//          $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
//            'callback' => array($this, "valida")
//        )));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
