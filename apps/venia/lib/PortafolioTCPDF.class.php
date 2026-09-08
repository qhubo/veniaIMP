<?php

class PortafolioTCPDF extends sfTCPDF
{
    protected $empresa;

    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;
    }

    public function Header()
    {
        $this->SetY(5);

        $html = '
        <style>
            .titulo {
                font-size: 18px;
                font-weight: bold;
            }

            .subtitulo {
                font-size: 9px;
            }
        </style>

        <table width="100%" cellpadding="3">
            <tr>
                <td width="20%"></td>

                <td width="60%" align="center">

                    <span class="titulo">
                        PORTAFOLIO DE PRODUCTOS
                    </span>

                    <br>

                    <span class="subtitulo">
                        ' . htmlspecialchars(
                            $this->empresa
                                ? $this->empresa->getNombre()
                                : '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) . '
                    </span>

                    <br>

                    <span class="subtitulo">
                        Fecha: ' . date('d/m/Y') . '
                    </span>

                </td>

                <td width="20%"></td>
            </tr>
        </table>
        ';

        $this->writeHTML(
            $html,
            true,
            false,
            true,
            false,
            ''
        );

        // Espacio reservado para el encabezado
        $this->SetY(30);
    }
}