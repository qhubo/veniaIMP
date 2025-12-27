<?php

class CreaClaveForm extends sfForm {

    public function configure() {

        $this->setWidget('clave', new sfWidgetFormInputText(array(), array('class' => 'form-control', "placeholder" => "*******",)));
        $this->setValidator('clave', new sfValidatorString(array('required' => true)));

        $this->setWidget('clave_anterior', new sfWidgetFormInputText(array(), array('class' => 'form-control', "placeholder" => "*******",)));
        $this->setValidator('clave_anterior', new sfValidatorString(array('required' => true)));
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
                    'callback' => array($this, "validaUsuario")
        )));

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

    public function validaUsuario(sfValidatorBase $validator, array $values) {
       $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()
                ->filterByClave(sha1($values['clave_anterior']))
                ->filterById($usuarioId)
                ->findOne();
        if (!$usuarioQ)  {
             throw new sfValidatorErrorSchema($validator, array("clave_anterior" => new sfValidatorError($validator, 'Clave anterior no es valida')));
        }
        return $values;
    }

}
