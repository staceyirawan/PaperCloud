<?php

use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;


class GetAbstractTest extends TestCase
{
    /**
     * 
     * 
     * @covers App\Http\Controllers\PaperController::getIEEEPaperFromTitle
     */
    public function testGetAbstractFromTitle() {
		$controller = new PaperController();	
		$asdf = $controller->getIEEEPaperFromTitle("Reliability of MIM HAO capcitor for 70nm DRAM");

		$this->assertEquals(array_key_exists('document', $asdf), 1);
    }
}
