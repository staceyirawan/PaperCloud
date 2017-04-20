<?php


use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;




class GetPaperFromWordTest extends TestCase
{

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor
     */
    public function testGetPaperTitles() {
    	$controller = new PaperController();
    	$papers = $controller->getPapersFromAuthor('Wang')['document'][0]['title'];
        $testTitle = "The SNS linac RF control system";
        $this->assertEquals($papers, $testTitle); 
    	
    }
    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor 
     */

    public function testGetPaperAuthors() {
        $controller = new PaperController();
        $papers = $controller->getPapersFromAuthor('Wang');
       

        $this->assertEquals(count($papers['document']), 25);
    }





		/**
		 *
	   * @covers App\Http\Controllers\PaperController::getPapersFromKeywords 
     */
		public function testGetPaperFromKeyword(){
			$controller = new PaperController();
			$papers = $controller->getPapersFromKeywords('asdf');
			

			$this->assertEquals(count($papers['document']), 8);
		}

}
