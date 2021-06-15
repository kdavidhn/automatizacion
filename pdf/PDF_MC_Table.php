<?php
require('fpdf/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;


		
		function Header(){
        
			$this->Image('../dist/img/logo-unah.jpg', 10, 1, 60); //Insertamos el logo si es en PNG su calidad o formato debe estar entre PNG 8/PNG 24
			
			$ancho = 190; //
			$this->SetFont('times', 'B', 6); //Asignar la fuente, el estilo de la fuente (negrita) y el tamaño de la fuente
			
			//if($this->pagina == 1){ //Cuando el archivo está en Horizontal
				
				/*$horizontal = 85; //Permitirá que las dimensiones que abarca horizontalmente sea 85 puntos más que cuando es vertical
				$this->SetY(12); //Mencionamos que el curso en la posición Y empezará a los 12 puntos para escribir el Usuario:
				$this->Cell($ancho + $horizontal, 10,'', 0, 0, 'R');
				$this->SetY(15);
				$this->Cell($ancho + $horizontal, 15,'Fecha: '.date('d/m/Y'), 0, 0, 'R');
				$this->SetY(18);
				$this->Cell($ancho + $horizontal, 15,'Hora: '.date('H:i:s'), 0, 0, 'R');
				
			/*} else {
				
				$this->SetY(12); //Mencionamos que el curso en la posición Y empezará a los 12 puntos para escribir el Usuario:
				$this->Cell($ancho, 10,'', 0, 0, 'R');
				$this->SetY(15);
				$this->Cell($ancho, 15,'Fecha: '.date('d/m/Y'), 0, 0, 'R');
				$this->SetY(18);
				$this->Cell($ancho, 15,'Hora: '.date('H:i:s'), 0, 0, 'R');
				
			}*/
			
		}
		function Footer()
		{
			// Posición a 1,5 cm del final
			$this->SetY(-15);
			// Arial itálica 8
			$this->SetFont('Arial','I',8);
			// Color del texto en gris
			$this->SetTextColor(8);
			// Número de página
			$this->Cell(0,10,utf8_decode('Página').$this->PageNo(),0,0,'C');
		}

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>
