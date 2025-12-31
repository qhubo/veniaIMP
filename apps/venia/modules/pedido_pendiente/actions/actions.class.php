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
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        date_default_timezone_set("America/Guatemala");
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQ->getTipoUsuario());
              
       if ($TIPO_USUARIO=='ADMINISTRADOR') {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->filterByVerificado(true)
                ->useOrdenCotizacionQuery()
                ->filterBySolicitarBodega(true)
                ->endUse()
                ->groupByOrdenCotizacionId()
                ->withColumn('sum(OrdenCotizacionDetalle.Cantidad)', 'CantidadTotal')
                ->find();
           
       } else {
        $this->detalles = OrdenCotizacionDetalleQuery::create()
                ->filterByVerificado(true)
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
