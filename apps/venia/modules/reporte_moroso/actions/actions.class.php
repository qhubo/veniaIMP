<?php

class reporte_morosoActions extends sfActions {

    public function executeDesbloquear(sfWebRequest $request) {
        date_default_timezone_set("America/Guatemala");
        $id = $request->getParameter('id');
        $operacionQ = OperacionQuery::create()->findOneById($id);
        $usuarioId = sfContext::getInstance()->getUser()->getAttribute('usuario', null, 'seguridad');
        $usuarioQ = UsuarioQuery::create()->findOneById($usuarioId);
        $texto = "";
        echo $operacionQ->getPermiteFacturar();

        if ($operacionQ->getPermiteFacturar()) {
            $texto = "Factura Bloqueada " . $usuarioQ->getUsuario() . " " . date('d/m/Y');
            $operacionQ->setPermiteFacturar(false);
            $operacionQ->setObservaFacturar($texto);
            $operacionQ->save();
            $this->getUser()->setFlash('exito', $texto);
            $this->redirect('reporte_moroso/index');
        }
        if (!$operacionQ->getPermiteFacturar()) {
            $texto = "Factura DESBLOQUEDA DE MOROSIDAD  " . $usuarioQ->getUsuario() . " " . date('d/m/Y');
            $operacionQ->setPermiteFacturar(true);
            $operacionQ->setObservaFacturar($texto);
            $operacionQ->save();
            $this->getUser()->setFlash('exito', $texto);
            $this->redirect('reporte_moroso/index');
        }
    }

    public function executeIndex(sfWebRequest $request) {
        $em = 6;
        if ($request->getParameter('n')) {
            $em = $request->getParameter('n');
        }
        $this->em = $em;
        $this->operaciones = OperacionQuery::create()
                ->filterByPagado(false)
                ->where("Operacion.Fecha < DATE_SUB(NOW(), INTERVAL " . $em . " MONTH)")
                ->find();
    }

}
