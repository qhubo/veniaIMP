<?php

/**
 * medio_pago actions.
 *
 * @package    plan
 * @subpackage medio_pago
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class medio_pagoActions extends sfActions
{
 public function executeElimina(sfWebRequest $request) {
        $modulo = 'medio_pago';
        $id = $request->getParameter('id');
        // die('a');
        $con = Propel::getConnection();
        $con->beginTransaction();
        try {
            $REGISTRO = MedioPagoQuery::create()->findOneById($id);
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
        $this->titulo = "MEDIO PAGO";
        $this->registros = MedioPagoQuery::create()->find();
    }

    public function executeMuestra(sfWebRequest $request) {
        $modulo = 'medio_pago';
        $this->titulo = 'MEDIO PAGO';
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        sfContext::getInstance()->getUser()->setAttribute('usuario', null, 'nivel');
        $Id = $request->getParameter('id'); //=155555& 
        $this->id = $Id;
        $default = null;
        $registro = MedioPagoQuery::create()->findOneById($Id);
        $default['activo'] = true;
        if ($registro) {
            $default['nombre'] = $registro->getNombre();
            $default['orden'] = $registro->getOrden();
            $default['cuenta_contable'] = trim($registro->getCuentaContable());
             $default['aplica_mov_banco'] = $registro->getAplicaMovBanco();
             $default['retiene_isr']=$registro->getRetieneIsr();
            $default['activo'] = $registro->getActivo();
            $default['pos'] = $registro->getPos();
            $default['banco']=$registro->getBancoId();
            $default['pide_banco']=$registro->getPideBanco();
            $default['pago_proveedor']=$registro->getPagoProveedor();
            
            
        }
//        echo  "<pre>";
//        print_r($default);
//        die();
        $this->registro = $registro;
        $this->form = new CreaMedioPagoForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
//                echo "<pre>";
//                print_r($valores);
//                die();
                $nuevo = new MedioPago();
                if ($registro) {
                    $nuevo = $registro;
                }
                $nuevo->setNombre($valores['nombre']);
                $nuevo->setCuentaContable($valores['cuenta_contable']);
                $nuevo->setOrden($valores['orden']);
                $nuevo->setActivo($valores['activo']);
                $nuevo->setAplicaMovBanco($valores['aplica_mov_banco']);
                $nuevo->setPos($valores['pos']);
                $nuevo->setRetieneIsr($valores['retiene_isr']);
                $nuevo->setBancoId(null);
                $nuevo->setPideBanco($valores['pide_banco']);
                $nuevo->setPagoProveedor($valores['pago_proveedor']);
                if ($valores['banco']) {
                $nuevo->setBancoId($valores['banco']);
                }
                $nuevo->save();

                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect($modulo . '/muestra?id=' . $nuevo->getId());
            }
        }
    }

}
