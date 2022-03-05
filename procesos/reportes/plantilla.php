<?php
require "../../public/fpdf/fpdf.php";
date_default_timezone_set("America/Monterrey");

class PDF extends FPDF{
    function header(){
        $this->AddLink();
        $this->Image('../../src/img/psique.png', 20, 10, 50, 37, '', 'www.yourjnl.space');
        $this->SetFont('Arial', 'B',18);
        $this->Cell(80);
        $this->Cell(100,10,'Consultorio',0,1,'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(80);
        $this->Cell(100,10,utf8_decode('Reporte individual'),0,1,'C');
        $this->Ln(10);
    }

    function footer(){
        $this->SetY(-18);
        $this->SetFont('Arial', 'I',12);
        $this->AddLink();
        $this->Cell(5,10,'www.yourjnl.space', 0, 0, 'L');
        $this->SetFont('Arial', '',10);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
        $this->SetFont('Arial', '',12);
        $this->Cell(0,10,date('Y-m-d H:i'),0,0,'R');
    }
}