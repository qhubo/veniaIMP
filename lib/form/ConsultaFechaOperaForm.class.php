<?php

class ConsultaFechaOperaForm extends sfForm {

    public function configure() {

        $campos = EmpresaCampoFacturaQuery::create()->orderByOrden()->find();

        foreach ($campos as $li) {
            $opciones = null;
            $Identificado = $li->getCatalogoIdentificador();
            if ($Identificado == 0) {
                $this->setWidget('campo_' . $li->getId(), new sfWidgetFormInputText(array(), array('class' => 'form-control',)));
            } else {
                
                $opciones[null]='Todos';
                $cataglo = SeleccionEmpresaCampoDetalleQuery::create()
                        ->filterBySeleccionEmpresaCampoId ($Identificado)
                        ->find();
                foreach($cataglo as $lin) {
                    $opciones[$lin->getTitulo()] = $lin->getTitulo();
                }
                
                $this->setWidget('campo_'.$li->getId(), new sfWidgetFormChoice(array(
                    "choices" => $opciones,
                        ), array("class" => " form-control")));
            }


            $this->setValidator('campo_' . $li->getId(), new sfValidatorString(array('required' => false)));
        }


        $this->setWidget('tipo', new sfWidgetFormPropelChoice(array('model' => 'TipoAparato'
            , 'add_empty' => 'Todos los ' . TipoAparatoQuery::tipo()
                ), array('class' => 'form-control', // actualizar_combo
            'objeto' => 'TipoAparato',
            //'destino' => '#consulta_usuario', 'inicial' => $inicial,
            'url' => sfContext::getInstance()->getController()->genUrl('corte_caja/usuarioAjax'))));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

        $this->setWidget('bodega', new sfWidgetFormPropelChoice(array('model' => 'Bodega'
            , 'add_empty' => 'Todas Las Bodegas'
                ), array('class' => 'form-control', // actualizar_combo
            'objeto' => 'Bodega',
                //'destino' => '#consulta_usuario', 'inicial' => $inicial,
        )));

        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
       
      //  $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker')));
         $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
         
        
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => false)));
       // $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
