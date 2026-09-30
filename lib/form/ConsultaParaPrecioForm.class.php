<?php
class ConsultaParaPreciosForm extends sfForm
{
    public function configure()
    {
        $usuario=sfContext::getInstance()->getUser();
        $empresaId=$usuario->getAttribute('usuario',null,'empresa');

        $opciones=array();
        $opciones['PRECIO']='Precio Venta';

        $con=Propel::getConnection();
        $sql="SELECT id,nombre FROM lista_precio WHERE empresa_id=".(int)$empresaId." AND activo=1 ORDER BY nombre";
        $stmt=$con->prepare($sql);
        $stmt->execute();
        $listas=$stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($listas as $lista){
            $opciones[$lista['id']]=$lista['nombre'];
        }

        $this->setWidget(
            'tipoprecio',
            new sfWidgetFormChoice(
                array(
                    'choices'=>$opciones,
                    'multiple'=>true,
                    'expanded'=>false
                ),
                array(
                    'class'=>'form-control',
                    'size'=>6
                )
            )
        );

        $this->setValidator(
            'tipoprecio',
            new sfValidatorChoice(
                array(
                    'choices'=>array_keys($opciones),
                    'multiple'=>true,
                    'required'=>true
                )
            )
        );

        $this->setWidget(
            'nombrebuscar',
            new sfWidgetFormInputText(
                array(),
                array(
                    'class'=>'form-control',
                    'placeholder'=>'buscar producto...'
                )
            )
        );

        $this->setValidator(
            'nombrebuscar',
            new sfValidatorString(
                array(
                    'required'=>false
                )
            )
        );

        $this->widgetSchema->setNameFormat('consulta[%s]');
    }
}