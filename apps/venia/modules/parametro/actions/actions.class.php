<?php

/**
 * parametro actions.
 *
 * @package    plan
 * @subpackage parametro
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class parametroActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $parametroQ = ParametroQuery::create()->findOne();
        if (!$parametroQ) {
            $parametroQ = New Parametro();
            $parametroQ->save();
        }
        $default = null;
        $default['usuario_correo'] = $parametroQ->getUsuarioCorreo();
        $default['smtp_correo'] = $parametroQ->getSmtpCorreo();
        $default['clave_correo'] = $parametroQ->getClaveCorreo();
        $default['puerto_correo'] = $parametroQ->getPuertoCorreo();
        $default['mensaje'] = $parametroQ->getBienvenida();
        $this->form = new CreaParametroForm($default);
        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter("consulta"), $request->getFiles("consulta"));
            if ($this->form->isValid()) {
                $valores = $this->form->getValues();
                $parametroQ->setUsuarioCorreo($valores['usuario_correo']);  // > com
                $parametroQ->setSmtpCorreo($valores['smtp_correo']); // => 1
                $parametroQ->setClaveCorreo($valores['clave_correo']); //] => 1$
                $parametroQ->setPuertoCorreo($valores['puerto_correo']); //] => 11
                $parametroQ->setBienvenida($valores['mensaje']); //] => 
                $parametroQ->save();
                $this->getUser()->setFlash('exito', 'Registro actualizado  con exito ');
                $this->redirect('parametro/index?id=' . $parametroQ->getId());
            }
        }
    }

}
