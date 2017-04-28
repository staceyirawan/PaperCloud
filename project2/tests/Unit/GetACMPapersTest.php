<?php

use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;

use app\Http\Controllers;

class GetACMPapersTest extends TestCase
{
    
    /**
     * 
     * @covers App\Http\Controllers\PaperController::getACMPapersFromAuthor
     */
    public function testGetACMPapersFromAuthor(){
        $controller = new PaperController();
        $result = $controller->getACMPapersFromAuthor("wang");
        

        $this->assertStringStartsWith('http://dl.acm.org', $result[0]);
    }




    /**
     * 
     * @covers App\Http\Controllers\PaperController::getAllInfoFromHTML
     */
    public function testGetAllInfoFromHTML() {
    	$controller = new PaperController();
    	$result = $controller->getAllInfoFromHTML('http://dl.acm.org/citation.cfm?id=1348248');
		$this->assertArrayHasKey('publisher', $result);
        $this->assertArrayHasKey('pdf', $result);
        $this->assertArrayHasKey('authors', $result);

        

    }

	
}
