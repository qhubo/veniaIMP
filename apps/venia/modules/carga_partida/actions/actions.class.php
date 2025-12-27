<?php

/**
 * carga_partida actions.
 *
 * @package    plan
 * @subpackage carga_partida
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class carga_partidaActions extends sfActions {

    public function executeCarga(sfWebRequest $request) {
        //   $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = Partida::pobladatosPartida($id);
//        echo "<pre>";
//        print_r($datos);
//        die();
        if (!$datos['valido']) {
            $texto = $datos['pendiente'];
            $textol = implode(' , ', $texto);
            $this->getUser()->setFlash('error', 'Las siguiente columnas no fueron encontradas: ' . $textol);
            $this->redirect('carga_partida/index');
        }
        $this->redirect('carga_partida/muestra?id=' . $id);
    }

    public function executeIndex(sfWebRequest $request) {
  
    }

    public function executeMuestra(sfWebRequest $request) {
        //   $this->getResponse()->setContentType('charset=utf-8');
        $id = $request->getParameter('id');
        $this->id = $id;
        $datos = Partida::pobladatosPartida($id);
       
        $this->datos = $datos;
//       echo "<pre>";
//       print_r($datos);
//       echo "</pre>";
//       die();
//        
    }

}
