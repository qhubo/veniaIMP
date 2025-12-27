<?php

class ConsultaParaKardexForm extends sfForm {

    public function configure() {
        
        $opcionesx['SIN TRANSITO']='SIN TRANSITO';
        $opcionesx['CON TRANSITO']='CON TRANSITO';
       $opcionesx['TRANSITO']='TRANSITO';
         
          $this->setWidget('transito', new sfWidgetFormChoice(array("choices" => $opcionesx,), array("class" => " form-control")));
        $this->setValidator('transito', new sfValidatorString(array('required' => false)));


        
        
        
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
        $bodegas = TiendaQuery::create()->orderByNombre()->find();
        $opcionb[null] = '[Todas las Bodegas]';
        foreach ($bodegas as $deta) {
            $opcionb[$deta->getId()] = $deta->getNombre();
        }

        $this->setWidget('bodega', new sfWidgetFormChoice(array("choices" => $opcionb,), array("class" => " form-control")));
        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));


        $consulta = "select distinct(motivo) as motivo from producto_movimiento";
        $con = Propel::getConnection();
        $stmt = $con->prepare($consulta);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $opciones[null] = 'Todos los Motivos';
        foreach ($result as $cate) {
            $opciones[$cate['motivo']] = $cate['motivo'];
        }
        $this->setWidget('motivo', new sfWidgetFormChoice(array("choices" => $opciones,), array("class" => " form-control")));
        $this->setValidator('motivo', new sfValidatorString(array('required' => false)));

        $opcionT = null;
        $opcionT[null] = '[Todos los Tipos]';
        $opcionT['SALIDA'] = 'SALIDA';
        $opcionT['ENTRADA'] = 'ENTRADA';
  
        $this->setWidget('tipo', new sfWidgetFormChoice(array("choices" => $opcionT,), array("class" => " form-control")));
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));

        $this->setWidget('nombrebuscar', new sfWidgetFormInputText(array(), array('class' => 'form-control ',
            "placeholder" => "buscar producto..."
        )));
        $this->setValidator('nombrebuscar', new sfValidatorString(array('required' => false)));




        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
