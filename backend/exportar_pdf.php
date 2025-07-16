<?php
require 'conexion.php'; 
require('fpdf/fpdf.php');

class PDF extends FPDF {
    protected $logoPath = 'logo.jpg'; 

    function Header() {
        if(file_exists($this->logoPath)) {
            $this->Image($this->logoPath,10,8,25);
        }
        $this->SetFont('Arial','B',12);
        $this->SetXY(40, 15);
        $this->Cell(0,10,'Listado de Visitantes - Hotel Bogota Plaza',0,1,'L');
        $this->Ln(10);

        $this->SetFont('Arial','B',6);
        $this->Cell(8,6,'ID',1);
        $this->Cell(40,6,'Nombre',1);
        $this->Cell(18,6,'Documento',1);
        $this->Cell(12,6,'Tipo',1);
        $this->Cell(20,6,'Empresa',1);
        $this->Cell(15,6,'Telefono',1);
        $this->Cell(30,6,'Correo',1);
        $this->Cell(15,6,'Fecha Ing.',1);
        $this->Cell(10,6,'Hora Ing.',1);
        $this->Cell(15,6,'Fecha Sal.',1);
        $this->Cell(10,6,'Hora Sal.',1);
        $this->Cell(18,6,'Destino',1);
        $this->Cell(15,6,'Autoriza',1);
        $this->Cell(45,6,'Observaciones',1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial','I',6);
        $fechaExport = date('d/m/Y H:i:s');
        $this->Cell(0,6,'Exportado el: ' . $fechaExport,0,1,'L');
        $this->Cell(0,6,'© 2025 Hotel Bogota Plaza. Todos los derechos reservados.',0,1,'C');
        $this->SetY(-10);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'R');
    }
}

function NbLines($pdf, $w, $txt) {
    $maxWidth = $w - 2; // margen interno
    $words = explode(' ', $txt);
    $lines = 1;
    $currentLine = '';

    foreach ($words as $word) {
        $testLine = ($currentLine === '') ? $word : $currentLine . ' ' . $word;
        $testWidth = $pdf->GetStringWidth($testLine);
        if ($testWidth <= $maxWidth) {
            $currentLine = $testLine;
        } else {
            $lines++;
            $currentLine = $word;
        }
    }
    return $lines;
}

function MultiCellRow($pdf, $w, $h, $x, $y, $txt, $border=0, $align='L') {
    $pdf->SetXY($x, $y);
    $pdf->MultiCell($w, $h, $txt, $border, $align);
}

$widths = [
    'id' => 8,
    'nombre' => 40,
    'documento' => 18,
    'tipo' => 12,
    'empresa' => 20,
    'telefono' => 15,
    'correo' => 30,
    'fecha_ingreso' => 15,
    'hora_ingreso' => 10,
    'fecha_salida' => 15,
    'hora_salida' => 10,
    'destino' => 18,
    'autoriza' => 15,
    'observaciones' => 45
];

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',6);

// Cambia a ASC para que el primer registro sea el primero en el PDF
$sql = "SELECT * FROM visitantes ORDER BY id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Decodificar texto para UTF-8
        $nombre = utf8_decode($row['nombre_completo']);
        $observaciones = utf8_decode($row['observaciones']);
        $tipo = utf8_decode($row['tipo_visitante']);
        $empresa = utf8_decode($row['empresa']);
        $correo = $row['correo_electronico'];
        $destino = utf8_decode($row['destino']);
        $autoriza = utf8_decode($row['autoriza']);

        // Calcular líneas para Nombre y Observaciones
        $nombreLines = NbLines($pdf, $widths['nombre'], $nombre);
        $observacionesLines = NbLines($pdf, $widths['observaciones'], $observaciones);

        $lineHeight = 4;
        $maxLines = max($nombreLines, $observacionesLines, 1);
        $rowHeight = $lineHeight * $maxLines;

        $x = $pdf->GetX();
        $y = $pdf->GetY();

        // Imprimir ID
        $pdf->Cell($widths['id'], $rowHeight, $row['id'], 1);

        // Imprimir Nombre multilínea
        MultiCellRow($pdf, $widths['nombre'], $lineHeight, $pdf->GetX(), $y, $nombre, 1);
        $pdf->SetXY($x + $widths['id'] + $widths['nombre'], $y);

        // Imprimir las demás celdas con altura fija
        $pdf->Cell($widths['documento'], $rowHeight, $row['documento'], 1);
        $pdf->Cell($widths['tipo'], $rowHeight, $tipo, 1);
        $pdf->Cell($widths['empresa'], $rowHeight, $empresa, 1);
        $pdf->Cell($widths['telefono'], $rowHeight, $row['telefono'], 1);
        $pdf->Cell($widths['correo'], $rowHeight, $correo, 1);
        $pdf->Cell($widths['fecha_ingreso'], $rowHeight, $row['fecha_ingreso'], 1);
        $pdf->Cell($widths['hora_ingreso'], $rowHeight, $row['hora_ingreso'], 1);

        $fechaSalida = (!empty($row['fecha_salida']) && $row['fecha_salida'] != '0000-00-00') ? $row['fecha_salida'] : '-';

        $horaSalida = '-';
        if (isset($row['hora_salida']) && !empty($row['hora_salida']) && $row['hora_salida'] != '00:00:00') {
            $horaSalida = is_string($row['hora_salida']) ? substr($row['hora_salida'], 0, 5) : '-';
        }

        $pdf->Cell($widths['fecha_salida'], $rowHeight, $fechaSalida, 1);
        $pdf->Cell($widths['hora_salida'], $rowHeight, $horaSalida, 1);
        $pdf->Cell($widths['destino'], $rowHeight, $destino, 1);
        $pdf->Cell($widths['autoriza'], $rowHeight, $autoriza, 1);

        // Imprimir Observaciones multilínea
        MultiCellRow($pdf, $widths['observaciones'], $lineHeight, $pdf->GetX(), $y, $observaciones, 1);

        // Mover cursor a la siguiente fila
        $pdf->SetXY($x, $y + $rowHeight);
    }
} else {
    $pdf->Cell(0,10,'No hay registros disponibles.',1,1,'C');
}

$pdf->Output('D','Listado_Visitantes_'.date('Ymd_His').'.pdf');
exit;
?>
