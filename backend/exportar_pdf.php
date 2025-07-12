<?php
require 'conexion.php'; 
require('fpdf/fpdf.php');

class PDF extends FPDF {
    protected $logoPath = 'logo.jpg'; 
    function Header() {
        if(file_exists($this->logoPath)) {
            $this->Image($this->logoPath,10,8,30);
        }
        $this->SetFont('Arial','B',14);
        $this->SetXY(45, 15);
        $this->Cell(0,10,'Listado de Visitantes - Hotel Bogota Plaza',0,1,'L');
        $this->Ln(15);

        $this->SetFont('Arial','B',8);
        $this->Cell(10,7,'ID',1);
        $this->Cell(40,7,'Nombre',1);
        $this->Cell(30,7,'Documento',1);
        $this->Cell(25,7,'Tipo',1);
        $this->Cell(40,7,'Empresa',1);
        $this->Cell(25,7,'Teléfono',1);
        $this->Cell(50,7,'Correo',1);
        $this->Cell(25,7,'Fecha Ing.',1);
        $this->Cell(20,7,'Hora Ing.',1);
        $this->Cell(25,7,'Fecha Sal.',1);
        $this->Cell(20,7,'Hora Sal.',1);
        $this->Cell(30,7,'Destino',1);
        $this->Cell(30,7,'Autoriza',1);
        $this->Cell(40,7,'Observaciones',1);
        $this->Ln();
    }

    function Footer() {
        $this->SetY(-25);
        $this->SetFont('Arial','I',8);
        $fechaExport = date('d/m/Y H:i:s');
        $this->Cell(0,7,'Exportado el: ' . $fechaExport,0,1,'L');
        $this->Cell(0,7,'© 2025 Hotel Bogota Plaza. Todos los derechos reservados.',0,1,'C');
        $this->SetY(-15);
        $this->Cell(0,10,'Página '.$this->PageNo().'/{nb}',0,0,'R');
    }
}

$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

$sql = "SELECT * FROM visitantes ORDER BY id DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pdf->Cell(10,7,$row['id'],1);
        $pdf->Cell(40,7,utf8_decode($row['nombre_completo']),1);
        $pdf->Cell(30,7,$row['documento'],1);
        $pdf->Cell(25,7,utf8_decode($row['tipo_visitante']),1);
        $pdf->Cell(40,7,utf8_decode($row['empresa']),1);
        $pdf->Cell(25,7,$row['telefono'],1);
        $pdf->Cell(50,7,$row['correo_electronico'],1);
        $pdf->Cell(25,7,$row['fecha_ingreso'],1);
        $pdf->Cell(20,7,$row['hora_ingreso'],1);

        $fechaSalida = (!empty($row['fecha_salida'])) ? $row['fecha_salida'] : '-';

        if (!empty($row['hora_salida']) && $row['hora_salida'] != '00:00:00') {
            $horaObj = DateTime::createFromFormat('H:i:s', $row['hora_salida']);
            if ($horaObj !== false) {
                $horaSalida = $horaObj->format('H:i');
            } else {
                $horaSalida = $row['hora_salida'];
            }
        } else {
            $horaSalida = '-';
        }

        $pdf->Cell(25,7,$fechaSalida,1);
        $pdf->Cell(20,7,$horaSalida,1);

        $pdf->Cell(30,7,utf8_decode($row['destino']),1);
        $pdf->Cell(30,7,utf8_decode($row['autoriza']),1);
        $pdf->Cell(40,7,utf8_decode($row['observaciones']),1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0,10,'No hay registros disponibles.',1,1,'C');
}

$pdf->Output('D','Listado_Visitantes_'.date('Ymd_His').'.pdf');
exit;
?>
