<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

include '../vendor/autoload.php';
include_once 'simple_html_dom.php';

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
				if (array_key_exists('abstract', $papers[$i])){
					$allAbstractsText = $allAbstractsText . " " . $papers[$i]['abstract'];
				}
			}
			$allAbstractsText = strtolower($allAbstractsText);
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
				if (!array_key_exists('abstract', $papers[$i])) continue;
				$wordsToSearch = " " . $papers[$i]['abstract'] . " ";
				$wordsToSearch = strtolower($wordsToSearch);

	      $count = substr_count($wordsToSearch, " " . $word . " ");
				if ($count != 0){
					array_push($papersThatContainWord, $papers[$i]);
					array_push($frequencyArr, $count);
				} 
			}

		//	var_dump($papersThatContainWord);
			
			$titleArr = $this->getPaperTitles($papersThatContainWord);
			$authorArr = $this->separateAuthors($this->getPaperAuthors($papersThatContainWord));
			$conferenceArr = $this->getPaperConferences($papersThatContainWord);
			$downloadArr = $this->getDownloadLinks($papersThatContainWord);

			return view('paperlist', ['frequencies' => $frequencyArr, 'titles' => $titleArr, 'authors' => $authorArr, 'conferences' => $conferenceArr, 'downloadLinks' => $downloadArr, 'word' => $word]);
		}


		public function showPaperListFromName($lastName, $word){
			$paperJSON = $this->getPapersFromAuthor($lastName);
			$papers = $paperJSON['document'];

			$papersThatContainWord = array();
			$frequencyArr = array();

			for ($i=0; $i<count($papers); $i++){
				if (!array_key_exists('abstract', $papers[$i])) continue;
				$wordsToSearch = " " . $papers[$i]['abstract'] . " ";
				$wordsToSearch = strtolower($wordsToSearch);

	      $count = substr_count($wordsToSearch, " " . $word . " ");
				if ($count != 0){
					array_push($papersThatContainWord, $papers[$i]);
					array_push($frequencyArr, $count);
				}
			} 
			
			$titleArr = $this->getPaperTitles($papersThatContainWord);
			$authorArr = $this->separateAuthors($this->getPaperAuthors($papersThatContainWord));
			$conferenceArr = $this->getPaperConferences($papersThatContainWord);
			$downloadArr = $this->getDownloadLinks($papersThatContainWord);

			return view('paperlist', ['frequencies' => $frequencyArr, 'titles' => $titleArr, 'authors' => $authorArr, 'conferences' => $conferenceArr, 'downloadLinks' => $downloadArr, 'word' => $word]);
		}


		public function getDownloadLinks($papers){
			$paperDownloadLinks = array();
			for ($i=0; $i < count($papers); $i++){
				$paperDownloadLinks[$i] = $papers[$i]['pdf'];
			}	
			return $paperDownloadLinks;
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

    /* Get an array of pdf links from ACM library with given author name(s) */
    public function getACMPapersFromAuthor($author) {
         // Run python script on terminal and retrieve csv content file
        $execution = shell_exec('python ../app/Http/Controllers/site-packages/scholar.py -c 10 --pub=ACM --author=' . $author);
        $array = array_map("str_getcsv", explode("\n", $execution));

        $counter = 0;
        $pdfLinks = array();

        for($i = 1; $i<count($array); $i+=10) {
            
            $pURL = $array[$i][0];
            $pURL = trim($pURL);

            $tUArray = array();
            $tUArray = explode(" ", $pURL);
            $tURL = $tUArray[1];


            $pdfLinks[$counter] = PaperController::getPDFFromHTML($tURL);

            $counter++;
        }

        return $pdfLinks;

    }
    /* Get an array of pdf links from ACM library with given keyword(s) */
    public function getACMPapersFromKeyword($keyword) {
        // Run python script on terminal and retrieve csv content file
        $execution = shell_exec('python ../app/Http/Controllers/site-packages/scholar.py -c 10 --pub=ACM --some=' . $keyword);
        $array = array_map("str_getcsv", explode("\n", $execution));

        $counter = 0;
        $pdfLinks = array();

        for($i = 1; $i<count($array); $i+=10) {
            
            $pURL = $array[$i][0];
            $pURL = trim($pURL);

            $tUArray = array();
            $tUArray = explode(" ", $pURL);
            $tURL = $tUArray[1];

            $pdfLinks[$counter] = PaperController::getPDFFromHTML($tURL);

            $counter++;
        }

        return $pdfLinks;

    }

    // Scrape html for pdf link
    public function getPDFFromHTML($tURL) {
        $html = file_get_html($tURL);
        $pdfLink;
        foreach($html->find('meta') as $element) {
            if($element->name == "citation_pdf_url") {
                $pdfLink = $element->content;
            }
        }
        return $pdfLink;
    }



	//ABSTRACT STUFF
		public function showAbstract($title, $word){
			//NOTE: once we implement ACM stuff, need to search both databases for the paper
			
			$paperJSON = PaperController::getIEEEPaperFromTitle($title);
			$papers = $paperJSON['document'];

			$abstract = $papers['abstract'];

			return view('paperpage', ['abstract' => $abstract, 'word' => $word, 'title' => $title]);

		}


		public function getIEEEPaperFromTitle($title) {
    	$client = new Client(['base_uri' => 'http://ieeexplore.ieee.org/gateway/', 'timeout' => 5.0]);
    	$xml = $client->get('ipsSearch.jsp?ti=' . $title);
    	$json = PaperController::getJSONFromXML($xml);
    	return $json;
    }



	//CONFERNECE STUFF
		public function getPaperListFromConference($conferenceName){

			$titles = array();
			$authors = array();

			//Get list of ACM papers

			//Get list of IEEE papers

			$client = new Client(['base_uri' => 'http://ieeexplore.ieee.org/gateway/', 'timeout' => 5.0]);
			$xml = $client->get('ipsSearch.jsp?jn=' . $conferenceName);
			$json = PaperController::getJSONFromXML($xml);

			$papers = $json['document'];

			for ($i=0; $i<count($papers); $i++){
				$titles[$i] = $papers[$i]['title'];
				$authors[$i] = $papers[$i]['authors'];
			}


			return view('conferencepage', ['titles' => $titles, 'authors' => $authors]);
		}






} 
