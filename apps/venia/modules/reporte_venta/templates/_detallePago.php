
            <br>
          
                 <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><span class="kt-font-bold kt-font-success">Tipo</span></th>
                        <th  ><span class="kt-font-bold kt-font-success">Documento</span></th>
                        <th width="60px" align="center"><span class="kt-font-bold kt-font-success">Valor</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $totalP=0; ?>
                <?php foreach ($pagos as $reg) { ?>
                    <?php $totalP =$reg->getValor()+$totalP; ?>
                          
                    <tr>
                        <td><?php echo strtoupper($reg->getTipo()); ?></td>
                         <td><?php echo $reg->getDocumento(); ?></td>
                <td aling="right"><?php echo number_format($reg->getValor(),2); ?></td>
                            
                    </tr>
          
                <?php } ?>
                    
                </tbody>
                       <tr>
                        <td colspan="2" align="right"> <strong>TOTAL</strong></td>
                        <td align="right"><?php echo number_format($totalP,2); ?></td>
                
                    </tr>
                 </table>