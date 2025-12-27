<?php

/**
 * pro_ordencompra actions.
 *
 * @package    plan
 * @subpackage pro_ordencompra
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class pro_ordencompraActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        sfContext::getInstance()->getUser()->setAttribute('tab', null, 'seguridad');
        $this->registros = OrdenProveedorQuery::create()
                ->filterByEstatus('Autorizado')
                ->filterByDespacho(false)
                ->orderByFecha("Desc")
                ->find();
    }

}
