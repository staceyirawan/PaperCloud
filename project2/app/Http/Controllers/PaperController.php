<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

//include '../vendor/autoload.php';
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
   

	public function combineAbstractsFromPapers($papers, $ACMPapers){
		DB::delete('delete from paperinfo');
		$allAbstractsText = "";
		$id = 1;
		for ($i=0; $i < count($papers); $i++){
			if (array_key_exists('abstract', $papers[$i])){
				$allAbstractsText = $allAbstractsText . " " . $papers[$i]['abstract'];
				DB::insert('insert into paperinfo (libraryName, id, title, conference, pdf, authors, bibtex, abstract) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', ["IEEE", $id, $papers[$i]['title'], $papers[$i]['publisher'], $papers[$i]['pdf'], $papers[$i]['authors'], "bibtexIEEE", $papers[$i]['abstract']]);
				$id++;
			}
		}

		for ($i=0; $i < count($ACMPapers); $i++){
			$allAbstractsText = $allAbstractsText . " " . $ACMPapers[$i]['abstract'];
			DB::insert('insert into paperinfo (libraryName, id, title, conference, pdf, authors, bibtex, abstract) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', ["ACM", $id, $ACMPapers[$i]['title'], $ACMPapers[$i]['publisher'], $ACMPapers[$i]['pdf'], $ACMPapers[$i]['authors'], "bibtexACM", $ACMPapers[$i]['abstract']]);
			$id++;
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

	public function getSubsetBasedOnX($papers, $ACMPapers, $X){
		$IEEEsubset = array();
		$ACMsubset = array();
		$count = 0;

		for ($i=0; ($count < $X) && ($i < count($papers) || $i < count($ACMPapers)); $i++){
			if ($i < count($papers)){
				array_push($IEEEsubset, $papers[$i]);
				$count++;
			}
			if ($i < count($ACMPapers) && $count < $X){
				array_push($ACMsubset, $ACMPapers[$i]);
				$count++;
			}
		}
		$tempObject = array();
		$tempObject['IEEE'] = $IEEEsubset;
		$tempObject['ACM'] = $ACMsubset;
		return $tempObject;	
	}

	public function getHashFromFirstLetter($firstLetter){
		return 0;

	}

	public function createWordCloudStringFromName($lastName, $X){
		$initialTime = time();
		$totalTime = PaperController::getHashFromFirstLetter($lastName[0]);

		DB::delete('delete from x');
		DB::insert('insert into x (x) values (?)', [$X]);

		$paperJSON = PaperController::getPapersFromAuthor($lastName);
		$papers = $paperJSON['document'];

		$ACMPaperUrls = PaperController::getACMPapersFromAuthor($lastName);
		$ACMPapers = PaperController::formatACMPapersFromURLSintoArray($ACMPaperUrls);

		$paperSubset = PaperController::getSubsetBasedOnX($papers, $ACMPapers, $X);
	
		$allAbstracts = $this->combineAbstractsFromPapers($paperSubset['IEEE'], $paperSubset['ACM']);
		$wordList = $this->createWordListFromText($allAbstracts);

		$wcc = new WordCloudController();
		$wordCloudString = $wcc->createWordCloudString($wordList, $lastName, "scholar");

		$finalTime = time();
		//TODO wait	

		return $wordCloudString;
	}

	public function showWordCloudFromName($lastName, $X){
		$wordCloudString = $this->createWordCloudStringFromName($lastName, $X);
		return view('wordcloud', ['wordCloudString' => $wordCloudString]);
	}


	public function createWordCloudStringFromKeyword($keyword, $X){
		DB::delete('delete from x');
		DB::insert('insert into x (x) values (?)', [$X]);

		$paperJSON = PaperController::getPapersFromKeywords($keyword);
		$papers = $paperJSON['document'];

		$ACMPaperUrls = PaperController::getACMPapersFromKeyword($keyword);
		$ACMPapers = PaperController::formatACMPapersFromURLSintoArray($ACMPaperUrls);
		
		$paperSubset = PaperController::getSubsetBasedOnX($papers, $ACMPapers, $X);
	
		$allAbstracts = $this->combineAbstractsFromPapers($paperSubset['IEEE'], $paperSubset['ACM']);
		$wordList = $this->createWordListFromText($allAbstracts);

		$wcc = new WordCloudController();
		$wordCloudString = $wcc->createWordCloudString($wordList, $keyword, "keyword");
		
		return $wordCloudString;
	}

	public function showWordCloudFromKeyword($keyword, $X){
		$wordCloudString = $this->createWordCloudStringFromKeyword($keyword, $X);
		return view('wordcloud', ['wordCloudString' => $wordCloudString]);
	}

	public function createWordCloudStringFromFullName($fullname){
		$xresults = DB::table('x')->get();
		$X = $xresults[0]->x;
		//TODO
	}

	public function showWordCloudFromFullName($fullname){
		$wordCloudString = $this->createWordCloudStringFromFullName($fullname);
		//TODO
//		return view('wordcloud', ['wordCloudString' => $wordCloudString]);
	}


	public function getPaperListInformation($word){
		$allRows = DB::select('select * from paperinfo');
		//var_dump($allRows);

		$titles = array();
		$pdfs = array();
		$conferences = array();
		$authors = array();
		//$bibtex = array();
		$frequency = array();

		for ($i=0; $i<count($allRows); $i++){
			$wordsToSearch = $allRows[$i]->abstract;
			$wordsToSearch = strtolower($wordsToSearch);
			$count = substr_count($wordsToSearch, " " . $word . " ");
			if ($count != 0){
				array_push($titles, $allRows[$i]->title);
				array_push($pdfs, $allRows[$i]->pdf);
				array_push($conferences, $allRows[$i]->conference);
				array_push($authors, explode(";", $allRows[$i]->authors));
				array_push($frequency, $count);
			} 
			//TODO push into db.
		}
		$obj = array();
		$obj['titles'] = $titles;
		$obj['pdfs'] = $pdfs;
		$obj['conferences'] = $conferences;
		$obj['authors'] = $authors;
		$obj['frequency'] = $frequency;
		//var_dump($obj);
		return $obj;
	}


	public function showPaperListFromKeyword($keyword, $word){
		$allInfo = PaperController::getPaperListInformation($word);
		return view('paperlist', ['frequencies' => $allInfo['frequency'], 'titles' => $allInfo['titles'], 'authors' => $allInfo['authors'], 'conferences' => $allInfo['conferences'], 'downloadLinks' => $allInfo['pdfs'], 'word' => $word]);
	}


	public function showPaperListFromName($lastName, $word){
		$allInfo = PaperController::getPaperListInformation($word);
		return view('paperlist', ['frequencies' => $allInfo['frequency'], 'titles' => $allInfo['titles'], 'authors' => $allInfo['authors'], 'conferences' => $allInfo['conferences'], 'downloadLinks' => $allInfo['pdfs'], 'word' => $word]);
	}

    //  ************ ACM STUFF ************
    //  ************ ACM STUFF ************
    //  ************ ACM STUFF ************
    //  ************ ACM STUFF ************

    /* Get X (-c X) ACM paper links from author */
    // Currently retrieving 1 paper
    public function getACMPapersFromAuthor($author) {
         // Run python script on terminal and retrieve csv content file
        $execution = shell_exec('python ../app/Http/Controllers/site-packages/scholar.py -c 10 --pub=ACM --author=' . $author);
        $array = array_map("str_getcsv", explode("\n", $execution));

        $counter = 0;
        $tURLs = array();

        for($i = 1; $i<count($array); $i+=10) {
            
            $pURL = $array[$i][0];
            $pURL = trim($pURL);

            $tUArray = array();
            $tUArray = explode(" ", $pURL);
            $tURLs[$counter] = $tUArray[1];

            $counter++;

        }
        return $tURLs;
    }

    /* Get X (-c X) ACM paper links from keyword */
    // Currently retrieving 1 paper 
    public function getACMPapersFromKeyword($keyword) {
        // Run python script on terminal and retrieve csv content file
        $execution = shell_exec('python ../app/Http/Controllers/site-packages/scholar.py -c 5 --pub=ACM --some=' . $keyword);
        $array = array_map("str_getcsv", explode("\n", $execution));

        $counter = 0;
        $tURLs = array();

        for($i = 1; $i<count($array); $i+=10) {
            
            $pURL = $array[$i][0];
            $pURL = trim($pURL);

            $tUArray = array();
            $tUArray = explode(" ", $pURL);
            $tURLs[$counter] = $tUArray[1];

            $counter++;
        }
    	return $tURLs;
    }
 
    // Scrape ACM html for 1 paper's abstract text using python script
    public function getAbstractFromHTML($tURL) {
    	$abstract = shell_exec('python ../app/Http/Controllers/site-packages/getAbstract.py '. $tURL);
    	return $abstract;
    }
	
	public function getAllInfoFromHTML($tURL){
		$tempObject = array();
    	$html = file_get_html($tURL);

		foreach($html->find('meta') as $element) {
    		if($element->name == 'citation_conference') {
    			$tempObject['publisher'] = $element->content;
    		}
    		else if($element->name == 'citation_journal_title') {
    			$tempObject['publisher']= $element->content;
    		}
    		else if($element->name == 'citation_title') {
				$tempObject['title'] = $element->content;
			}
    		else if($element->name == "citation_authors") {
    			$tempObject['authors'] = $element->content;
    		}
            else if($element->name == "citation_pdf_url") {
				$tempObject['pdf'] = $element->content;
			}
    	}

		return $tempObject;

	}


	public function formatACMPapersFromURLSintoArray($ACMPaperUrls){
		//var_dump($ACMPaperUrls);

		$ACMInfo = array();
		for ($i=0; $i<count($ACMPaperUrls) && $i < 1; $i++){ //TODO make this 5
			$tempObject = PaperController::getAllInfoFromHTML($ACMPaperUrls[$i]);
			$tempObject['abstract'] = PaperController::getAbstractFromHTML($ACMPaperUrls[$i]);
			array_push($ACMInfo, $tempObject);
				
		}
		//var_dump($ACMInfo);
		return $ACMInfo;
	}


    //  ************ END ACM STUFF *********************
    //  ************ END ACM STUFF *********************
    //  ************ END ACM STUFF *********************
    //  ************ END ACM STUFF *********************




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

			$authors = str_replace(";", ",", $authors);
			return view('conferencepage', ['titles' => $titles, 'authors' => $authors]);
		}



} 
