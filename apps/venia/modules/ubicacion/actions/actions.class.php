<?php

/**
 * ubicacion actions.
 *
 * @package    plan
 * @subpackage ubicacion
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ubicacionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
      $this->producto = ProductoQuery::create()->findOneById($id);
  }
    public function executeVista(sfWebRequest $request)
  {
      $id = $request->getParameter('id');
      $this->producto = ProductoQuery::create()->findOneById($id);
  }
}
