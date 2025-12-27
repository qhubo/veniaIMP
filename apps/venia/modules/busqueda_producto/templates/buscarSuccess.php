<style>
.highlight { background: yellow; font-weight: bold; }
</style>

<table class="table table-striped">
<tr>
  <th style="font-size:20px !important;">SKU</th>
  <th style="font-size:20px !important;">Nombre</th>
  <?php foreach($resultaBode as $bo) { ?>
  <th style="text-align:center; font-size:20px !important;"><?php echo $bo['nombre'];  ?></th>
  <?php } ?>
</tr>

<?php foreach ($resultados as $r): ?>
<tr>
    <td style="font-size:20px !important;"><?php echo preg_replace("/($q)/i","<span class='highlight'>$1</span>",$r['codigo_sku']) ?></td>
    <td style="font-size:20px !important;"><?php echo preg_replace("/($q)/i","<span class='highlight'>$1</span>",$r['nombre']) ?></td>
  <?php foreach($resultaBode as $bo) { ?>
<td style="font-size:20px !important; text-align:right;  border-left: 1px solid black"> <?php  $bodeId =$bo['id']; ?><?php echo $r[$bodeId] ?> &nbsp;&nbsp;&nbsp;&nbsp; </td>
  <?php } ?>
</tr>
<?php endforeach; ?>
</table>

<?php
$pages = ceil($total / $limit);
if ($pages > 1):
?>
<nav>
<ul class="pagination">
<?php for ($i=1;$i<=$pages;$i++): ?>
<li class="page-item">
<a class="page-link" data-page="<?php echo $i ?>"><?php echo $i ?></a>
</li>
<?php endfor; ?>
</ul>
</nav>
<?php endif; ?>
