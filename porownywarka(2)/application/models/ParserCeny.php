<?php

class Application_Model_ParserCeny
{
	public function getCena($marka, $nazwa)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, "http://www.ceneo.pl/Monitory;004+s$marka~~M$nazwa");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$strona = curl_exec($curl);
		curl_close($curl);
		
    	$dom = new domDocument;
	    @$dom->loadHTML($strona);
	    $dom->preserveWhiteSpace = false;

		$table = array();
	    $bigs = $dom->getElementsByTagName('big');
		foreach ($bigs as $big)
			    {
				$strong = $big->getElementsByTagName('strong');
				$cena = $strong->item(0)->nodeValue;
				$table[] = $cena;
		    	}
		return $table[0];
	}
}
