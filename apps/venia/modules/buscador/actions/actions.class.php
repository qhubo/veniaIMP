<?php

/**
 * buscador actions.
 *
 * @package    plan
 * @subpackage buscador
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class buscadorActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        $this->forward('default', 'module');
    }

    public function executeTabJsProducto(sfWebRequest $r) {
        $linea = $r->getParameter('id');
        $ini = 0;
        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM producto where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $sqlexp = "SELECT count(id) as cantidad from producto  where  "
                    . " (nombre  like  '%" . $busqueda . "%' "
                    . " or codigo_sap like  '%" . $busqueda . "%'   )  ";
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];


//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select id, nombre, codigo_sap from producto where  "
                    . "(nombre like  '%" . $busqueda . "%' or codigo_sap like  '%" . $busqueda . "%') order by nombre asc  limit " . $ini . ",5";
        } else {
            $sqlexp = "select id, nombre, codigo_sap from producto  where id= -9";
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $rResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = array(
            "sEcho" => intval($r->getParameter('sEcho')),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        foreach ($rResult as $reg) {
            $row = array();
            $regid = $reg['id'];
            $codigo = $reg['codigo_sap']; // => FreEst1
            $nombre = $reg['nombre'];
            $exitencia = '';
            $url = '/index.php/nueva_oferta/producto?linea='.$linea.'&id=' . $regid;

            $row[] = '<a href="' . $url . '"><font size="-2">' . $codigo . '</font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '</font></a>';
//            $row[] = '<a href="' . $url . '">' .  number_format($precio, 2) . '</a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $exitencia . '</font></a>'; //<a href="' . $url . '"><font size="-1">' . $exitencia . '</font></a>';


            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }
    
    
    public function executeTabJsProductoPro(sfWebRequest $r) {
        $linea = $r->getParameter('id');
        $ini = 0;
        if ($r->getParameter('iDisplayStart')) {
            $ini = $r->getParameter('iDisplayStart');
        }
        $sqlexp = "SELECT count(id) as cantidad FROM producto where id=-1";
        $empresaId = sfContext::getInstance()->getUser()->getAttribute("usuario", null, 'empresa');
        if ($r->getParameter('sSearch') != "") {
            $busqueda = $r->getParameter('sSearch');
            $sqlexp = "SELECT count(id) as cantidad from producto  where  "
                    . " (nombre  like  '%" . $busqueda . "%' "
                    . " or codigo_sap like  '%" . $busqueda . "%'   )  ";
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];


//    $query = new ProductoQuery();
        if ($r->getParameter('sSearch') != "") {
            $sqlexp = "select id, nombre, codigo_sap from producto where  "
                    . "(nombre like  '%" . $busqueda . "%' or codigo_sap like  '%" . $busqueda . "%') order by nombre asc  limit " . $ini . ",5";
        } else {
            $sqlexp = "select id, nombre, codigo_sap from producto  where id= -9";
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $rResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = array(
            "sEcho" => intval($r->getParameter('sEcho')),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iTotal,
            "aaData" => array()
        );
        foreach ($rResult as $reg) {
            $row = array();
            $regid = $reg['id'];
            $codigo = $reg['codigo_sap']; // => FreEst1
            $nombre = $reg['nombre'];
            $exitencia = '';
            $url = '/index.php/autoriza_oferta/producto?linea='.$linea.'&id=' . $regid;

            $row[] = '<a href="' . $url . '"><font size="-2">' . $codigo . '</font></a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $nombre . '</font></a>';
//            $row[] = '<a href="' . $url . '">' .  number_format($precio, 2) . '</a>';
            $row[] = '<a href="' . $url . '"><font size="-1">' . $exitencia . '</font></a>'; //<a href="' . $url . '"><font size="-1">' . $exitencia . '</font></a>';


            $output["aaData"][] = $row;
        }
        $this->renderText(json_encode($output));
        return sfView::NONE;
    }

}
