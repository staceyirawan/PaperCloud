<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PaperController extends Controller
{
	/* Convert XML data to JSON */
    public function getJSONFromXML($xml) {
    	$xml = new \SimpleXMLElement($xml->getBody());
    	$xml = simplexml_load_string($xml->asXML(), 'SimpleXMLElement', LIBXML_NOCDATA);
    	$json = json_encode($xml);
    	$json = json_decode($json, true);
    	return $json;
    }

    /* If user clicks on search by author, return JSON array of papers */
    public function getPapersFromAuthor($author) {
    	$client = new Client(['base_uri' => 'http://ieeexplore.ieee.org/gateway/', 'timeout' => 5.0]);
    	$xml = $client->get('ipsSearch.jsp?au=' . $author);
    	$json = PaperController::getJSONFromXML($xml);
    	return $json;
    }

    /* If user clicks on search by keywords, return JSON array of papers */
    public function getPapersFromKeywords($keywords) {
    	$client = new Client(['base_uri' => 'http://ieeexplore.ieee.org/gateway/', 'timeout' => 5.0]);
    	$xml = $client->get('ipsSearch.jsp?ab=' . $keywords);
    	$json = PaperController::getJSONFromXML($xml);
    	return $json;
    }
   

		public function combineAbstractsFromIEEEPapers($papers){
			$allAbstractsText = "";

			for ($i=0; $i < count($papers); $i++){
				$allAbstractsText = $allAbstractsText . " " . $papers[$i]['abstract'];
			}
			return $allAbstractsText;
		} 


		public function createWordListFromText($allText){
			$wordList = explode(" ", $allText);
			$wordList = array_filter($wordList);
			$wordList = array_count_values($wordList);
			arsort($wordList);
			$wordList = array_slice($wordList, 0, 100, true);

			return $wordList;
		}

		public function showWordCloudFromName($lastName){
			$paperJSON = PaperController::getPapersFromAuthor($lastName);
			$papers = $paperJSON['document'];

			//var_dump($papers);

			return $this->show($papers);
		}

		public function showWordCloudFromKeyword($keyword){
    	$paperJSON = PaperController::getPapersFromKeywords($keyword);
    	$papers = $paperJSON['document'];


			//var_dump($papers);

			return $this->show($papers);
		}


    public function show($papers) {
    	// $paper = PaperController::getPapersFromAuthor($name);
    	// return $paper;

    	//for($i = 0; $i < count($papers); $i++) {
    	//	$paperTitle = $papers[$i]['title'];
    	//	echo $i . ' ' . $paperTitle;
		//var_dump($papers[$i]);
		//$text = $pdf->getText();
		//echo $text;
    	//	echo '<br/>';
    	//}
			$allAbstracts = $this->combineAbstractsFromIEEEPapers($papers);
			$wordList = $this->createWordListFromText($allAbstracts);

			$wcc = new WordCloudController();
			$wordCloudString = $wcc->createWordCloudString($wordList, 1);

	    return view('wordcloud', ['wordCloudString' => $wordCloudString]);

    	//return $paper;


    	/* ANOTHER WAY TO RETRIEVE/CONVERT XML DATA FROM IEEE API CALLS */
    	// $file = simplexml_load_file('http://ieeexplore.ieee.org/gateway/ipsSearch.jsp?au=Wang', 'SimpleXMLElement', LIBXML_NOCDATA);
    	// $json = json_encode($file);
    	// $array = json_decode($json, true);
    	// return $array;
    }
} 
