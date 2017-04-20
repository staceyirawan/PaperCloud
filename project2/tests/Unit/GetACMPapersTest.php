<?php

use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;

use app\Http\Controllers;

class GetACMPapersTest extends TestCase
{
    /**
     * 
     * @covers App\Http\Controllers\PaperController::getAllInfoFromHTML
     */
    public function testGetACMPaperInfoFromtURLS() {
    	$controller = new PaperController();
    	$papers = $controller->getACMPapersFromKeyword('asdf')[0];
		$this->assertStringStartsWith("http://dl.acm.org", $papers);
    }

	
}
