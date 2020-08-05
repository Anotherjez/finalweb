<?php

define('FPDF_FONTPATH','../assets/font');
include_once('fpdf.php');
include_once('utils.php');

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../assets/images/icon.png',10,-1,70);
        $this->SetFont('Arial','B',13);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(80,10,'Receta',1,0,'C');
        // Line break
        $this->Ln(20);
    }
    
    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}
 
if($_POST){

    foreach($_POST as &$value){
        $value = addslashes($value);
    }        
    
    extract($_POST);

    // Este if es para diferenciarlo de los demas reportes
    if($type == 'receta'){
        $display_heading = array('receta'=>'Receta');
    
        $sql = "select receta from visitas where id = {$id}";
        $result = Connection::query_arr($sql);
        $header = Connection::query_arr("SHOW columns FROM visitas");
        $header = $header[4];
    }
    var_dump($header);
    $pdf = new PDF();
    //header
    $pdf->AddPage();
    //foter page
    $pdf->AliasNbPages();
    $pdf->SetFont('Arial','B',12);
    foreach($header as $heading) {
        $pdf->Cell(40,12,$display_heading[$heading['Field']],1);
    }
    foreach($result as $row) {
        $pdf->Ln();
        foreach($row as $column)
        $pdf->Cell(40,12,$column,1);
    }
    $pdf->Output();
}
?>