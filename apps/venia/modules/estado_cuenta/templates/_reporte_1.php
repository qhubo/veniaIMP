  <style>
    /* --- Layout general --- */
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
      color: #111;
      margin: 20px;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
    }

    /* --- Cabecera (logo / info) --- */
    .header-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 12px;
    }
    .header-table td {
      vertical-align: middle;
    }
    .logo {
      width: 160px;
      text-align: left;
    }
    .company-info {
      text-align: left;
      padding-left: 12px;
    }
    .meta {
      text-align: right;
      vertical-align: top;
      font-size: 12px;
    }

    .company-name {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 4px;
    }
    .small {
      font-size: 11px;
      color: #333;
    }

    /* --- Tabla detalle --- */
    table.detail {
      width: 100%;
      border-collapse: collapse;
      margin-top: 8px;
      page-break-inside: auto;
    }
    table.detail thead {
      background: #f2f2f2;
    }
    table.detail th,
    table.detail td {
      border: 1px solid #cfcfcf;
      padding: 6px 8px;
      text-align: left;
      vertical-align: top;
      font-size: 12px;
    }
    table.detail th {
      font-weight: 600;
      text-align: left;
    }

    /* Alineaciones por tipo */
    .text-right { text-align: right; }
    .text-center { text-align: center; }

    /* Repetir encabezado en cada página al imprimir */
    thead { display: table-header-group; }
    tfoot { display: table-footer-group; }

    /* Evitar cortar filas entre páginas */
    tr { page-break-inside: avoid; page-break-after: auto; }

    /* Pie de página impreso (si lo deseas) */
    .footer {
      margin-top: 16px;
      font-size: 11px;
      color: #444;
    }

    /* Opciones de impresión */
    @media print {
      body { margin: 10mm; }
      .container { max-width: 100%; }
      /* ocultar elementos no deseados en impresión si existen */
      a, .no-print { display: none !important; }
    }

    /* Pequeño estilo para filas de totales */
    .totales {
      font-weight: 700;
      background: #fafafa;
    }
  </style>

  <div class="container">
    <!-- CABECERA: logo / empresa - cliente - fecha inicial -->
    <table class="header-table">
      <tr>
        <td class="logo">
          <!-- Cambia src por la ruta o data URI de tu logo -->

        </td>
        <td class="company-info">
          <div class="company-name">Nombre de la Empresa S.A.</div>
          <div class="small">Dirección de la empresa · Tel: (502) 1234-5678 · NIT: 1234567-8</div>
        </td>
        <td class="meta">
          <!-- Datos dinámicos: Cliente y Fecha inicial -->
          <div><strong>Cliente:</strong> Nombre Cliente</div>
          <div><strong>Fecha inicial:</strong> 01/09/2025</div>
          <div style="margin-top:6px;"><strong>Reporte:</strong> Estado de Cuenta</div>
        </td>
      </tr>
    </table>

    <!-- DETALLE: tabla principal -->
    <table class="detail" role="table" aria-label="Detalle de movimientos">
      <thead>
        <tr>
          <th style="width:12%;">Documento</th>
          <th style="width:12%;">Fecha</th>
          <th style="width:12%;" class="text-right">Cargo</th>
          <th style="width:12%;" class="text-right">Abono</th>
          <th style="width:12%;" class="text-right">Saldo</th>
          <th>Descripción</th>
        </tr>
      </thead>

      <tbody>
        <!--
          Reemplaza estas filas de ejemplo por tus datos.
          Asegúrate de formatear números con dos decimales y fechas en el formato deseado.
        -->
        <tr>
          <td>FAC-001</td>
          <td class="text-center">01/09/2025</td>
          <td class="text-right">1,984.50</td>
          <td class="text-right">0.00</td>
          <td class="text-right">1,984.50</td>
          <td>Venta de productos - Factura 1</td>
        </tr>

        <tr>
          <td>REC-100</td>
          <td class="text-center">05/09/2025</td>
          <td class="text-right">0.00</td>
          <td class="text-right">1,000.00</td>
          <td class="text-right">984.50</td>
          <td>Recibo de pago parcial</td>
        </tr>

        <tr>
          <td>FAC-002</td>
          <td class="text-center">12/09/2025</td>
          <td class="text-right">750.00</td>
          <td class="text-right">0.00</td>
          <td class="text-right">1,734.50</td>
          <td>Venta adicional</td>
        </tr>

        <!-- Añade más filas según necesites -->
      </tbody>

      <tfoot>
        <tr class="totales">
          <td colspan="2">Totales</td>
          <td class="text-right">2,734.50</td>
          <td class="text-right">1,000.00</td>
          <td class="text-right">1,734.50</td>
          <td></td>
        </tr>
      </tfoot>
    </table>

    <div class="footer">
      <div>Observaciones: ........................................................................................................</div>
      <div style="margin-top:8px;">Firma: ____________________________________________</div>
    </div>
  </div>
