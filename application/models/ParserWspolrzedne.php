<?php
	
class Application_Model_ParserWspolrzedne {

	public function findWspolrzedne($adres, $miasto) {	
		
        $adresTrim = trim($adres);
        $adresReplaceSpace = str_replace(' ', '+', $adresTrim);
        $LettersToChange = array('ó', 'ż', 'ź', 'ś', 'ę', 'ą', 'ł', 'ń', 'ć');
        $LettersChanged  = array('o', 'z', 'z', 's', 'e', 'a', 'l', 'n', 'c');
        $adresWithoutPolishLetters = str_replace($LettersToChange, $LettersChanged, $adresReplaceSpace); 


		$curl1 = curl_init();
		curl_setopt($curl1, CURLOPT_URL, "http://www.zumi.pl/namapie.html?qt=&loc=$miasto%2C+$adresWithoutPolishLetters&Submit=Szukaj&cId=&sId=");
		curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
		$stronaZumi = curl_exec($curl1);
		curl_close($curl1);

    	$dom = new domDocument;
	    @$dom->loadHTML($stronaZumi);
	    $dom->preserveWhiteSpace = false;

		$szukana = array();
		$divs = $dom->getElementsByTagName('div');

		foreach ($divs as $div) {
            $script    = $div->getElementsByTagName('script');
            $szukana[] = $script->item(0)->nodeValue;
	   	}		
    
        foreach ($szukana as $text) {
            if (strpos($text, 'objDefLoc')) {
                $a = substr($text, -29);
                $letterToRemove = array(':', '"', 'y', 'x', '}');
                $wspolrzedne1 = str_replace($letterToRemove, '', $a);
                $poz = strpos($wspolrzedne1, ',');
                $dlugosc = substr($wspolrzedne1, $poz);
                $dlugosc = str_replace(',', '', $dlugosc);
                $szerokosc = substr($wspolrzedne1, 0, $poz);
                $wspolrzedne[] = "$dlugosc,$szerokosc";
                
            }
        }return $wspolrzedne[0];
    }
}
?> 
