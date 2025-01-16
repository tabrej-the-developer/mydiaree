<?php

$GLOBALS['pdf_data']=$pass_value;


require(APPPATH.'libraries/fpdf/fpdf.php');


class PDF extends FPDF{

    function get_data(){
        $this->Cell(80);
        $this->Cell(100,20,':: Lesson Plan PDF ::',0,0,'C');
        $this->Ln(20);

        $i=1;
        foreach($GLOBALS['pdf_data'] as $pdf_key=>$pdf_value){

            $childName = $pdf_value->child_name;
            $this->PrintChapter($i,$childName,'');
            $text=str_repeat('this is a word wrap test ',1);
            $this->WordWrap($pdf_value->sub_title,120);
            
            $this->Write(5,$pdf_value->sub_title);
            $this->Ln();
            $i++;
        }
    }

    function PrintChapter($num,$title)
    {
        $this->ChapterTitle($num,$title);
    }

    function ChapterTitle($num,$label)
    {
        $this->SetFont('Arial','',12);
        $this->SetFillColor(200,220,255);
        $this->Cell(0,6," $num ) Child Name: $label",0,1,'L',1);
        $this->Ln(4);
    }



    function WordWrap(&$text, $maxwidth){
            
            $text = trim($text);
            if ($text==='')
                return 0;
            $space = $this->GetStringWidth(' ');
            $lines = explode(",", $text);
            $text = '';
            $count = 0;
                
            foreach ($lines as $line)
            {
                $words = preg_split('/ +/', $line);
                
                $width = 0;

                foreach ($words as $word)
                {
                    $wordwidth = $this->GetStringWidth($word);

                    if($width + $wordwidth <= $maxwidth)
                    {
                        
                         $width += $wordwidth + $space;
                         $text .= $word.' ';
                    }
                    else
                    {   
                         $width = $wordwidth + $space;
                         $text = rtrim($text)."\n".$word.' ';
                        $count++;
                    }
                }
                 $text = rtrim($text)."\n";
                $count++;
            }
            
            $text = rtrim($text)."\n\n";
            return $count;
    }

}


$newpdf = new PDF('P','mm','A3');

$newpdf->AliasNbPages();

$newpdf->setMargins(12, 15, 11.6);

$newpdf->AddPage();
$newpdf->SetFont('Arial','',12);

$title="Lesson PDF File $file";
$newpdf->SetTitle($title);

$newpdf->get_data();



$file=FCPATH.'uploads/pdfs/'.$file;

$newpdf->Output("F",$file,true);
?>