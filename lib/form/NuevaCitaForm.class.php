<?php
class NuevaCitaForm extends sfForm
{
    public function configure()
    {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $clientes = ClienteQuery::create()
            ->filterByEmpresaId($empresaId)
            ->select(array('Id', 'Nombre'))
            ->orderByNombre()
            ->find();
        $cliente_widget = array("" => "[Seleccione una opcion]");
        foreach ($clientes as $cliente) {
            $cliente_widget[$cliente['Id']] = $cliente['Nombre'];
        }
        
           $usuarios = UsuarioQuery::create()
            ->select(array('Usuario', 'NombreCompleto'))
            ->orderByNombreCompleto()
            ->find();
        $usuario_widget = array("" => "[Seleccione una opcion]");
        foreach ($usuarios as $usuario) {
            $usuario_widget[$usuario['Usuario']] = $usuario['NombreCompleto'];
        }
        $sesionD[null]='N/A';
        for ($i = 1; $i <= 50; $i++) {
          $sesionD[$i]=$i;   
        }
        
        $this->setWidgets(array(
//            "sesion" => new sfWidgetFormChoice(array("choices" => $sesionD), array(
//                "required" => true,
//                "label" => "No Sesión",
//                "class" => "form-control ",
//             
//            )), 
            "sesion" => new sfWidgetFormInputText(array("label" =>"No Sesión",), array(
               "required" => false,
                "class" => "form-control ",
           
            )),
           "usuario" => new sfWidgetFormChoice(array("choices" => $usuario_widget), array(
                "required" => true,
                "class" => "form-control select2",
                'style' => "width: 100%;height:100%",
            )),            
            "cliente" => new sfWidgetFormChoice(array("choices" => $cliente_widget), array(
                "required" => true,
                "class" => "form-control select2",
                'style' => "width: 100%;height:100%",
            )),
            "fecha" => new sfWidgetFormInputText(array("label" => "Fecha",), array(
                "required" => true,
                "class" => "form-control datepicker",
                'data-date-format' => 'dd/mm/yyyy',
                'style' => "width: 100%"
            )),
            "hora_inicio" => new sfWidgetFormInputText(array("label" => "Hora Inicio",), array(
                "required" => true,
                "class" => "form-control timepicker",
                'style' => "width: 100%"
            )),
            "hora_fin" => new sfWidgetFormInputText(array("label" => "Hora Fin",), array(
                "required" => true,
                "class" => "form-control timepicker",
                'style' => "width: 100%"
            )),
            "observaciones" => new sfWidgetFormTextarea(array("label" => "Observaciones",), array(
                "required" => true,
                "class" => "form-control",
            )),
        ));

        $this->setValidators(array(
                'usuario' => new sfValidatorString(
                array("required" => false)
            ),
             'sesion' => new sfValidatorString(
                array("required" => false)
            ),
            'cliente' => new sfValidatorString(
                array("required" => true)
            ),
            'fecha' => new sfValidatorString(
                array("required" => true)
            ),
            'hora_inicio' => new sfValidatorString(
                array("required" => true)
            ),
            'hora_fin' => new sfValidatorString(
                array("required" => true)
            ),
            'observaciones' => new sfValidatorString(
                array("required" => true)
            ),

        ));
        $this->widgetSchema->setNameFormat('nueva_cita[%s]');
        $this->validatorSchema->setPostValidator(new sfValidatorCallback(array(
            'callback' => array($this, "validaCita")
        )));
    }

    public function validaCita(sfValidatorBase $validator, array $values)
    {
        if (strtotime($values['hora_inicio']) > strtotime($values['hora_fin'])) {
            throw new sfValidatorErrorSchema(
                $validator,
                array("hora_fin" => new sfValidatorError($validator, "Hora fin no debe ser menor que hora de inicio."))
            );
        }
        return $values;
    }
}
