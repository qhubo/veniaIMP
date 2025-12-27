<?php

/**
 * cargas_masiva actions.
 *
 * @package    plan
 * @subpackage cargas_masiva
 * @author     Via
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class cargas_masivaActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeDeptos(sfWebRequest $request) {
        error_reporting(-1);
        $inputFileName = sfConfig::get("sf_upload_dir") . DIRECTORY_SEPARATOR . "Departamentos.xls";
        $objReader = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
        $cont = 0;
        foreach ($sheetData as $regisr) {
            $cont++;
            if ($cont > 1) {
                $paris = $regisr['A'];
                $dpto = $regisr['B'];
                $mun = $regisr['C'];
                $paisqQue = PaisQuery::create()->findOneByNombre($paris);
                if (!$paisqQue) {
                    $paisqQue = new Pais();
                    $paisqQue->setCodigoIso(substr($paris, 0, 5));
                    $paisqQue->setActivo(true);
                    $paisqQue->setNombre($paris);
                    $paisqQue->save();
                }
                $Depque = DepartamentoQuery::create()
                        ->filterByNombre($dpto)
                        ->filterByPaisId($paisqQue->getId())
                        ->findOne();
                if (!$Depque) {
                    $Depque = new Departamento();
                    $Depque->setPaisId($paisqQue->getId());
                    $Depque->setCodigo(substr($dpto, 0, 15));
                    $Depque->setNombre($dpto);
                    $Depque->setActivo(true);
                    $Depque->save();
                }
                $MUNQue = MunicipioQuery::create()
                        ->filterByDepartamentoId($Depque->getId())
                        ->filterByDescripcion($mun)
                       ->findOne();
                if (!$MUNQue) {
                    $MUNQue = new Municipio();
                    $MUNQue->setAbreviatura(substr($mun, 0, 30));
                    $MUNQue->setActivo(true);
                    $MUNQue->setDepartamentoId($Depque->getId());
                    $MUNQue->setDescripcion($mun);
                    $MUNQue->save();
                }
           }
        }
        echo "Actualizados ".$cont;
        die();
    }

}
