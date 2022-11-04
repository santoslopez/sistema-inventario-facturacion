<?php

require '../fpdf184/fpdf.php';
require '../conexion.php'; //puede que no lo necesiten


if(!(isset($_GET["obtenerCodigoDocumentoProveedor"]))) {
	header('Location: ../index.php');
}else {


// recuperamos el valor del submodulo
$obtenerNombreSubmodulo = $_GET["obtenerCodigoDocumentoProveedor"];
	
class PDF extends FPDF {


// Cabecera de página
	function Header() {
		$this->SetFont('Times', 'B', 14);
		$this->Image('../assets/img/logov.png', 30, 10, 15); //imagen(archivo, png/jpg || x,y,tamaño)
		$this->setXY(60, 15);
		$this->Cell(70, 8,"Detalles de compra. Doc No:".$_GET["obtenerCodigoDocumentoProveedor"], 0, 0, 'C', 0);
		//$this->Cell(70, 8,"Detalles de compra. Doc No:".$_GET["obtenerCodigoDocumentoProveedor"], 0, 1, 'C', 1);

		$this->Image('../assets/img/user.png', 150, 10, 15); //imagen(archivo, png/jpg || x,y,tamaño)
		// va ser la separacion entre la imagen y la pagina
		$this->Ln(25);
	}

    // Formato moneda
    function SetCurrency(float $valor, string $signo = 'Q'):string
    {
        return $signo.number_format($valor,2,'.','');
    }
    


// Pie de página

	function Footer() {
		// Posición: a 1,5 cm del final
		$this->SetY(-15);

		$this->SetFont('Arial', 'B', 10);
		// Número de página
		$this->Cell(170, 10, 'Factura de compras con el proveedor', 0, 0, 'C', 0);
		$this->Cell(25, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
	}

// --------------------METODO PARA ADAPTAR LAS CELDAS------------------------------
	var $widths;
	var $aligns;

	function SetWidths($w) {
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a) {
		//Set the array of column alignments
		$this->aligns = $a;
	}

	function Row($data, $setX) //yo modifique el script a  mi conveniencia :D
	{
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++) {
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		}

		$h = 8 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h, $setX);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h, 'DF');
			//Print the text
			$this->MultiCell($w, 5, $data[$i], 0, $a);
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h, $setX) {
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			$this->AddPage($this->CurOrientation);
			$this->SetX($setX);

			//volvemos a definir el  encabezado cuando se crea una nueva pagina
			$this->SetFont('Helvetica', 'B', 10);
			$this->Cell(40, 8, 'CODIGO', 1, 0, 'C', 0);
			$this->Cell(20, 8, 'CANTIDAD', 1, 0, 'C', 0);
			$this->Cell(70, 8, 'DESCRIPCION', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'PRECIO', 1, 0, 'C', 0);
			$this->Cell(25, 8, 'SUBTOTAL:', 1, 1, 'C', 0);
			$this->SetFont('Arial', '', 10);

		}

		if ($setX == 100) {
			$this->SetX(100);
		} else {
			$this->SetX($setX);
		}

	}

	function NbLines($w, $txt) {
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0) {
			$w = $this->w - $this->rMargin - $this->x;
		}

		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n") {
			$nb--;
		}

		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
			}

			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j) {
						$i++;
					}

				} else {
					$i = $sep + 1;
				}

				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else {
				$i++;
			}

		}
		return $nl;
	}
// -----------------------------------TERMINA---------------------------------
}

//------------------OBTENES LOS DATOS DE LA BASE DE DATOS-------------------------
//$data = new Conexion();
//$conexion = $data->conect();
$filtrarPorCodigoSubmodulo = $_GET["obtenerCodigoDocumentoProveedor"];

//$strquery = "SELECT * FROM DetalleFacturaCompra WHERE documentoproveedor='$filtrarPorCodigoSubmodulo'";
$strquery="SELECT prod.codigoproducto,detallecompra.cantidadcomprado,prod.descripcion,detallecompra.preciocompra FROM productos AS prod
INNER JOIN detallefacturacompra AS detallecompra ON prod.codigoproducto=detallecompra.codigoproducto
INNER JOIN facturacompra ON detallecompra.documentoproveedor=facturacompra.documentoproveedor WHERE facturacompra.documentoproveedor=$1";

$variableNombre = "queryReporteFacturaCompra";
pg_prepare($conexion,$variableNombre,$strquery) or die ("No se pudo preparar la consulta queryReporteFacturaCompra");

$data = pg_execute($conexion,$variableNombre,array($filtrarPorCodigoSubmodulo));


/* IMPORTANTE: si estan usando MVC o algún CORE de php les recomiendo hacer uso del metodo
que se llama *select_all* ya que es el que haria uso del *fetchall* tal y como ven en la linea 161
ya que es el que devuelve un array de todos los registros de la base de datos
si hacen uso de el metodo *select* hara uso de fetch y este solo selecciona una linea*/

//--------------TERMINA BASE DE DATOS-----------------------------------------------

// Creación del objeto de la clase heredada
$pdf = new PDF(); //hacemos una instancia de la clase
$pdf->AliasNbPages();
$pdf->AddPage(); //añade l apagina / en blanco
$pdf->SetMargins(10, 10, 10); //MARGENES
$pdf->SetAutoPageBreak(true, 20); //salto de pagina automatico

// -----------ENCABEZADO------------------
$pdf->SetX(15);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(40, 8, 'CODIGO', 1, 0, 'C', 0);
$pdf->Cell(20, 8, 'CANTIDAD', 1, 0, 'C', 0);
$pdf->Cell(70, 8, 'DESCRIPCION', 1, 0, 'C', 0);
$pdf->Cell(30, 8, 'PRECIO', 1, 0, 'C', 0);
$pdf->Cell(25, 8, 'SUBTOTAL', 1, 1, 'C', 0);
// -------TERMINA----ENCABEZADO------------------



$pdf->SetFillColor(248, 252, 255); //color de fondo rgb
$pdf->SetDrawColor(61, 61, 61); //color de linea  rgb

$pdf->SetFont('Arial', '', 10);

//El ancho de las celdas
$pdf->SetWidths(array(40,20,70,30,25)); //???
// esto no lo mencione en el video pero también pueden poner la alineación de cada COLUMNA!!!
$pdf->SetAligns(array('C','C','C','C','L'));

$numregs=pg_num_rows($data);


$total = 0;
// indicamos la posicion inicial de la imagen en la coordenada x
// la indicamos la posicion inicial de la imagen en la coordenada y
for ($i = 0; $i < $numregs; $i++) {
	// 	$pdf->Row(array($i + 1, pg_fetch_result($data,$i,'frase'), ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'traduccionfrase') ))), pg_fetch_result($data,$i,'imagen')), 15);
	//$posicionx=$posicionx+15;
	$pdf->Row(array(ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'codigoproducto')))), 
	ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'cantidadcomprado') ))),
	ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'descripcion')))),
	ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'preciocompra')))),
	//ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'subtotal')))),

	ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'preciocompra') )))* ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'cantidadcomprado') )))  ) , 15);

    $total += ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'preciocompra') )))* ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'cantidadcomprado') )));
}
//Build table
$fill=0;
$i=0;
/*while($i<$numregs)
{
    $siape=pg_fetch_result($data,$i,'frase');
    $nome=pg_fetch_result($data,$i,'traduccionfrase');
    $siape1=pg_fetch_result($data,$i,'imagen');
    $nome2=pg_fetch_result($data,$i,'sonidopalabra');
    $pdf->Cell(40,8,$siape,1,0,'C',$fill);
    $pdf->Cell(40,8,$nome,1,0,'C',$fill);
    $pdf->Cell(40,8,$siape1,1,0,'C',$fill);
    $pdf->Cell(40,8,$nome2,1,1,'C',$fill);
    //$fill=!$fill;
    $i++;
}   */
    // Formato moneda

	setlocale(LC_MONETARY, 'en_US');

$totalCompra = number_format($total,2,'.','');

//$formatoTotal = money_format('%i', $totalCompra) . "\n";
$valor=NumberFormatter::create( 'es_US', NumberFormatter::DECIMAL )->format($totalCompra);

$pdf->Cell(340,8, 'Total: Q.'.$valor, 0, 0, 'C', 0);

//money_format('%i', $number)
//$pdf->Cell(45, 8, 'Subtotal:', 1, 1, 'C', 0);


// cell(ancho, largo, contenido,borde?, salto de linea?)

$pdf->Output();

}
?>