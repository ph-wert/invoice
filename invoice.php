<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	<title>Invoice</title>
</head>
<body>
<?php	
	header('Content-Type: text/html; charset=utf-8');
	
	$DB_host = "localhost";
	$DB_username = "pascal";
	$DB_password = "pascal";
	$DB_dbname = "weinstubeDB";

	$link = mysql_connect($DB_host,$DB_username, $DB_password);
	mysql_select_db($DB_dbname);
	
	$invoice_nr = 1251;
	
	$query_alllineitemsbyinvoice = 	"SELECT * 
									FROM `bestelldetails` AS bestelldetails,`artikel` AS artikel,`bestellungen` AS bestellungen,`kunden` AS kunden
									WHERE bestelldetails.ArtikelNr = artikel.ArtikelNr 
										AND bestelldetails.BestellNr = ".$invoice_nr." 
										AND bestellungen.BestellNr = bestelldetails.BestellNr 
										AND kunden.`Kunden-Nr` = bestellungen.`Kunden-Nr`";
			
	$query_invoicesum 	= 	"SELECT *, SUM( bestelldetails.Menge * bestelldetails.Einzelpreis ) AS Summe
							FROM `bestelldetails` AS bestelldetails, `artikel` AS artikel, `bestellungen` AS bestellungen, `kunden` AS kunden
							WHERE bestelldetails.ArtikelNr = artikel.ArtikelNr
								AND bestelldetails.BestellNr =".$invoice_nr."
								AND bestellungen.BestellNr = bestelldetails.BestellNr
								AND kunden.`Kunden-Nr` = bestellungen.`Kunden-Nr`";
		
	
	mysql_query("SET NAMES 'utf8'");
	$result_alllineitemsbyinvoice = mysql_query($query_alllineitemsbyinvoice,$link);								
	$result_invoicesum = mysql_query($query_invoicesum,$link);

	while($row = mysql_fetch_object($result_alllineitemsbyinvoice))
	{
	  	echo $row->KontaktNachname," - ";
		echo $row->BestellNr," - ";
		echo $row->Artikelname," - ";
		echo $row->Menge," - ";
		echo $row->Einzelpreis,"";
		echo "<br>";
	}	
	
	while($row = mysql_fetch_object($result_invoicesum))
	{
		$Summe =$row->Summe;
		$Trinkgeld = $row->Trinkgeld;
		$Gesamtsumme = $Trinkgeld + $Summe;
		$MWST = $Summe / 119 *19;
		$Netto = $Summe / 119 *100;
		echo $row->BestellNr," <br> ";
	  	echo "Summe (Brutto): ".$Summe." <br>   MWST(".$MWST.") Netto(".$Netto,") <br> ";
		echo "Tip: ".$Trinkgeld,"<br>";
		echo "Gesamtsumme:".$Gesamtsumme,"";
	}

	mysql_close($link); 
?>

</body>
</html>