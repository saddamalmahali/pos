<?php 
namespace App;

use Codedge\Fpdf\Fpdf\Fpdf;
class PrintLaporan extends Fpdf{
    function Footer()
	{
		//atur posisi 1.5 cm dari bawah
		$this->SetY(-15);
		//buat garis horizontal
		$this->Line(10,$this->GetY(),283,$this->GetY());
		//Arial italic 9
		$this->SetFont('Arial','I',9);
		//nomor halaman
        $this->Cell(142,10,'(@Service Information System) Tanggal Cetak : '.date('d-m-Y'),0,0,'L');
		$this->Cell(135,10,'Halaman '.$this->PageNo().' dari {nb}',0,0,'R');
	}
}
