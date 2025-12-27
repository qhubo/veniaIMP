<?php

class CreaOrdenCotizacionForm extends sfForm {

    public function configure() {


//        $this->setWidget('serie', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 10,
//            "placeholder" => "serie",)));
//        $this->setValidator('serie', new sfValidatorString(array('required' => false)));
//
//        $this->setWidget('no_documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
//            "placeholder" => "No Documento",)));
//        $this->setValidator('no_documento', new sfValidatorString(array('required' => true)));


        $this->setWidget('fecha_documento', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker',
                    'readonly' => true,
                    'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fecha_documento', new sfValidatorString(array('required' => true)));
        $this->setWidget('fecha_contabilizacion', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'type' => 'hidden')));
        $this->setValidator('fecha_contabilizacion', new sfValidatorString(array('required' => false)));

//        $this->setWidget('dia_credito', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'type' => 'number',)));
//        $this->setValidator('dia_credito', new sfValidatorString(array('required' => true)));

        $this->setWidget('nit', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
                    "placeholder" => "Nit",)));
        $this->setValidator('nit', new sfValidatorString(array('required' => true)));


        $this->setWidget('nombre', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
                    "placeholder" => "Nombre",)));
        $this->setValidator('nombre', new sfValidatorString(array('required' => true)));



        $this->setWidget('telefono', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'max_length' => 150,
                    "placeholder" => "0000-0000",)));
        $this->setValidator('telefono', new sfValidatorString(array('required' => false)));

        $this->setWidget('direccion', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce', 'rows' => 2)));
        $this->setValidator('direccion', new sfValidatorString(array('required' => false)));






        $this->setWidget('correo', new sfWidgetFormInputText(array(), array('class' => 'form-control',
                    'max_length' => 150, 'type' => 'email',
                    "placeholder" => "cuenta@correo",)));
        $this->setValidator('correo', new sfValidatorString(array('required' => false)));

    $empresaid=sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $this->setWidget('observaciones', new sfWidgetFormTextarea(array(), array('class' => 'form-control noEditorMce', 'rows' => 1)));
        $this->setValidator('observaciones', new sfValidatorString(array('required' => false)));
        $this->setWidget('exenta', new sfWidgetFormInputCheckbox(array(), array('class' => 'checkbox')));
        $this->setValidator('exenta', new sfValidatorString(array('required' => false)));
        $listab = TiendaQuery::TiendaActivas();
        $vboedgas = TiendaQuery::create()
                ->filterByEmpresaId($empresaid)
                ->filterByActivo(true)
                ->filterById($listab, Criteria::IN)
                ->orderByNombre()
                ->find();

//        $tipo[null] = '[Seleccione]';
        foreach ($vboedgas as $registro) {
            $tipo[$registro->getId()] = $registro->getNombre();
        }

        $this->setWidget('tienda_id', new sfWidgetFormChoice(array("choices" => $tipo,), array("class" => "form-control")));
        $this->setValidator('tienda_id', new sfValidatorString(array('required' => true)));

        $vendedores = VendedorQuery::create()->orderByNombre()->find();
        $tipoV[null] = '[Seleccione]';

        $usuarioa = sfContext::getInstance()->getUser()->getAttribute("usuarioNombre", null, 'seguridad');
        $tipoUsua = sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad');
         $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
         $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
         $tipoUsuaId= $usuarioQ->getTipoUsuario();
         $pefilq = PerfilQuery::create()->findOneById($tipoUsuaId);
         if ($pefilq) {
            $tipoUsua= $pefilq->getDescripcion(); 
         }
         
        
        if (strtoupper($tipoUsua) == 'ADMINISTRADOR' ) {
            foreach ($vendedores as $regis) {
                $tipoV[$regis->getId()] = $regis->getNombre();
            }
        }
        if (strtoupper($tipoUsua) == 'CONTABILIDAD') {
             foreach ($vendedores as $regis) {
                $tipoV[$regis->getId()] = $regis->getNombre();
            }
        }
              if (strtoupper($tipoUsua) == 'FACTURAR') {
             foreach ($vendedores as $regis) {
                $tipoV[$regis->getId()] = $regis->getNombre();
            }
        }

        $this->setWidget('vendedor_id', new sfWidgetFormChoice(array("choices" => $tipoV,), array("class" => "form-control")));
        $this->setValidator('vendedor_id', new sfValidatorString(array('required' => false)));


        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
