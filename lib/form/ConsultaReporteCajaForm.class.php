<?php

class ConsultaReporteCajaForm extends sfForm {

    public function configure() {
         $tipoUsu = strtoupper(sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'tipo_usuario'));
         $adminProvedo= sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'adminProveedor');
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
     
        
   $HORA['00:00']='00:00';
$HORA['00:30']='00:30';
$HORA['01:00']='01:00';
$HORA['01:30']='01:30';
$HORA['02:00']='02:00';
$HORA['02:30']='02:30';
$HORA['03:00']='03:00';
$HORA['03:30']='03:30';
$HORA['04:00']='04:00';
$HORA['04:30']='04:30';
$HORA['05:00']='05:00';
$HORA['05:30']='05:30';
$HORA['06:00']='06:00';
$HORA['06:30']='06:30';
$HORA['07:00']='07:00';
$HORA['07:30']='07:30';
$HORA['08:00']='08:00';
$HORA['08:30']='08:30';
$HORA['09:00']='09:00';
$HORA['09:30']='09:30';
$HORA['10:00']='10:00';
$HORA['10:30']='10:30';
$HORA['11:00']='11:00';
$HORA['11:30']='11:30';
$HORA['12:00']='12:00';
$HORA['12:30']='12:30';
$HORA['13:00']='13:00';
$HORA['13:30']='13:30';
$HORA['14:00']='14:00';
$HORA['14:30']='14:30';
$HORA['15:00']='15:00';
$HORA['15:30']='15:30';
$HORA['16:00']='16:00';
$HORA['16:30']='16:30';
$HORA['17:00']='17:00';
$HORA['17:30']='17:30';
$HORA['18:00']='18:00';
$HORA['18:30']='18:30';
$HORA['19:00']='19:00';
$HORA['19:30']='19:30';
$HORA['20:00']='20:00';
$HORA['20:30']='20:30';
$HORA['21:00']='21:00';
$HORA['21:30']='21:30';
$HORA['22:00']='22:00';
$HORA['22:30']='22:30';
$HORA['23:00']='23:00';
$HORA['23:30']='23:30';
        

  
        $this->setWidget('inicio', new sfWidgetFormChoice(array(
            "choices" => $HORA,
                ), array("class" => " form-control")));
        
        $this->setValidator('inicio', new sfValidatorString(array('required' => false)));
        
                $this->setWidget('fin', new sfWidgetFormChoice(array(
            "choices" => $HORA,
                ), array("class" => " form-control")));
        
        $this->setValidator('fin', new sfValidatorString(array('required' => false)));
        
      $listab = TiendaQuery::TiendaActivas();
   $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);      
      $bodegas = TiendaQuery::create()
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
        
        
        $opcionBan[null]="[Todos]";
        
        $bancoq = BancoQuery::create()
                ->orderByNombre("Desc")
                ->find();
        foreach ($bancoq as $reg) {
            $opcionBan[$reg->getId()]=$reg->getNombre();
        }
        
     $this->setWidget('banco', new sfWidgetFormChoice(array(
            "choices" => $opcionBan,
                ), array("class" => " form-control")));
        
        $this->setValidator('banco', new sfValidatorString(array('required' => false)));
        
        
      
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
        $consulta = "select  usuario,estatus as estado  from operacion  where empresa_id ='".$usuarioQue->getEmpresaId(). "' group by usuario";
        $con = Propel::getConnection();
        $stmt = $con->prepare($consulta);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (($tipoUsu == 'ADMINISTRADOR') or ( $tipoUsu == 'SUPERADMINISTRADOR')) {
        $opusuari[null]='Todos los Usuarios';
                }
        $opciones[''] = '[Todos los estados]';
        foreach ($result as $cate) {
            $opciones[$cate['estado']]=$cate['estado'];
        if (($tipoUsu == 'ADMINISTRADOR') or ( $tipoUsu == 'SUPERADMINISTRADOR')) {
            $opusuari[$cate['usuario']] = $cate['usuario'];
            }
            if ($usuarioQue->getUsuario()==$cate['usuario']) {
                   $opusuari[$cate['usuario']] = $cate['usuario']; 
            }
        }
        
      
        
                            $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
//                                     $proveedor_id = sfContext::getInstance()->getUser()->getAttribute('proveedor_id', null, 'seguridad');
//if ($proveedor_id){
//    $opusuari=null;
//      $opusuari[$usuarioId] ='Mis Ventas';
//      $adminProvedo= sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'adminProveedor');
//     if ($adminProvedo) {
//         $usuarioQ = UsuarioQuery::create()
//                 ->orderByUsuario("Desc")
//                 ->filterByProveedorId($proveedor_id)
//                 ->find();
//         foreach ($usuarioQ as $reg) {
//              $opusuari[$reg->getId()] =$reg->getUsuario();
//         }
//         
//     }
//}
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
