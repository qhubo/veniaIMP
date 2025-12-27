<?php

/**
 * busqueda_producto actions.
 *
 * @package    plan
 * @subpackage busqueda_producto
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class busqueda_productoActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        error_reporting(-1);
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQue->getTipoUsuario());
           $sql="select id, codigo, nombre from tienda where activa_buscador=1  order by nombre, id ";
                   if ($TIPO_USUARIO <> "ADMINISTRADOR") {
                 $sql="select id, codigo, nombre from tienda where activa_buscador=1 and id not in(20,23,28)   order by nombre, id "; 
        }
     
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $resource = $stmt->execute();
        $resultBodegas =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->resultaBode =$resultBodegas;

    }

    public function executeBuscar(sfWebRequest $request) {
        error_reporting(-1);
        $q = trim($request->getParameter('q'));
        $page = (int) $request->getParameter('page', 1);
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $con = Propel::getConnection();
        $sqlexp = "select count(vi.id) as cantidad from producto vi  where id=0 and   (vi.nombre like  '%" . $q . "%'
                or vi.codigo_sku like '%" . $q . "%')";
        if (strlen($q) > 3) {
            $sqlexp = "select count(distinct(vi.id)) as cantidad from producto vi  where   (vi.nombre like  '%" . $q . "%'
                or vi.codigo_sku like '%" . $q . "%')";
        }

        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $iTotal = $result[0]["cantidad"];
        $sqlexp = "select codigo_sku,nombre , 0 as bodegas from producto vi   where id=0 and  (vi.nombre like  '%" . $q . "%'
                or vi.codigo_sku like '%" . $q . "%') group by codigo_sku   LIMIT $limit OFFSET $offset";
        if (strlen($q) > 3) {
            $sqlexp = "select codigo_sku,nombre , 0 as bodegas from producto vi   where  (vi.nombre like  '%" . $q . "%'
                or vi.codigo_sku like '%" . $q . "%') group by codigo_sku   LIMIT $limit OFFSET $offset  ";
        }
        $sql="select id, codigo, nombre from tienda where activa_buscador=1  order by nombre, id ";
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQue = UsuarioQuery::create()->findOneById($usuarioId);
        $TIPO_USUARIO = strtoupper($usuarioQue->getTipoUsuario());
        if ($TIPO_USUARIO <> "ADMINISTRADOR") {
                 $sql="select id, codigo, nombre from tienda where activa_buscador=1 and id not in(20,23,28)   order by nombre, id "; 
        }
        
        
        
        
        $con = Propel::getConnection();
        $stmt = $con->prepare($sql);
        $resource = $stmt->execute();
        $resultBodegas =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->resultaBode=$resultBodegas;
        $con = Propel::getConnection();
        $stmt = $con->prepare($sqlexp);
        $resource = $stmt->execute();
        $result =$stmt->fetchAll(PDO::FETCH_ASSOC);
        $resultados =null;
        foreach ($result as $data) {
            $dataR['codigo_sku'] = $data['codigo_sku'];
            $dataR['nombre']=$data['nombre'];
            foreach ($resultBodegas as $Bodega) {
                $sqlExistencia ="select  SUM(pe.cantidad) - SUM(IFNULL(pe.transito, 0)) existencia  from producto_existencia pe inner join "; 
                $ccodigo=trim($dataR['codigo_sku']);
                $sqlExistencia .="producto pp on pp.id =pe.producto_id where cantidad >0  and trim(codigo_sku) ='".$ccodigo."' and tienda_id =".$Bodega['id'];
                $con = Propel::getConnection();
                $equ = $con->prepare($sqlExistencia);
                $resource = $equ->execute();
                $resultExistencia =$equ->fetchAll(PDO::FETCH_ASSOC);
                $cantidad =0;
                if ($resultExistencia[0]['existencia']) {
                $cantidad =$resultExistencia[0]['existencia'];    
                }
                
                $dataR[$Bodega['id']] =$cantidad;    
                
            }
            $resultados[]=$dataR;
        }
        $this->resultados = $resultados;
        $this->total = $iTotal;
        $this->limit = $limit;
        $this->page = $page;
        $this->q = $q;
    }

}
