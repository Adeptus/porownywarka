<?php
	
class Application_Model_ParserSamsung {

	public function findMonitor($szukana) {	
		
		$curl1 = curl_init();
		curl_setopt($curl1, CURLOPT_URL, "http://www.samsung.com/pl/function/espsearch/searchResult.do?keywords=$szukana&amp;input_keyword=$szukana");
		curl_setopt($curl1, CURLOPT_RETURNTRANSFER, 1);
		$strona1 = curl_exec($curl1);
		curl_close($curl1);

    	$dom1 = new domDocument;
	    @$dom1->loadHTML($strona1);
	    $dom1->preserveWhiteSpace = false;

		$nazwa = array();
		$a = $dom1->getElementsByTagName('a');

		foreach ($a as $a)
		    {
			$class = $a->getAttribute('class');
			$href  = $a->getAttribute('href');

			$nazwa[$class] = $href;
	    	}		
		$nazwa2 = $nazwa['arrow_blue'];		
		$url = "$nazwa2&tab=spec";


		$curl2 = curl_init();
		curl_setopt($curl2, CURLOPT_URL, "$url");
		curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
		$strona2 = curl_exec($curl2);
		curl_close($curl2);

		$tabela = array();
	
    	$dom2 = new domDocument;
	    @$dom2->loadHTML($strona2);
	    $dom2->preserveWhiteSpace = false;

		$nazwa = $dom2->getElementsByTagName('h1');
		$tabela['nazwa'] = $nazwa->item(0)->nodeValue;

		    $rows = $dom2->getElementsByTagName('tr');
  
			foreach ($rows as $row)
			    {
				$th = $row->getElementsByTagName('th');
				$nazwa = $th->item(0)->nodeValue;
				$nazwa2 = $th->item(1)->nodeValue;
	
				$td = $row->getElementsByTagName('td');
				$wartosc = $td->item(0)->nodeValue;

				$tabela[trim($nazwa)] = trim($wartosc);
				$tabela[trim($nazwa2)] = trim($wartosc);
		    	}
			return $tabela;
			//} else echo 'dupa';
		} 
}
?> 
