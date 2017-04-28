<?php

use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;
use App\Http\Controllers\WordCloudController;


//8 11 12 15
class PaperDataTest extends TestCase
{

    /**
     * 
     * @covers App\Http\Controllers\PaperController::combineAbstractsFromPapers 
     *
     */
	//Req 8
    public function testGetConferencePapers() {
		$conferenceName = "2009 5th International Conference on Wireless Communications, Networking and Mobile Computing";
		$controller = new PaperController();
		$conferencePaperInfo = $controller->getAuthorsAndTitlesOfConferencePapers($conferenceName);
		$titles = $conferencePaperInfo[0];
		$authors = $conferencePaperInfo[1];
		$this->assertEquals(count($titles), count($authors));
		$this->assertEquals(25, count($titles));
		$this->assertEquals("An Improved Joint Synchronization and Channel Estimation Algorithm for MIMO-OFDM System", $titles[0]);
		$this->assertEquals("Yun Li,  Shiju Li,  Zhiqiang Yi", $authors[0]);
	}


    /**
     * 
     * @covers App\Http\Controllers\PaperController::createPaperSubsetFromTFString
     *
     */
	//Req 12
    public function testWordCloudFromSubsetOfPapers() {
		$controller = new PaperController();
		$papers = $controller->getPapersFromKeywords("convolutional");
		$papers = $papers['document'];
		$paperObjects = array();
		for ($i=0; $i<count($papers); $i++){
			$papers[$i]['libraryName'] = "IEEE";
			$papers[$i]['conference'] = $papers[$i]['publisher'];
			$papers[$i]['url'] = $papers[$i]['mdurl'];
			array_push($paperObjects, (object)$papers[$i]);
		}
		$TFString = "tftt";
		$paperSubset = $controller->createPaperSubsetFromTFString($TFString, $paperObjects);
		$IEEEPapers = $paperSubset[0];
		$ACMPapers = $paperSubset[1];
		$this->assertEquals(3, count($IEEEPapers) + count($ACMPapers));
		$this->assertEquals(false, $papers[1]['title'] == $IEEEPapers[1]['title']);
    }


	/**
	 *
	 * @covers App\Http\Controllers\PaperController::getPapersFromKeywords
	 *
	 */
	//Req 15
	public function testPDFDownloadLink(){
		$controller = new PaperController();
		$papers = $controller->getPapersFromKeywords("asdf");
		$papers = $papers['document'];
		$this->assertEquals(true, array_key_exists('pdf', $papers[0]));
		$pdf = $papers[0]['pdf'];
		$this->assertEquals("http://ieeexplore.ieee.org/stamp/stamp.jsp?arnumber=1425317", $pdf);
	}


	/**
	 *
	 * @covers App\Http\Controllers\PaperController::getPapersFromKeywords
	 *
	 */
	//Req 11
	public function testPreviousSearches(){
		$controller = new PaperController();
		$previousSearches = array();
		array_push($previousSearches, (object)['query' => 'green', 'type' => 'keyword', 'id' => 1]);
		array_push($previousSearches, (object)['query' => 'yu', 'type' => 'scholar', 'id' => 2]);
		$papers = $controller->getPapersFromAuthor($previousSearches[1]->query);
		$papers = $papers['document'];
		$this->assertEquals(25, count($papers));
	}
	


}
