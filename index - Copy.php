<?php
	/* echo "SELECT * FROM VIEW_EXPENSESJOINED ORDER BY EXPENSEDATE DESC<br>"; */

	$DB_SERVER = "localhost";
	$DB_USER = "pascal";
	$DB_PASSWORD = "pascal";
	$DB = "movedb";
	// include('dbcredentials.inc.php');

	$link = mysql_connect(DB_SERVER,DB_USER,DB_PASSWORD);
	mysql_select_db(DB);

	$abfrage = "SELECT * FROM `bestelldetails` AS bd,`artikel` AS art WHERE bd.ArtikelNr = art.ArtikelNr AND bd.BestellNr = 1249";
	$ergebnis = mysql_query($abfrage,$link);

	while($row = mysql_fetch_object($ergebnis))
	{
/*		echo $row->EXPENSEID," - ";
	  	echo $row->EXPENSEDATE," - ";
	  	echo $row->EXPENSECOST," - ";
	  	echo $row->SHOPNAME," - ";
	  	echo $row->COUNTRYNAME," - ";
	  	echo $row->COUNTRYSHORT," - ";
	  	echo $row->PERSONNAME, "<br>";
*/
		echo "hallo";
	}
	
	$count = 1;
	$zahl = 30;
	while($count < $zahl)
	{
	  echo $count,", ";
	  echo $DB_SERVER; 
	  $count++;
	}
//	mysql_close($link); 
?>