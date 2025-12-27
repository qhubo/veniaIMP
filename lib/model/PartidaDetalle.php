<?php

class PartidaDetalle extends BasePartidaDetalle
{
         public function save(PropelPDO $con = null) {
        $empresaId = UsuarioQuery::getEmpresaSeleccionada('PartidaDetalle');
       
        if ($this->isNew()) {
             if ($empresaId) {
            $this->setEmpresaId($empresaId);
        }

        }
        
        parent::save($con);
    }
    
    
    
}
