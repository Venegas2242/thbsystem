<?php
date_default_timezone_set("America/Mexico_City");
require('./fpdf186/fpdf.php');

class PDF extends FPDF
{
    // Propiedad para almacenar el total de páginas y el tipo de reporte
    public $totalPages;
    public $reportType;

    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('./images/logo.png', 10, 6, 30);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de ' . $this->reportType, 0, 1, 'C');
        $this->Ln(10);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        
        // Total de páginas
        $pageNo = $this->PageNo();
        $totalPages = $this->totalPages;
        $this->Cell(0, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $pageNo . " de $totalPages", 0, 0, 'C');
        
        // Fecha y hora
        $this->SetY(1); // Colocar -10 para poner en la esquina inferior derecha
        $dateTime = date('d-m-Y H:i:s');
        $this->Cell(0, 10, 'Generado: ' . $dateTime, 0, 0, 'R');
    }

    // Información del proveedor o cliente
    function ProveedorInfo($data)
    {
        foreach ($data as $row) {
            // Título del proveedor o cliente
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, mb_convert_encoding($row['nombrecomercial'], 'ISO-8859-1', 'UTF-8'), 0, 1);
            
            // Línea divisoria
            $this->Line(10, $this->GetY(), 200, $this->GetY());
            $this->Ln(5);
            
            // Información en columnas
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 5, mb_convert_encoding('Información General', 'ISO-8859-1', 'UTF-8'), 0, 1);
            
            $this->SetFont('Arial', '', 10);
            $this->Cell(0, 5, mb_convert_encoding('Nombre Común: ' . $row['nombrecomun'], 'ISO-8859-1', 'UTF-8'), 0, 1);
            $this->Cell(0, 5, mb_convert_encoding('Dirección: ' . $row['direccion'], 'ISO-8859-1', 'UTF-8'), 0, 1);
            $this->Cell(0, 5, mb_convert_encoding('RFC: ' . $row['rfc'], 'ISO-8859-1', 'UTF-8'), 0, 1);
            $this->Cell(0, 5, mb_convert_encoding('Teléfono: ' . $row['telefono'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(0, 5, '', 0, 1);  // Espacio en blanco para alinear        
            $this->Cell(0, 5, mb_convert_encoding('Correo: ' . $row['correo'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(0, 5, '', 0, 1);  // Espacio en blanco para alinear
            $this->Cell(0, 5, 'Web: ' . $row['web'], 0, 1);
            
            $this->Ln(3);

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(95, 5, mb_convert_encoding('Información Bancaria', 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(95, 5, mb_convert_encoding('Información Financiera', 'ISO-8859-1', 'UTF-8'), 0, 1);
            
            $this->SetFont('Arial', '', 10);
            $this->Cell(95, 5, 'Banco: ' . mb_convert_encoding($row['banco'], 'ISO-8859-1', 'UTF-8'), 0, 0);
            $this->Cell(95, 5, mb_convert_encoding('Crédito: ', 'ISO-8859-1', 'UTF-8') . $row['credito'], 0, 1);

            $this->Cell(95, 5, 'Cuenta: ' . $row['cuenta'], 0, 0);
            $this->Cell(95, 5, 'Saldo: ' . $row['saldo'], 0, 1);
            
            $this->Cell(95, 5, 'CLABE: ' . $row['clabe'], 0, 0);
            $this->Cell(95, 5, mb_convert_encoding('Días de Crédito: ', 'ISO-8859-1', 'UTF-8') . $row['diascredito'], 0, 1);

            $this->Ln(5);

            // Información de contactos
            if (!empty($row['contactos'])) {
                $this->SetFont('Arial', 'B', 12);
                $this->Cell(0, 5, mb_convert_encoding('Contactos', 'ISO-8859-1', 'UTF-8'), 0, 1);
                $this->SetFont('Arial', '', 10);

                foreach ($row['contactos'] as $contacto) {
                    if ($contacto['contacto'] === 'Sin contactos') {
                        $this->Cell(0, 5, mb_convert_encoding('Sin contactos', 'ISO-8859-1', 'UTF-8'), 0, 1);
                    } else {
                        $this->SetFont('Arial', 'B', 10);
                        $this->Cell(95, 5, mb_convert_encoding($contacto['contacto'], 'ISO-8859-1', 'UTF-8') . "\n", 0, 1);
                        $this->SetFont('Arial', '', 10);
                        $this->Cell(95, 5, mb_convert_encoding('Teléfono: ' . $contacto['contacto_telefono'], 'ISO-8859-1', 'UTF-8'), 0, 0);
                        $this->Cell(95, 5, mb_convert_encoding('Celular: ' . $contacto['contacto_celular'], 'ISO-8859-1', 'UTF-8'), 0, 1);
                        $this->Cell(95, 5, mb_convert_encoding('Email: ' . $contacto['contacto_email'], 'ISO-8859-1', 'UTF-8'), 0, 1);
                        $this->MultiCell(0, 5, mb_convert_encoding('Comentarios: ' . $contacto['contacto_comentarios'], 'ISO-8859-1', 'UTF-8'), 0, 1);
                        $this->Ln(2);
                    }
                }
            }

            // Añadir un espacio entre proveedores
            $this->Ln(3);
        }
    }

    // Contar el número total de páginas
    function calculateTotalPages($data)
    {
        $this->totalPages = 0;
        $this->AddPage();
        $this->ProveedorInfo($data);
        $this->totalPages = $this->PageNo();
    }
}

// Generar el PDF y luego actualizar el total de páginas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Determinar el tipo de reporte desde los datos recibidos
    $reportType = !empty($data['tipo']) ? $data['tipo'] : 'Proveedores';

    // Crear el PDF para contar las páginas
    $pdf = new PDF();
    $pdf->reportType = $reportType;
    $pdf->calculateTotalPages($data['proveedores']);
    $totalPages = $pdf->totalPages;

    // Generar el PDF final con el total de páginas
    $pdf = new PDF();
    $pdf->reportType = $reportType;
    $pdf->totalPages = $totalPages;
    $pdf->AddPage();
    $pdf->ProveedorInfo($data['proveedores']);
    
    $pdf->Output('D', 'Reporte' . $reportType . '.pdf');
}
?>
