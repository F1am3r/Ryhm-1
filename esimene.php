<?php
	//muutujad
	$myName = "Andrus";
	$myFamilyName = "Rinde";
	
	//hindan päeva osa (võrdlemine   <  >   <=  >=   ==   !=   )
	$hourNow = date("H");
	$partOfDay = "";
	if ($hourNow < 8){
		$partOfDay = "varajane hommik";
	}
	if ($hourNow >= 8 and $hourNow < 16){
		$partOfDay = "koolipäev";
	}
	if ($hourNow > 16){
		$partOfDay = "vaba aeg";
	}
	//echo $partOfDay;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
		Andrus Rinde programmeerib veebi
	</title>
</head>
<body>
	<h1><?php echo $myName ." " .$myFamilyName; ?>, veebiprogrammeerimine</h1>
	<p>See veebileht on loodud õppetöö raames ning ei sisalda mingisugust tõsiseltvõetavat sisu!</p>
	<?php
		echo "<p>Algas PHP õppimine.</p>";
		echo "<p>Täna on ";
		echo date("d.m.Y") .", kell oli lehe avamise hetkel " .date("H:i:s");
		echo ", hetkel on " .$partOfDay .".</p>";
	?>


</body>
</html>