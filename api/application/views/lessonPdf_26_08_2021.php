<?php 

$GLOBALS['pdf_date']=$pass_value;


require(APPPATH.'libraries/fpdf/fpdf.php');

class PDF extends FPDF{

  function Table()
	   {
      $cellSize = 39.285;
			 $size = 275;
			 $leftSpaceLeftImage = 10;
			 $leftSpaceRightImage = 260;

       $print_pdf=$GLOBALS['pdf_date'];
      
       $this->SetFont('Arial','B',10);
       $this->SetFont('Arial','B',25);
       $this->Ln();
       
		   
      //Header
       $this->SetFont('Arial','B',10);
       $this->Cell(80);
       $this->Cell($cellSize,8,'Child Name',1,0,'C');
			 $this->Cell($cellSize,8,'Activity Title',1,0,'C');
       $this->Ln();

      //Value

       $this->SetFillColor(intval($color[0]),intval($color[1]),intval($color[2]));

       foreach($print_pdf as $pdf_key=>$pdf_value){
        $this->Cell(80);
        $this->Cell($cellSize,8,$pdf_value->child_name,1,0,'C');
        $this->Cell($cellSize,8,$pdf_value->sub_title,1,0,'C');
        $this->Ln();
      }
    }
}


$newpdf = new PDF('P','mm','A3');

$newpdf->setMargins(22, 25,11.6);
$newpdf->AddPage();

$newpdf->Table();

$newpdf->SetXY(0, 11);

$newpdf->SetX(12.6);

$newpdf->Cell(0,10,':: Lesson Plan PDF ::',0,0,'C');

$file=FCPATH.'uploads/pdfs/'.$file;

$newpdf->Output("F",$file,true);