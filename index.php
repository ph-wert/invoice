<?php Header("Content-Type: text/html; charset=utf-8")?>
<?php
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
		echo $row->BestellNr," - ";
	  	echo "Summe: ".$row->Summe," - ";
	}

	mysql_close($link); 
?>