<?php
class PeriodoSubmitForm extends sfForm {

    public function configure() {
  
        
        $mes[1]='ENERO';
        $mes[2]='FEBRERO';
        $mes[3]='MARZO';
        $mes[4]='ABRIL';
        $mes[5]='MAYO';
        $mes[6]='JUNIO';
        $mes[7]='JULIO';
        $mes[8]='AGOSTO';
        $mes[9]='SEPTIEMBRE';
        $mes[10]='OCTUBRE';
        $mes[11]='NOVIEMBRE';
        $mes[12]='DICIEMBRE';
        
        $this->setWidget('periodo', new sfWidgetFormChoice(array("choices" => $mes ), array("class" => " form-control",
                    "onChange" => "this.form.submit()" )));
        $this->setValidator('periodo', new sfValidatorString(array('required' => false)));

        for ($i = 2023; $i <= 2034; $i++) {
            $ANO[$i]=$i;
        }
        
        $this->setWidget('anio', new sfWidgetFormChoice(array("choices" => $ANO ), array("class" => " form-control",
                    "onChange" => "this.form.submit()" )));
        $this->setValidator('anio', new sfValidatorString(array('required' => false)));

        
        
        $this->widgetSchema->setNameFormat('consulta[%s]');
    }

}