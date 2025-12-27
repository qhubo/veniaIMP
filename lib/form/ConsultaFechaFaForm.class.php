<?php

class ConsultaFechaFaForm extends sfForm {

    public function configure() {
           $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
     
        $this->setWidget('fechaInicio', new sfWidgetFormInputText(array(), 
                array('class' => 'form-control', 'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaInicio', new sfValidatorString(array('required' => true)));
       $this->setWidget('fechaFin', new sfWidgetFormInputText(array(), array('class' => 'form-control',
           'data-provide' => 'datepicker','data-date-format' => 'dd/mm/yyyy')));
        $this->setValidator('fechaFin', new sfValidatorString(array('required' => true)));
        
   $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);      
   $listab = TiendaQuery::TiendaActivas();
      $bodegas = TiendaQuery::create()
              ->filterByEmpresaId($usuarioQue->getEmpresaId())
                ->filterById($listab, Criteria::IN)
                ->orderByNombre()
                ->find();
        $opcionb[null]='[Todas las tiendas]';
        foreach ($bodegas as $litabo) {
            $opcionb[$litabo->getCodigo()]= $litabo->getNombre();
        }
   
        
        $this->setWidget('bodega', new sfWidgetFormChoice(array(
            "choices" => $opcionb,
                ), array("class" => " form-control")));
        
        $this->setValidator('bodega', new sfValidatorString(array('required' => false)));
        $tipoe[null]='Todos  Documentos';

        $tipoe['ERROR']='ERROR';
 $tipoe['FACTURA']='FACTURA';        
$tipoe['NOTA']='NOTA';  
        
        
                $this->setWidget('tipo', new sfWidgetFormChoice(array(
            "choices" => $tipoe,
                ), array("class" => " form-control")));
        
        $this->setValidator('tipo', new sfValidatorString(array('required' => false)));
        
        
        
$tipoUsua=  sfContext::getInstance()->getUser()->getAttribute("tipoUsuario", null, 'seguridad');
    $usuarioa=sfContext::getInstance()->getUser()->getAttribute("usuarioNombre",null, 'seguridad');             
   if ( (strtoupper($tipoUsua)=='ADMINISTRADOR') or (strtoupper($usuarioa) =='LMARTINEZ')) {
        $usuarioQ = UsuarioQuery::create()
                ->filterByActivo(true)
                ->find();
        $ListaU[]='Todos los usuarios';
        foreach ($usuarioQ  as $data) {
            $ListaU[$data->getUsuario()]=$data->getUsuario();
        }
   }
    $ListaU[$usuarioa]=$usuarioa;
        
        
        $this->setWidget('usuario', new sfWidgetFormChoice(array(
            "choices" => $ListaU,
                ), array("class" => " form-control")));
        
        $this->setValidator('usuario', new sfValidatorString(array('required' => false)));
        
 $estatusd[null]="Todos los estatus";
 $estatusd['Autorizado']="Autorizado";
 $estatusd['Rechazado']="Rechazado";
 $estatusd['Nuevo']="Nuevo";
 $estatusd['ANULADO']='Anulado';
               $this->setWidget('estatus_devolucion', new sfWidgetFormChoice(array(
            "choices" => $estatusd,
                ), array("class" => " form-control")));
        
        $this->setValidator('estatus_devolucion', new sfValidatorString(array('required' => false)));
        
        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}