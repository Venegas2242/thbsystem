<?php

// AGREGAR FECHA DE IMPRESIÓN
// PAGINA X DE 5 POR EJEMPLO 
require('./fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('./images/logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Proveedores', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo(), 0, 0, 'C');
    }

    // Información del proveedor
    function ProveedorInfo($data)
    {
        foreach ($data as $row) {
            // Título del proveedor
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, mb_convert_encoding($row['nombrecomercial'], 'ISO-8859-1', 'UTF-8'), 0, 1);
            
            // Línea divisoria
            $this->Line(10, $this->GetY(), 200, $this->GetY());
            $this->Ln(5);
            
            // Información en columnas
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(115, 5, mb_convert_encoding('Información General', 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(75, 5, mb_convert_encoding('Información Financiera', 'ISO-8859-1', 'UTF-8'), 0, 1);
            
            $this->SetFont('Arial', '', 10);
            $this->Cell(115, 5, mb_convert_encoding('Nombre Común: ' . $row['nombrecomun'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(75, 5, mb_convert_encoding('Crédito: ', 'ISO-8859-1', 'UTF-8') . $row['credito'], 0, 1);
            
            $this->Cell(115, 5, mb_convert_encoding('Dirección: ' . $row['direccion'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(75, 5, 'Saldo: ' . $row['saldo'], 0, 1);
            
            $this->Cell(115, 5, mb_convert_encoding('RFC: ' . $row['rfc'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(75, 5, mb_convert_encoding('Días de Crédito: ', 'ISO-8859-1', 'UTF-8') . $row['diascredito'], 0, 1);
            
            $this->Cell(95, 5, mb_convert_encoding('Teléfono: ' . $row['telefono'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(95, 5, '', 0, 1);  // Espacio en blanco para alinear
            
            $this->Cell(95, 5, mb_convert_encoding('Correo: ' . $row['correo'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(95, 5, '', 0, 1);  // Espacio en blanco para alinear
            
            $this->Cell(0, 5, 'Web: ' . $row['web'], 0, 1);
            
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 5, mb_convert_encoding('Información Bancaria', 'ISO-8859-1', 'UTF-8'), 0, 1);
            
            $this->SetFont('Arial', '', 10);
            $this->Cell(95, 5, 'Banco: ' . mb_convert_encoding($row['banco'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(95, 5, 'Cuenta: ' . $row['cuenta'], 0, 1);
            
            $this->Cell(0, 5, 'CLABE: ' . $row['clabe'], 0, 1);
            
            // Añadir un espacio entre proveedores
            $this->Ln(7);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $pdf = new PDF();
    $pdf->AddPage();

    /*
    // Añadir los filtros seleccionados
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Filtros seleccionados:', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, utf8_decode('País: ' . $data['filtros']['pais']), 0, 1);
    $pdf->Cell(0, 10, utf8_decode('Estado: ' . $data['filtros']['estado']), 0, 1);
    $pdf->Cell(0, 10, utf8_decode('Ciudad: ' . $data['filtros']['ciudad']), 0, 1);
    $pdf->Ln(10);
    */

    // Añadir la información de los proveedores
    $pdf->ProveedorInfo($data['proveedores']);

    $pdf->Output('D', 'ReporteProveedores.pdf');
}
?>
