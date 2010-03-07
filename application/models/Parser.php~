<?php
	
class Application_Model_Parser {

	public function findMonitor($url) {	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "$url");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$strona = curl_exec($curl);
	curl_close($curl);
	$tabela = array();
    $dom = new domDocument;

    $dom->loadHTML($strona);

    $dom->preserveWhiteSpace = false;

	$nazwa = $dom->getElementsByTagName('h1');
	$tabela[] = $nazwa->item(0)->nodeValue;

    $tables = $dom->getElementsByTagName('table');

    $rows = $tables->item(0)->getElementsByTagName('td');
  
	foreach ($rows as $row)
	    {
		$tabela[] = $row->nodeValue;
	    }
	return $tabela;		
	}
}
?> 
