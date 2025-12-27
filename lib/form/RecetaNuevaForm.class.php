<?php
class RecetaNuevaForm extends sfForm
{
    public function configure()
    {
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("empresa", null, 'seguridad');
        $clientes = ClienteQuery::create()
            ->filterByEmpresaId($empresaId)
            ->select(array('Id', 'Nombre'))
            ->orderByNombre()
            ->find();
        $productos = ProductoQuery::create()
            ->filterByComboProductoId(null)
            ->filterByEmpresaId($empresaId)
            ->filterByActivo(true)
            ->select(array('Nombre', 'Id'))
            ->orderByNombre()
            ->find();
        $cliente_widget = array("" => "[Seleccione una opcion]");
        foreach ($clientes as $cliente) {
            $cliente_widget[$cliente['Id']] = $cliente['Nombre'];
        }
        $producto_widget = array("" => "[Seleccione una opcion]");
        foreach ($productos as $producto) {
            $producto_widget[$producto['Id']] = trim($producto['Nombre']);
        }
        $tipos = array("" => "[Seleccione un tipo]", "Producto" => "Producto", 'Servicio' => "Servicio", "Otros" => "Otros");
        $cada = array(''=>'N/A', "hora(s)" => "hora(s)", "dia(s)" => "dia(s)", "semana(s)" => "semana(s)", "mes(es)" => "mes(es)");
        $this->setWidgets(array(
            "cliente" => new sfWidgetFormChoice(array("choices" => $cliente_widget), array(
                "required" => true,
                "class" => "form-control select2",
                'style' => "width: 100%;height:100%",
            )),
            "producto" => new sfWidgetFormChoice(array("choices" => $producto_widget), array(
                "class" => "form-control select2",
                'style' => "width: 100%;height:100%",
            )),
            'observaciones_cabecera' => new sfWidgetFormTextarea(array('label' => "Observaciones"), array('class' => 'form-control')),
            "fecha" => new sfWidgetFormInputText(array(), array('class' => "form-control", 'readonly' => true)),
            "frecuencia" => new sfWidgetFormInputText(array(), array('class' => "form-control", 'style' => 'width:50%; float:left')),
            "dosis" => new sfWidgetFormInputText(array(), array('class' => "form-control")),
            "tipo" => new sfWidgetFormChoice(array('choices' => $tipos), array(
                "class" => "form-control select2",
                'style' => "width: 100%;height:100%",
            )),
            "cada" => new sfWidgetFormChoice(array('choices' => $cada), array(
                "class" => "form-control select2",
                'style' => "width: 50%;height:100%;float:left",
            )),
            "servicio" => new sfWidgetFormInputText(array(), array('class' => 'form-control')),
            'observaciones' => new sfWidgetFormTextarea(array(), array('class' => 'form-control')),
            'detalle' => new sfWidgetFormInputText(array(), array('style' => 'display:none')),
        ));
        $this->setValidator("cliente", new sfValidatorString(array('required' => true)));
        $this->setValidator("producto", new sfValidatorString(array('required' => false)));
        $this->setValidator("fecha", new sfValidatorString(array('required' => false)));
        $this->setValidator("frecuencia", new sfValidatorString(array('required' => false)));
        $this->setValidator("dosis", new sfValidatorString(array('required' => false)));
        $this->setValidator("cada", new sfValidatorString(array('required' => false)));
        $this->setValidator("servicio", new sfValidatorString(array('required' => false)));
        $this->setValidator("observaciones", new sfValidatorString(array('required' => false)));
        $this->setValidator("observaciones_cabecera", new sfValidatorString(array('required' => true)));
        $this->setValidator("detalle", new sfValidatorString(array('required' => false)));
        $this->setValidator("tipo", new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('receta_nueva[%s]');
    }
}
