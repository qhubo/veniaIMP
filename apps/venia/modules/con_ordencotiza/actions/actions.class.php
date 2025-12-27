<?php

/**
 * con_ordencotiza actions.
 *
 * @package    plan
 * @subpackage con_ordencotiza
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class con_ordencotizaActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    
    
      public function executeMuestra(sfWebRequest $request)
  {
          
        $id = $request->getParameter('id');
          
          
      }
  public function executeIndex(sfWebRequest $request)
  {
            date_default_timezone_set("America/Guatemala");
      sfContext::getInstance()->getUser()->setAttribute('tab', null, 'seguridad');
        $this->registros= OrdenCotizacionQuery::create()
             ->filterByEstatus('Confirmada')
              ->orderByFecha("Desc")
              ->find();    
  }
}
