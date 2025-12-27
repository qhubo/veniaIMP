<?php

/**
 * reprote_nota actions.
 *
 * @package    plan
 * @subpackage reprote_nota
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class reprote_notaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
     public function executeIndex(sfWebRequest $request) {
               error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $this->vendedores = VendedorQuery::create()->orderByNombre()->find();
        $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
         $this->TIPO_USUARIO = strtoupper($usuarioQue->getTipoUsuario()); 
        $bodegaId = null;
        if ($usuarioQue) {
            $bodegaId = $usuarioQue->getTiendaId();
        }
        if (!$valores) {
            $valores['fechaInicio'] = date('d/m/Y');
            $valores['fechaFin'] = date('d/m/Y');
            $valores['usuario'] = null;
            $valores['estatus_op']='Procesados';
//            $tipoUsuario = sfContext::getInstance()->getUser()->getAttribute('tipoUsuario', null, 'seguridad');
//            if ($tipoUsuario <> 'ADMINISTRADOR') {
            $valores['usuario'] = $usuarioId;
//            }
//            $valores['estado'] = 'Pagado';
//            $valores['tipo_fecha'] = 'Pago';
            $valores['bodega'] = $bodegaId;
            sfContext::getInstance()->getUser()->setAttribute('seleccioventa', serialize($valores), 'consulta');
        }
        $this->form = new ConsultaFechaForm($valores);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter('consulta'));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                sfContext::getInstance()->getUser()->setAttribute('seleccioventa', serialize($valores), 'consulta');
                $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
                  $this->redirect('reprote_nota/index?id=1');
            }
        }


        $this->operaciones = $this->datos($valores);
        //  die();
    }
    
      public function datos($valores) {
        // $valores = unserialize(sfContext::getInstance()->getUser()->getAttribute('seleccioventa', null, 'consulta'));
        $fechaInicio = $valores['fechaInicio'];
        $fechaInicio = explode('/', $fechaInicio);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
        $fechaFin = $valores['fechaFin'];
        $fechaFin = explode('/', $fechaFin);
        $fechaFin = $fechaFin[2] . '-' . $fechaFin[1] . '-' . $fechaFin[0];
        //    $usuariof = $valores['usuario'];
//        $tipo_fecha = $valores['tipo_fecha'];
        $bodega = $valores['bodega'];
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);

//        $empresaId = $usuarioQue->getEmpresaId();
        $empresq = EmpresaQuery::create()->findOne();

        $operaciones = OperacionQuery::create();

        //    $operaciones->filterByClienteId(null, Criteria::NOT_EQUAL);

        $listab = TiendaQuery::TiendaActivas(); // ctivas();
        $operaciones->where("Operacion.Fecha >= '" . $fechaInicio . " 00:00:00" . "'");
        $operaciones->where("Operacion.Fecha <= '" . $fechaFin . " 23:59:00" . "'");
        $operaciones->filterByFaceEstado('FIRMADONOTA');
               
//        if ($usuariof) {
//            $operaciones->filterByUsuario($usuarioQue->getUsuario());
//        }
//        if ($valores['estado']) {
//            $operaciones->filterByEstado($valores['estado']);
//        }
   
        
        if ($bodega) {
            $operaciones->filterByTiendaId($bodega);
        } else {
            $operaciones->filterByTiendaId($listab, Criteria::IN);
        }

        $operaciones->filterByEmpresaId($usuarioQue->getEmpresaId());
        $operaciones = $operaciones->find();

        return $operaciones;
    }

    public function textobusqueda($valores) {
        $textoBusqueda = '';
        $Busqueda = null;

        foreach ($valores as $clave => $valor) {
            $clave = trim(strtoupper($clave));
//            echo $clave;
//            echo "<br>";
            if ($valor) {
                if ($clave == 'FECHAINICIO') {
                    $Busqueda[] = 'DEL ' . $valor;
                }
                if ($clave == 'FECHAFIN') {
                    $Busqueda[] = ' AL  ' . $valor;
                }
                if ($clave == 'USUARIO') {
                    $query = UsuarioQuery::create()->findOneById($valor);
                    if ($query) {
                        $valor = $query->getUsuario();
                    }
                    $Busqueda[] = ' USUARIO: ' . $valor;
                }
                if ($clave == 'ESTADO') {
                    $Busqueda[] = ' ESTADO: ' . $valor;
                }
            }
        }
        if ($Busqueda) {
            $textoBusqueda = implode(",", $Busqueda);
        }
        return $textoBusqueda;
    }

}
