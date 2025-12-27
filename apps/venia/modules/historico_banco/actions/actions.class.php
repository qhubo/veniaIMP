<?php

/**
 * historico_banco actions.
 *
 * @package    plan
 * @subpackage historico_banco
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class historico_bancoActions extends sfActions {

    public function executeValor(sfWebRequest $request) {
        $bancoId = $request->getParameter('id');
        $valor = $request->getParameter('val');
        $tipo = $request->getParameter('tipo');
        $bancoQ = BancoTermporalQuery::create()->findOneByBancoId($bancoId);
        if (!$bancoQ) {
            $bancoQ = new BancoTermporal();
            $bancoQ->setBancoId($bancoId);
            $bancoQ->save();
        }
//        echo $tipo;
//        die();
        switch ($tipo) {
            case "saldob":
                echo 'aaaaaaaaaaaa';
                $bancoQ->setSaldoBanco($valor);
                break;
            case "dt":
                $bancoQ->setDepositoTransito($valor);
                break;
            case "nct":
                $bancoQ->setNotaCreditoTransito($valor);
                break;
            case "cc":
                $bancoQ->setChequesCirculacion($valor);
                break;
            case "nbt":
                $bancoQ->setNotaDebitoTransito($valor);
                break;
            case "saldol":
                $bancoQ->setSaldoLibros($valor);
                break;
            case "dr":
                $bancoQ->setDepositoRegistrar($valor);
                break;
            case "ncr":
                $bancoQ->setNotaCreditoRegistrar($valor);
                break;
            case "cr":
                $bancoQ->setChequesRegistrar($valor);
                break;
            case "ndr":
                $bancoQ->setNotaDebitoRegistrar($valor);
                break;
                case "ndt":
                $bancoQ->setNotaDebitoTransito($valor);
                break;
             case "fecha":
                    $fechaInicio = explode('/', $valor);
        $fechaInicio = $fechaInicio[2] . '-' . $fechaInicio[1] . '-' . $fechaInicio[0];
                $bancoQ->setFecha($fechaInicio);
                break;
        }
        $bancoQ->save();
        echo "actualizado";
        die();
    }

    public function executeIndex(sfWebRequest $request) {
        $bancoQ=null;
        $this->med = $request->getParameter('med');
        $this->bancos = BancoQuery::create()
                ->filterByActivo(true)
                ->find();

        if ($this->med) {
            $bancoQ = BancoTermporalQuery::create()->findOneByBancoId($this->med);
            if (!$bancoQ) {
                $bancoQ = new BancoTermporal();
                $bancoQ->setBancoId($this->med);
                $bancoQ->save();
            }
        }

        $this->bancoQ = $bancoQ;
    }

}
