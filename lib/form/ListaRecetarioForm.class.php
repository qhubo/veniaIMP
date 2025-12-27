<?php


class ListaRecetarioForm extends sfForm
{
    public function configure()
    {
        $this->setWidget("Fecha", new sfWidgetFormInputText(array(), array(
            'required' => true,     "class" => "form-control datepicker",
            'data-date-format' => 'yyyy-mm-dd',
        )));
        $this->setValidator("Fecha", new sfValidatorString(array('required' => true)));
        $this->widgetSchema->setNameFormat("lista_recetario[%s]");
    }
}
