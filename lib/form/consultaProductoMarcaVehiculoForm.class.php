<?php

class consultaProductoMarcaVehiculoForm extends sfForm
{
    public function configure()
    {
        $marcasVehiculo = array(
            '' => '[ TODAS LAS MARCAS ]',

            'Acura' => 'Acura',
            'Alfa Romeo' => 'Alfa Romeo',
            'Audi' => 'Audi',
            'BAIC' => 'BAIC',
            'BMW' => 'BMW',
            'BYD' => 'BYD',
            'Buick' => 'Buick',
            'Cadillac' => 'Cadillac',
            'Changan' => 'Changan',
            'Chery' => 'Chery',
            'Chevrolet' => 'Chevrolet',
            'Chrysler' => 'Chrysler',
            'Citroën' => 'Citroën',
            'Cupra' => 'Cupra',
            'Daihatsu' => 'Daihatsu',
            'Dodge' => 'Dodge',
            'Dongfeng' => 'Dongfeng',
            'DS' => 'DS',
            'FAW' => 'FAW',
            'Fiat' => 'Fiat',
            'Ford' => 'Ford',
            'Foton' => 'Foton',
            'Geely' => 'Geely',
            'Genesis' => 'Genesis',
            'GMC' => 'GMC',
            'Great Wall' => 'Great Wall',
            'Haval' => 'Haval',
            'Honda' => 'Honda',
            'Hyundai' => 'Hyundai',
            'Infiniti' => 'Infiniti',
            'Isuzu' => 'Isuzu',
            'JAC' => 'JAC',
            'Jaguar' => 'Jaguar',
            'Jeep' => 'Jeep',
            'Jetour' => 'Jetour',
            'JMC' => 'JMC',
            'Kia' => 'Kia',
            'Lada' => 'Lada',
            'Land Rover' => 'Land Rover',
            'Lexus' => 'Lexus',
            'Lincoln' => 'Lincoln',
            'Mazda' => 'Mazda',
            'Mercedes-Benz' => 'Mercedes-Benz',
            'MG' => 'MG',
            'Mini' => 'Mini',
            'Mitsubishi' => 'Mitsubishi',
            'Nissan' => 'Nissan',
            'Opel' => 'Opel',
            'Peugeot' => 'Peugeot',
            'Porsche' => 'Porsche',
            'RAM' => 'RAM',
            'Renault' => 'Renault',
            'SEAT' => 'SEAT',
            'Seres' => 'Seres',
            'Skoda' => 'Skoda',
            'Smart' => 'Smart',
            'SsangYong' => 'SsangYong',
            'Subaru' => 'Subaru',
            'Suzuki' => 'Suzuki',
            'Tesla' => 'Tesla',
            'Toyota' => 'Toyota',
            'Volkswagen' => 'Volkswagen',
            'Volvo' => 'Volvo',
            'Wuling' => 'Wuling'
        );

        $this->setWidget(
            'marcaVehiculo',
            new sfWidgetFormChoice(
                array(
                    'choices' => $marcasVehiculo
                ),
                array(
                    'class' => 'mi-selector form-control',
                    'style' => 'width:100%;'
                )
            )
        );

        $this->setValidator('marcaVehiculo', new sfValidatorChoice( array('choices' => array_keys($marcasVehiculo), 'required' => false )));
        $this->setWidget('producto', new sfWidgetFormInputText( array(), array('class' => 'form-control', 'placeholder' => 'Código SKU o nombre' )));
        $this->setValidator('producto', new sfValidatorString(array('required' => false)));
       $this->widgetSchema->setNameFormat('consulta[%s]');
    }
}