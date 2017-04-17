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
		$allAbstractsText = "";
		for ($i=0; $i < count($papers); $i++){
			if (array_key_exists('abstract', $papers[$i])){
				echo $papers[$i]['abstract'];
				echo "()()()())()()()()()()()()()()()";
				$allAbstractsText = $allAbstractsText . " " . $papers[$i]['abstract'];
				//DB::insert into papers(id, title, conference, bibtex, pdf, authors) VALUES (?, ?, ?, ?, ?, ?), []);

			}
		}

		for ($i=0; $i < count($ACMPapers); $i++){
			$allAbstractsText = $allAbstractsText . " " . $ACMPapers[$i]['abstract'];
			echo $ACMPapers[$i]['abstract'];
			echo "()()()()()()()()()()()()()()";
		}
		$allAbstractsText = strtolower($allAbstractsText);
		//echo $allAbstractsText;

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
		

		return $wordCloudString;
	}

	public function showWordCloudFromName($lastName, $X){
//		DB::delete('delete from x');
		//$papers = DB::table('papers')->where('id', 1)->first();
		//var_dump($papers);
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

//		return view('wordcloud', ['wordCloudString' => $wordCloudString]);
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
		echo "ABSTRACT: ";
		echo $abstract;
    	return $abstract;
    }
	
	public function getAllInfoFromHTML($tURL){
		$tempObject = array();
    	$html = file_get_html($tURL);

		foreach($html->find('meta') as $element) {
    		if($element->name == 'citation_conference') {
    			$tempObject['conference'] = $element->content;
    		}
    		else if($element->name == 'citation_journal_title') {
    			$tempObject['conference']= $element->content;
    		}
    		else if($element->name == 'citation_title') {
				$tempObject['title'] = $element->content;
			}
    		else if($element->name == "citation_authors") {
    			$authorString = $element->content;
    			$authors = explode(";", $authorString);
				$tempObject['authors'] = $authors;
				$tempObject['authorString'] = $authorString;
    		}
            else if($element->name == "citation_pdf_url") {
				$tempObject['pdf'] = $element->content;
			}
    	}

		//$tempObject['abstract'] = PaperController::getAbstractFromHTML($tURL);
		return $tempObject;

	}


	public function formatACMPapersFromURLSintoArray($ACMPaperUrls){
		//var_dump($ACMPaperUrls);

		$ACMInfo = array();
		for ($i=0; $i<count($ACMPaperUrls) && $i < 5; $i++){
			/*$tempObject = array();
			$tempObject['title'] = PaperController::getTitleFromHTML($ACMPaperUrls[$i]);
			$tempObject['pdf'] = PaperController::getPDFFromHTML($ACMPaperUrls[$i]);
			echo "beore";
			$tempObject['abstract'] = PaperController::getAbstractFromHTML($ACMPaperUrls[$i]);
			echo "after";
			$tempObject['authors'] = PaperController::getAuthorsFromHTML($ACMPaperUrls[$i]);
			$tempObject['publisher'] = PaperController::getConferenceFromHTML($ACMPaperUrls[$i]);
			*/
			$tempObject = PaperController::getAllInfoFromHTML($ACMPaperUrls[$i]);
			$tempObject['abstract'] = PaperController::getAbstractFromHTML($ACMPaperUrls[$i]);
			array_push($ACMInfo, $tempObject);
				
		}
		var_dump($ACMInfo);
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
