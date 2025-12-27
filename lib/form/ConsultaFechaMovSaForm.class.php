<?php

class ConsultaFechaMovSaProductoForm extends sfForm {

    public function configure() {
        $opcionesP['Creacion']='Creación';
        $opcionesP['Documento']='Documento';
        $opcionesP['Contabilizacion']='Contabilización';
         $this->setWidget('tipo_fecha', new sfWidgetFormChoice(array(
            "choices" => $opcionesP,
                ), array("class" => " form-control")));
        
        $this->setValidator('tipo_fecha', new sfValidatorString(array('required' => false)));
       
        
        $this->setValidator('estado', new sfValidatorString(array('required' => false)));
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), array('class' => 'form-control', 'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
        $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
            'data-provide' => 'datepicker', 'data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        $consulta = "select usuario_id, usuario, o.estatus as estado from salida_producto  o inner join usuario u on u.id =usuario_id  group by usuario_id,o.estatus";
        $con = Propel::getConnection();
        $stmt = $con->prepare($consulta);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $opusuari[null]='Todos los Usuarios';
        $opciones[''] = '[Todos los estados]';
        foreach ($result as $cate) {
            $opciones[$cate['estado']]=$cate['estado'];
            $opusuari[$cate['usuario_id']] = $cate['usuario'];
        }
        
        
              
       $this->setWidget('usuario', new sfWidgetFormChoice(array(
            "choices" => $opusuari,
                ), array("class" => " form-control")));
          
        $this->setWidget('estado', new sfWidgetFormChoice(array(
            "choices" => $opciones,
                ), array("class" => " form-control")));
        
          
        
        $this->setValidator('usuario', new sfValidatorString(array('required' => false)));
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}
