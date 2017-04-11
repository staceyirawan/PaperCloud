<?php


use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;


class GetPaperFromWordTest extends TestCase
{
    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPaperTitles 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor
     */
    public function testGetPaperTitles() {
    	$controller = new PaperController();
    	$papers = $controller->getPapersFromAuthor('Wang');
        $paperTitles = $controller->getPaperTitles($papers['document']);

        $this->assertEquals(count($papers['document']), count($paperTitles)); 
    	
    }
    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor 
     * @covers App\Http\Controllers\PaperController::getPaperAuthors
     */

    public function testGetPaperAuthors() {
        $controller = new PaperController();
        $papers = $controller->getPapersFromAuthor('Wang');
        $paperAuthors = $controller->getPaperAuthors($papers['document']);

        $this->assertEquals(count($papers['document']), count($paperAuthors));
    }
    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor 
     * @covers App\Http\Controllers\PaperController::separateAuthors
     */

    public function testSeparateAuthors() {
        $controller = new PaperController();
        $papers = $controller->getPapersFromAuthor('Wang');
        $paperAuthors = $controller->getPaperAuthors($papers['document']);
        $separatedAuthors = $controller->separateAuthors($paperAuthors);

        $this->assertEquals(count($paperAuthors), count($separatedAuthors));
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor 
     * @covers App\Http\Controllers\PaperController::getPaperConferences
     */
    public function testGetPaperConferences() {
        $controller = new PaperController();
        $papers = $controller->getPapersFromAuthor('Wang');
        $paperConferences = $controller->getPaperConferences($papers['document']);

        $this->assertEquals(count($papers['document']), count($paperConferences));
    }



		/**
		 *
	   * @covers App\Http\Controllers\PaperController::getPapersFromKeywords 
     * @covers  App\Http\Controllers\PaperController::getDownloadLinks
     */
		public function testGetPaperFromKeyword(){
			$controller = new PaperController();
			$papers = $controller->getPapersFromKeywords('asdf');
			$paperDownloadLinks = $controller->getDownloadLinks($papers['document']);

			$this->assertEquals(count($papers['document']), count($paperDownloadLinks));
		}

}
