<?php

/**
 * pedido_pendiente actions.
 *
 * @package    plan
 * @subpackage pedido_pendiente
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pedido_pendienteActions extends sfActions
{

  
    public function executeConfirmar(sfWebRequest $request) {
        sfContext::getInstance()->getUser()->setAttribute('CotizacionIPendie', null, 'seguridad');
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $token = $request->getParameter('token');
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($id);
        $productos = OrdenCotizacionDetalleQuery::create()
                ->filterByOrdenCotizacionId($id)
                ->find();
        $listaPendi=null;
        foreach ($productos as $detalle) {
            if ($detalle->getProductoId()) {
//                $existencia = $detalle->getProducto()->getExistencia();
                $existencia= $detalle->getProducto()->getExistenciaBodega($ordenQ->getTiendaId());
                $cantidaSOlicita = $detalle->getCantidad();
                if ($cantidaSOlicita > $existencia) {
                  $listaPendi[]= $detalle->getDetalle();
                  $detalle->setExistenciaActual($existencia);
                  $detalle->save();
//                  $this->getUser()->setFlash('error', 'No hay existencia de ' . $cantidaSOlicita . ' para el producto seleccionado ' . $detalle->getDetalle());
//                  $this->redirect('pedido_pendiente/index?id=');
                }

                if ($existencia <= 0) {
                    $this->getUser()->setFlash('error', 'No hay existencia para el producto seleccionado ' . $detalle->getDetalle());
                    $this->redirect('pedido_pendiente/index?id=');
                }
            }
        }
        
        if ($listaPendi) {
            $detallePen = implode(",", $listaPendi);
                    sfContext::getInstance()->getUser()->setAttribute('CotizacionIPendie', $detallePen, 'seguridad');
            $this->getUser()->setFlash('error', 'No hay existencia para los producto(s) ' . $detallePen);
            $this->redirect('orden_cotizacion/nueva?codigo='.$ordenQ->getCodigo());  
        }
          

  
        sfContext::getInstance()->getUser()->setAttribute('CotizacionId', null, 'seguridad');
        if ($ordenQ) {
            $tokenGuardado = sha1($ordenQ->getCodigo());
            if ($token == $tokenGuardado) {
                $ordenQ->setSolicitarBodega(false);
                $ordenQ->setEstatus("Confirmada");
                //$ordenQ->setFecha(date('Y-m-d H:i:s'));
                $ordenQ->setToken(sha1($ordenQ->getCodigo()));
                $ordenQ->save();
                $idv = OrdenCotizacionPeer::ProcesaAutoUbicacion($ordenQ);
                $this->getUser()->setFlash('exito', 'Registro actualizado   con exito ');
                $this->redirect('pedido_pendiente/index?id=' . $idv);
            }
        }
        $this->redirect('pedido_pendiente/index');
    }
    
    
     public function executeEliminaOR(sfWebRequest $request) {
          date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
        error_reporting(-1);
        $id = $request->getParameter('id');
        $ordendet = OrdenCotizacionDetalleQuery::create()->filterByOrdenCotizacionId($id)->find();
        if ($ordendet) {
            $ordendet->delete();
        }
        $ordendet = OrdenUbicacionQuery::create()->filterByOrdenCotizacionId($id)->find();
        if ($ordendet) {
            $ordendet->delete();
        }
        $ordenQ = OrdenCotizacionQuery::create()->findOneById($id);
        if ($ordenQ) {
            $fech=date('d/m/Y H:i');
            $ordenQ->setEstatus("Rechazada");
           $ordenQ->setComentario("RECHAZADA POR USUARIO ".$usuarioQ->getUsuario()." ".$fech);
            $this->getUser()->setFlash('error', 'Registro eliminado con exito');
           
        }
        $this->redirect('pedido_pendiente/index');
    }
  public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
              
       if ($TIPO_USUARIO=='ADMINISTRADOR') {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->useOrdenCotizacionQuery()
                ->filterBySolicitarBodega(true)
                ->endUse()
                ->groupByOrdenCotizacionId()
                ->withColumn('sum(OrdenCotizacionDetalle.Cantidad)', 'CantidadTotal')
                ->find();
           
       } else {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->useOrdenCotizacionQuery()
                ->filterByUsuario($usuarioQ->getUsuario())
                ->filterBySolicitarBodega(true)
                ->endUse()
                ->groupByOrdenCotizacionId()
                ->withColumn('sum(OrdenCotizacionDetalle.Cantidad)', 'CantidadTotal')
                ->find();
       }
    }

}
