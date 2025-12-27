<?php

class ConsultaFechaUsuarioEstadoForm extends sfForm {

    public function configure() {
        
         $adminProvedo= sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'adminProveedor');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
     
      $listab = BodegaQuery::BodegaActivas();  
   $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);      
      $bodegas = BodegaQuery::create()
              ->filterByEmpresaId($usuarioQue->getEmpresaId())
                ->filterById($listab, Criteria::IN)
                ->orderByNombre()
                ->find();
        $opcionb[null]='[Todas las tiendas]';
        foreach ($bodegas as $litabo) {
            $opcionb[$litabo->getId()]= $litabo->getNombre();
        }
   
        $this->setWidget('bodega', new sfWidgetFormChoice(array(
            "choices" => $opcionb,
                ), array("class" => " form-control")));
        
        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));
        
        $opciones[''] = '[Todos los estados]';
        $opcionesP['Pago']='Pago';
        $opcionesP['Inicio']='Inicio';
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
        $empresaId=   sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        $consulta = "select  usuario,estado  from operacion  where empresa_id ='".$usuarioQue->getEmpresaId(). "' group by usuario";
        $con = Propel::getConnection();
        $stmt = $con->prepare($consulta);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $opusuari[null]='Todos los Usuarios';
        $opciones[''] = '[Todos los estados]';
        foreach ($result as $cate) {
            $opciones[$cate['estado']]=$cate['estado'];
            $opusuari[$cate['usuario']] = $cate['usuario'];
        }
        
                $opciones['Anulado']='Anulado';
        
                            $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
                                     $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad');
if ($proveedor_id){
    $opusuari=null;
      $opusuari[$usuarioId] ='Mis Ventas';
      $adminProvedo= sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'adminProveedor');
     if ($adminProvedo) {
         $usuarioQ = UsuarioQuery::create()
                 ->orderByUsuario("Desc")
                 ->filterByProveedorId($proveedor_id)
                 ->find();
         foreach ($usuarioQ as $reg) {
              $opusuari[$reg->getId()] =$reg->getUsuario();
         }
         
     }
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
