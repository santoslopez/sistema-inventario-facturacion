

<?php

require '../fpdf186/fpdf.php';
require '../conexion.php'; //puede que no lo necesiten


if (!isset($_GET["obtenerCodigoVentaComprobante"])) {
	//$obtenerNombreSubmodulo = "0";
	# code...
	header("Location: ../index.php");
}

// recuperamos el valor del submodulo
$obtenerNombreSubmodulo = $_GET["obtenerCodigoVentaComprobante"];


$obtenerFechaVentaComprobanteColumna=$_GET["fechaVentaComprobante"];
	//echo "hola $obtenerNombreSubmodulo";

class PDF extends FPDF {


// Cabecera de página
	function Header() {
		$this->SetFont('Times', 'B', 14);
		$this->Image('../assets/img/logo.jpeg',175,9, 30); //imagen(archivo, png/jpg || x,y,tamaño)
		$this->setXY(60, 15);
		
		
		//$this->Cell(6,10,mb_convert_encoding("Recibo de compra No: ".$_GET["obtenerCodigoVentaComprobante"]), 0, 1, 'L', 0);
		$this->Cell(6,10,mb_convert_encoding("FERROINDUSTRIAS LOPEZ", "ISO-8859-1", "UTF-8"), 0, 1, 'L', 0);

		//$pdf = new PDF(); //hacemos una instancia de la clase

$textypos=5;
$this->SetFont('Times', 'B', 10);



//$this->SetFont('Arial','',10);    
//$this->setY(35);
//$this->setX(10);

// Agregamos los datos de la empresa
$this->Cell(5,$textypos,"Interior mercado el Guarda zona 11");
$this->SetFont('Arial','B',10);    
$this->setY(30);$this->setX(10);
$this->Cell(5,$textypos,"Redes sociales:");
$this->SetFont('Arial','',10);    
$this->setY(35);$this->setX(10);
$this->Cell(5,$textypos,"facebook: FerroIndustrias Lopez");
$this->setY(40);$this->setX(10);
$this->Cell(5,$textypos,"WhatsApp: 4059-6836 y 4799-4812");
$this->setY(45);$this->setX(10);
//$this->Cell(5,$textypos,"Telefono de la empresa");
//$this->setY(50);$this->setX(10);
//$this->Cell(5,$textypos,"Email de la empresa");


// Agregamos los datos del cliente
$this->SetFont('Arial','B',10);    
$this->setY(30);$this->setX(75);
$this->Cell(5,$textypos,"DATOS DEL CLIENTE:");
$this->SetFont('Arial','',10);    
$this->setY(35);$this->setX(75);
//$this->Cell(5,$textypos,"Cliente: ".$_GET["detalle1"]);
$this->setY(40);$this->setX(75);
$this->Cell(5,$textypos,"Nombre: ".mb_convert_encoding($_GET["detalle1"], "ISO-8859-1", "UTF-8"));
$this->setY(45);$this->setX(75);
$this->Cell(5,$textypos,"Direccion: ".mb_convert_encoding($_GET["detalle2"], "ISO-8859-1", "UTF-8"));
$this->setY(45);$this->setX(75);
//$this->Cell(5,$textypos,"Telefono del cliente");
//$this->setY(50);$this->setX(75);
//$this->Cell(5,$textypos,"Email del cliente");



// Agregamos los datos del cliente
$this->SetFont('Arial','B',10);    
$this->setY(30);$this->setX(135);
$this->Cell(5,$textypos,"RECIBO NO: ".$_GET["obtenerCodigoVentaComprobante"]);
$this->SetFont('Arial','',10);    
$this->setY(35);$this->setX(135);
$this->Cell(5,$textypos,"FECHA: ".$_GET["fechaVentaComprobante"]);
$this->setY(40);$this->setX(135);
//$this->Cell(5,$textypos,"Vencimiento: 11/ENE/2020");
//$this->setY(45);$this->setX(135);
//$this->Cell(5,$textypos,"");
$this->setY(50);$this->setX(135);
//$this->Cell(5,$textypos,"");



		//$this->Cell(80, 8,"Ventas de herramientas el guarda", 0, 1, 'C', 0);

		//$this->Cell(70, 8,"Recibo de venta ".$_GET["obtenerCodigoVentaComprobante"], 0, 1, 'C', 0);
		//$this->Image('../assets/img/user.png', 150, 10, 15); //imagen(archivo, png/jpg || x,y,tamaño)
		// va ser la separacion entre la imagen y la pagina
		$this->Ln(15);
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
		$this->Cell(170, 10, 'Las mejores marcas: Toolcraft, Pretul, INGCO, Truper, BBT, Gladiator, Leo, Makita, etc.', 0, 0, 'C', 0);
		$this->Cell(25, 10, mb_convert_encoding('Página ', "ISO-8859-1", "UTF-8") . $this->PageNo() . '/{nb}', 0, 0, 'C');
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
			$this->Cell(30, 8, 'CODIGO', 1, 0, 'C', 0);
			$this->Cell(70, 8, 'DESCRIPCION', 1, 0, 'C', 0);
			$this->Cell(20, 8, 'UNIDAD', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'PRECIO', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'SUBTOTAL', 1, 1, 'C', 0);
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
date_default_timezone_set('America/Guatemala');    
//$fechaActual = date('Y-m-d');

//$conexion = $data->conect();
$filtrarPorCodigoSubmodulo = intval($_GET["obtenerCodigoVentaComprobante"]);

//$strquery = "SELECT * FROM detallefacturaventa WHERE numerodocumentofacturaventa='$filtrarPorCodigoSubmodulo'";
$strquery = "SELECT prod.codigoproducto,REPLACE(prod.descripcion, '&#039;', '''') AS descripcion,DetalleFacturaVenta.cantidadcomprado,DetalleFacturaVenta.preciocompra,(DetalleFacturaVenta.cantidadcomprado*DetalleFacturaVenta.preciocompra) AS subtotal FROM productos AS prod INNER JOIN Inventario AS inventario ON prod.codigoproducto=Inventario.codigoProducto
    
INNER JOIN DetalleFacturaVenta ON inventario.codigoProducto=DetalleFacturaVenta.codigoProducto

INNER JOIN FacturaVenta ON DetalleFacturaVenta.numerodocumentofacturaventa=FacturaVenta.numerodocumentofacturaventa

INNER JOIN Clientes ON FacturaVenta.codigocliente=Clientes.codigoCliente

WHERE FacturaVenta.fechafacturaventa=$1 AND FacturaVenta.numerodocumentofacturaventa=$2";
//$result = $conexion->prepare($strquery);
//$result->execute();
//$data = $result->fetchall(PDO::FETCH_ASSOC);

pg_prepare($conexion,"queryDetalleVentasDia",$strquery) or die ("No se pudo preparar la consulta queryDetalleVentasDia");

$data = pg_execute($conexion,"queryDetalleVentasDia",array($obtenerFechaVentaComprobanteColumna,$filtrarPorCodigoSubmodulo));



//$data = pg_query($conexion,$strquery);


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
$pdf->Cell(30, 8,mb_convert_encoding('CODIGO', "ISO-8859-1", "UTF-8"), 1, 0, 'C', 0);
$pdf->Cell(70, 8,mb_convert_encoding('DESCRIPCION', "ISO-8859-1", "UTF-8"), 1, 0, 'C', 0);
$pdf->Cell(20, 8,mb_convert_encoding('UNIDAD', "ISO-8859-1", "UTF-8"), 1, 0, 'C', 0);
$pdf->Cell(30, 8,mb_convert_encoding('PRECIO', "ISO-8859-1", "UTF-8"), 1, 0, 'C', 0);
$pdf->Cell(30, 8,mb_convert_encoding('SUBTOTAL', "ISO-8859-1", "UTF-8"), 1, 1, 'C', 0);
// -------TERMINA----ENCABEZADO------------------



//$pdf->SetFillColor(248, 252, 255); //color de fondo rgb
$pdf->SetFillColor(255,255, 255); //color de fondo rgb

$pdf->SetDrawColor(61, 61, 61); //color de linea  rgb

$pdf->SetFont('Arial', '', 10);

//El ancho de las celdas
$pdf->SetWidths(array(30,70,20, 30,30)); //???
// esto no lo mencione en el video pero también pueden poner la alineación de cada COLUMNA!!!
$pdf->SetAligns(array('C','C','C','L'));

$numregs=pg_num_rows($data);


$total = 0;
// indicamos la posicion inicial de la imagen en la coordenada x
// la indicamos la posicion inicial de la imagen en la coordenada y
for ($i = 0; $i < $numregs; $i++) {
	// 	$pdf->Row(array($i + 1, pg_fetch_result($data,$i,'frase'), ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'traduccionfrase') ))), pg_fetch_result($data,$i,'imagen')), 15);
	//$posicionx=$posicionx+15;
	$pdf->Row(array(
		ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'codigoproducto'), "ISO-8859-1", "UTF-8" ))),
		ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'descripcion'), "ISO-8859-1", "UTF-8" ))),
		ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'cantidadcomprado'), "ISO-8859-1", "UTF-8" ))),
		ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'preciocompra'), "ISO-8859-1", "UTF-8" ))),
		//ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'preciocompra')))) * ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'cantidadcomprado') ) ))  
		ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'subtotal'), "ISO-8859-1", "UTF-8" ))),

	) , 15);
    $total += ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'preciocompra'), "ISO-8859-1", "UTF-8" )))* ucwords(strtolower(mb_convert_encoding(pg_fetch_result($data,$i,'cantidadcomprado'), "ISO-8859-1", "UTF-8" )));
}
//Build table
$fill=0;
$i=0;

  

$pdf->Cell(320,8, 'Total: Q.'.number_format($total,2,'.',''), 0, 0, 'C', 0);

//$pdf->Cell(45, 8, 'Subtotal:', 1, 1, 'C', 0);


// cell(ancho, largo, contenido,borde?, salto de linea?)

$pdf->Output();
?>