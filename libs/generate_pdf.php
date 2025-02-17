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
        $this->Image('../assets/images/icon.png',10,-1,50);
        $this->SetFont('Arial','B',13);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(80,10,$this->title,0,0,'C');
        // Line break
        $this->Ln(40);
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

        $pdf = new PDF($title = "Receta");
        $display_heading = array('receta'=>'Receta');

        $sql = "select receta from visitas where id = {$id}";
        $result = Connection::query_arr($sql);
        $header = Connection::query_arr("SHOW columns FROM visitas");
        $header = $header[4];
        
        //header
        $pdf->AddPage();
        //foter page
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',13);
        $pdf->Cell(40,12,$display_heading["receta"],0);
        foreach($result as $row) {
            $pdf->Ln();
        foreach($row as $column)
            $pdf->Cell(60,12,$column,0,'C');
            }
        $pdf->Output();
    }

    if($type == 'citasdia'){
        $mytitle = "Citas del {$fecha}";
        $pdf = new PDF($title = $mytitle);
        $display_heading = array('title'=>'Titulo','start'=>'Fecha de inicio','end'=>'Fecha de fin');

        $sql = "select title, start, end from events where DATEDIFF(start,'{$fecha}') = 0";
        $result = Connection::query_arr($sql);
        $header = Connection::query_arr("SHOW columns FROM events");
        unset($header[0]);
        unset($header[2]);
        
        //header
        $pdf->AddPage();
        //foter page
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',13);
            
        foreach($header as $heading) {
            $pdf->Cell(60,12,$display_heading[$heading['Field']],1);
        }
        foreach($result as $row) {
            $pdf->Ln();
        foreach($row as $column)
            $pdf->Cell(60,12,$column,1);
            }
        $pdf->Output();
    }
    if($type == 'pago'){
        $mytitle = "FACTURA DE PAGO DE CONSULTA";
        $pdf = new PDF($title = $mytitle);
        $display_heading = array('title'=>'Titulo','costo'=>'Costo','monto_pagado'=>'Monto pagado', 'fecha'=>'Fecha');

        $sql = "select title, costo, monto_pagado, fecha from consultas order by id desc LIMIT 1";
        $result = Connection::query_arr($sql);
        $header = Connection::query_arr("SHOW columns FROM consultas");
        unset($header[0]);
        
        //header
        $pdf->AddPage();
        //foter page
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',13);
            
        foreach($header as $heading) {
            $pdf->Cell(50,12,$display_heading[$heading['Field']],1);
        }
        foreach($result as $row) {
            $pdf->Ln();
        foreach($row as $column)
            $pdf->Cell(50,12,$column,1);
            }
        $pdf->Output();
    }
    if($type == 'logs'){
        $pdf = new PDF($title = "Reportes del sistema");
        $display_heading = array('user_id'=>'ID Usuario','remote_addr'=>'Direccion IP', 'message'=>'Mensaje','log_date'=>'Fecha');

        $sql = "select user_id, remote_addr, message, log_date from user_log where id = {$id}";
        $result = Connection::query_arr($sql);
        $header = Connection::query_arr("SHOW columns FROM user_log");
        unset($header[0]);
        unset($header[2]);
        unset($header[4]);
        
        //header
        $pdf->AddPage();
        //foter page
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',13);
            
        foreach($header as $heading) {
            if(strpos($heading['Field'], "message") !== false || strpos($heading['Field'], "date") !== false){
                $pdf->Cell(90,12,$display_heading[$heading['Field']],1);
            }else{                
                $pdf->Cell(30,12,$display_heading[$heading['Field']],1);
            }
        }
        foreach($result as $row) {
            $pdf->Ln();
        foreach($row as $column)
            if(strlen($column) > 18){
                $pdf->Cell(90,12,$column,1);
            }else{                
                $pdf->Cell(30,12,$column,1);
            }
        }
        $pdf->Output();
    }

    if($type == 'cumple'){
        $mytitle = "Reporte de cumpleanos del {$fecha}";
        $pdf = new PDF($title = $mytitle);
        $display_heading = array('nombre'=>'Nombre','apellido'=>'Apellido','nacimiento'=>'Fecha de nacimiento', 'telefono'=>'Telefono');

        $time  = strtotime($fecha);
        $month = date('m',$time);
        $sql = "Select nombre, apellido, nacimiento, telefono from pacientes WHERE EXTRACT(MONTH FROM nacimiento) = '{$month}'";
        $result = Connection::query_arr($sql);
        $header = Connection::query_arr("SHOW columns FROM pacientes");
        unset($header[0]);
        unset($header[1]);
        unset($header[6]);
        
        //header
        $pdf->AddPage();
        //foter page
        $pdf->AliasNbPages();
        $pdf->SetFont('Arial','B',13);
            
        foreach($header as $heading) {
            $pdf->Cell(50,12,$display_heading[$heading['Field']],1);
        }
        foreach($result as $row) {
            $pdf->Ln();
        foreach($row as $column)
            $pdf->Cell(50,12,$column,1);
            }
        $pdf->Output();
    }

}
?>