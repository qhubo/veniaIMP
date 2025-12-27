<?php

/**
 * vendedor actions.
 *
 * @package    plan
 * @subpackage vendedor
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class vendedorActions extends sfActions
{
    public function executeElimina(sfWebRequest $request) {
        $modulo = 'vendedor';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = VendedorQuery::create()->findOneById($id);
            $codigo = $REGISTRO->getCodigo();
            $REGISTRO->delete();

            $con->commit();
        } catch (Exception $e) {
            $con->rollback();
            if ($e->getMessage()) {
                $this->getUser()->setFlash('error', $e->getMessage());
            }
            $this->redirect($modulo . '/index');
        }
        $this->getUser()->setFlash('eliminar', $codigo);
        $this->redirect($modulo . '/index');
    }

    public function executeIndex(sfWebRequest $request) {
        $this->titulo = "VENDEDORES";
        $this->registros = VendedorQuery::create()
                //->filterByTiendaComision(null)
                ->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'vendedor';
        $this->titulo = 'VENDEDOR';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = VendedorQuery::create()->findOneById($Id);
        $default['activo'] = true;
        $default['encargado_tienda']=false;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['codigo'] = $registro->getCodigo();
            $default['activo'] = $registro->getActivo();
            $default['tienda_comision']=$registro->getTiendaComision();
            $default['codigo_planilla']=$registro->getCodigoPlanilla();
       
            $default['encargado_tienda']=$registro->getEncargadoTienda();
       
            $default['porcentaje_comision']=$registro->getPorcentajeComision();
       
            
        }
        $this->registro = $registro;
        $this->form = new CreaVendedorForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $nuevo = new Vendedor();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setCodigoPlanilla($valores['codigo_planilla']);
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setCodigo($valores['codigo']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->setTiendaComision($valores['tienda_comision']);
                $nuevo->setEncargadoTienda($valores['encargado_tienda']);
                $nuevo->setPorcentajeComision($valores['porcentaje_comision']);
                $nuevo->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
