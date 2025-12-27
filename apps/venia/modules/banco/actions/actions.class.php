<?php

/**
 * banco actions.
 *
 * @package    plan
 * @subpackage banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class bancoActions extends sfActions {

    public function executeElimina(sfWebRequest $request) {
        $modulo = 'banco';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = BancoQuery::create()->findOneById($id);
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
        $this->titulo = "BANCOS";
        $this->registros = BancoQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'banco';
        $this->titulo = 'BANCO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = BancoQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['tipo'] = $registro->getTipoBanco();
            $default['cuenta'] = $registro->getCuenta();
            $default['activo'] = $registro->getActivo();
            $default['dolares'] = $registro->getDolares();
            $default['banco'] = $registro->getNombreBancoId();
            $default['cuenta_contable'] = $registro->getCuentaContable();
            $default['observaciones'] = $registro->getObservaciones();
            $default['pago_cheque']=$registro->getPagoCheque();
            
        }
        $this->registro = $registro;
        $this->form = new CreaBancoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new Banco();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setCuenta($valores['cuenta']);
                $nuevo->setTipoBanco($valores['tipo']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->setPagoCheque($valores['pago_cheque']);
                $nuevo->setCuentaContable($valores['cuenta_contable']);
                $nuevo->setNombreBancoId($valores['banco']);
                $nuevo->setObservaciones($valores['observaciones']);
                 $nuevo->setDolares($valores['dolares']);
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
