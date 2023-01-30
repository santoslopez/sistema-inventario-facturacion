<?php
  
  session_start();
  //Sino hemos iniciado sesion indicamos la ruta por defecto

  if (!isset($_SESSION['rolUsuario'])) {
    //header('location: admin/index.php');
    # code...
    /*switch ($_SESSION) {
        case 'value':
            # code...
            case 1:
                header('location:../admin/index.php');
            break;
        
        default:
            # code...
            break;
    }*/
  //}else  {
    header('location: ../index.php');
  }

?>

<?php

require '../fpdf184/fpdf.php';
require '../conexion.php'; //puede que no lo necesiten


//if (!isset($_GET["obtenerCodigoVentaComprobante"])) {
	//$obtenerNombreSubmodulo = "0";
	# code...
//	header("Location: ../index.php");
//}

// recuperamos el valor del submodulo
//$obtenerNombreSubmodulo = $_GET["obtenerCodigoVentaComprobante"];

	//echo "hola $obtenerNombreSubmodulo";

class PDF extends FPDF {


// Cabecera de página
	function Header() {
		$this->SetFont('Times', 'B', 14);
		$this->Image('../assets/img/logo.jpeg',175,9, 30); //imagen(archivo, png/jpg || x,y,tamaño)
		$this->setXY(60, 15);
		
		
		//$this->Cell(6,10,utf8_decode("Recibo de compra No: ".$_GET["obtenerCodigoVentaComprobante"]), 0, 1, 'L', 0);
		$this->Cell(6,10,utf8_decode("RESUMEN FACTURA DE COMPRAS"), 0, 1, 'L', 0);

		//$pdf = new PDF(); //hacemos una instancia de la clase

$textypos=5;
$this->SetFont('Times', 'B', 10);
//$this->Cell(1,1,utf8_decode("En FerroIndustrias López podrás encontrar todos los artículos que necesitas para que tu proyecto sea todo un éxito, contamos con las mejores marcas a nivel internacional para todo tipo de presupuesto."));
//$this->Cell(170, 2, utf8_decode(""), 0, 0, 'C', 0);
//$this->Cell(170,15, utf8_decode("Ventas de productos de ferretería y mejores marcas internacionales. Encuentranos en Interior Mercado el Guarda Zona 11."), 0, 0, 'C', 0);




//$this->SetFont('Arial','',10);    
//$this->setY(35);
//$this->setX(10);

// Agregamos los datos de la empresa
$this->Cell(5,$textypos,"Nota: N - significa que la factura no se ha cerrado, no aparece en el inventario y no se suma en este reporte total",0,1,'L');
$this->SetFont('Arial','B',10);    
$this->setY(30);$this->setX(10);
//$this->Cell(5,$textypos,"Redes sociales:");
//$this->SetFont('Arial','',10);    
//$this->setY(35);$this->setX(10);
//$this->Cell(5,$textypos,"facebook: FerroIndustrias Lopez");
//$this->setY(40);$this->setX(10);
//$this->Cell(5,$textypos,"WhatsApp: 4059-6836 y 4799-4812");
//$this->setY(45);$this->setX(10);



// Agregamos los datos del cliente
/*$this->SetFont('Arial','B',10);    
$this->setY(30);$this->setX(75);
$this->Cell(5,$textypos,"Datos del cliente:");
$this->SetFont('Arial','',10);    
$this->setY(35);$this->setX(75);
$this->Cell(5,$textypos,"Cliente: ");
$this->setY(40);$this->setX(75);
$this->Cell(5,$textypos,"Direccion: ");
$this->setY(45);$this->setX(75);*/

$this->Cell(5,$textypos,"Documento generado en: ".date("d/m/Y"));
$this->setY(30);$this->setX(135);
$this->setY(30);$this->setX(135);

// Agregamos los datos del cliente
/*$this->SetFont('Arial','B',10);    
$this->setY(30);$this->setX(135);
$this->Cell(5,$textypos,"RECIBO NO: ");
$this->SetFont('Arial','',10);    
$this->setY(35);
$this->setX(135);
$this->Cell(5,$textypos,"FECHA: ");
$this->setY(40);$this->setX(135);
$this->setY(50);$this->setX(135);*/



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
		$this->Cell(170, 10, 'Resumen de factura de compras', 0, 0, 'C', 0);
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
			$this->Cell(15, 8, '#', 1, 0, 'C', 0);
			$this->Cell(40, 8, 'NO. FACTURA', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'REGISTRADO', 1, 0, 'C', 0);
			$this->Cell(40, 8, 'NIT PROVEEDOR', 1, 0, 'C', 0);
			$this->Cell(30, 8, 'TOTAL COMPRA', 1, 1, 'C', 0);
			$this->Cell(30, 8, 'ESTADO', 1, 1, 'C', 0);
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
$fechaActual = date('Y-m-d');

//$conexion = $data->conect();
//$filtrarPorCodigoSubmodulo = intval($_GET["obtenerCodigoVentaComprobante"]);

//$strquery = "SELECT * FROM detallefacturaventa WHERE numerodocumentofacturaventa='$filtrarPorCodigoSubmodulo'";
$strquery = "SELECT factura.numerodocumento,factura.documentoproveedor,factura.fecharegistro,
    factura.fechafacturaproveedor, factura.nitproveedor, factura.estado,SUM(detalle.preciocompra*detalle.cantidadcomprado) AS totalcompra from facturacompra AS factura
    INNER JOIN detallefacturacompra AS detalle ON
    factura.documentoproveedor=detalle.documentoproveedor
    GROUP BY (factura.numerodocumento,factura.documentoproveedor,factura.fecharegistro,
    factura.fechafacturaproveedor, factura.nitproveedor, factura.estado)
    ORDER BY factura.numerodocumento DESC;";

pg_prepare($conexion,"queryDetalleVentasDia",$strquery) or die ("No se pudo preparar la consulta queryDetalleVentasDia");

$data = pg_execute($conexion,"queryDetalleVentasDia",array());



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
$pdf->Cell(15, 8, '#', 1, 0, 'C', 0);
$pdf->Cell(40, 8, 'NO. FACTURA', 1, 0, 'C', 0);
$pdf->Cell(30, 8, 'REGISTRADO', 1, 0, 'C', 0);
$pdf->Cell(40, 8, 'NIT PROVEEDOR', 1, 0, 'C', 0);
$pdf->Cell(30, 8, 'TOTAL', 1, 0, 'C', 0);
$pdf->Cell(30, 8, 'ESTADO', 1, 1, 'C', 0);

// -------TERMINA----ENCABEZADO------------------


//$pdf->SetFillColor(248, 252, 255); //color de fondo rgb
$pdf->SetFillColor(255,255, 255); //color de fondo rgb

$pdf->SetDrawColor(61, 61, 61); //color de linea  rgb

$pdf->SetFont('Arial', '', 10);

//El ancho de las celdas
$pdf->SetWidths(array(15,40,30,40,30,30)); //???
// esto no lo mencione en el video pero también pueden poner la alineación de cada COLUMNA!!!
$pdf->SetAligns(array('C','C','C','C','L'));

$numregs=pg_num_rows($data);


$total = 0;
// indicamos la posicion inicial de la imagen en la coordenada x
// la indicamos la posicion inicial de la imagen en la coordenada y
for ($i = 0; $i < $numregs; $i++) {
	// 	$pdf->Row(array($i + 1, pg_fetch_result($data,$i,'frase'), ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'traduccionfrase') ))), pg_fetch_result($data,$i,'imagen')), 15);
	//$posicionx=$posicionx+15;
	$pdf->Row(array(
		utf8_decode(pg_fetch_result($data,$i,'numerodocumento')),
		ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'documentoproveedor')))),
		ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'fecharegistro') ))),
		ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'nitproveedor')))),
		ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'totalcompra')))),


		ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'estado')))) 
		//ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'subtotal')))),

	) , 15);
	if (ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'estado'))))=="A") {
		# code...
	}else if (ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'estado'))))=="P") {
		$total += ucwords(strtolower(utf8_decode(pg_fetch_result($data,$i,'totalcompra') )));
	}
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
  

$pdf->Cell(320,8, 'Total: Q.'.number_format($total,2,'.',''), 0, 0, 'C', 0);

//$pdf->Cell(45, 8, 'Subtotal:', 1, 1, 'C', 0);


// cell(ancho, largo, contenido,borde?, salto de linea?)

$pdf->Output();
?>