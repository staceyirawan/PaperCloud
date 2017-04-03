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

			$allAbstracts = $this->combineAbstractsFromIEEEPapers($papers);
			$wordList = $this->createWordListFromText($allAbstracts);

			$wcc = new WordCloudController();
			$wordCloudString = $wcc->createWordCloudString($wordList, $lastName, "scholar");

	    return view('wordcloud', ['wordCloudString' => $wordCloudString]);


		}

		public function showWordCloudFromKeyword($keyword){
    	$paperJSON = PaperController::getPapersFromKeywords($keyword);
    	$papers = $paperJSON['document'];
			
			$allAbstracts = $this->combineAbstractsFromIEEEPapers($papers);
			$wordList = $this->createWordListFromText($allAbstracts);

			$wcc = new WordCloudController();
			$wordCloudString = $wcc->createWordCloudString($wordList, $keyword, "keyword");

	    return view('wordcloud', ['wordCloudString' => $wordCloudString]);
		}




		public function showPaperListFromKeyword($keyword, $word){
			$paperJSON = PaperController::getPapersFromKeywords($keyword);
			$papers = $paperJSON['document'];


			$papersThatContainWord = array();
			$frequencyArr = array();

			for ($i=0; $i<count($papers); $i++){
				$wordsToSearch = " " . $papers[$i]['abstract'] . " ";
				$wordsToSearch = strtolower($wordsToSearch);

	      $count = substr_count($wordsToSearch, " " . $word . " ");
				if ($count != 0){
					array_push($papersThatContainWord, $papers[$i]);
					array_push($frequencyArr, $count);
				} 
			
			$titleArr = $this->getPaperTitles($papersThatContainWord);
			$authorArr = $this->separateAuthors(getPaperAuthors($papersThatContainWord));
			$conferenceArr = $this->getPaperConferences($papersThatContainWord));

			return view('paperlist', ['frequencies' => $frequencyArr, 'titles' => $titleArr, 'authors' => $authorArr, 'conferences' => $conferenceArr]);
			}

		}


		public function showPaperListFromName($lastName, $word){


		}


    public function getPaperTitles($papers) {
        $paperTitles = array();
        for($i = 0; $i < count($papers); $i++) {
            $paperTitles[$i] = $papers[$i]['title'];
        }
        return $paperTitles;
    }

    public function getPaperAuthors($papers) {
        $paperAuthors = array();
        for($i = 0; $i < count($papers); $i++) {
            $paperAuthors[$i] = $papers[$i]['authors'];
        }
        return $paperAuthors;
    }

    public function separateAuthors($authors) {
        $subAuthors = array();
        $overallAuthors = array();

        for($i = 0; $i < count($authors) ; $i++) {
            $authorString = $authors[$i];
            $author = explode(";", $authorString);
            $subAuthors = $author;
            $overallAuthors[$i] = $subAuthors;
        }
        return $overallAuthors;
    }

    public function getPaperConferences($papers) {
        $paperConferences = array();
        for($i = 0 ; $i < count($papers); $i++) {
            $paperConferences[$i] = $papers[$i]['pubtitle'];
        }
        return $paperConferences;
    }


} 
