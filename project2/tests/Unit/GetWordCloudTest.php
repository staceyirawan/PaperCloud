<?php

use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;
use App\Http\Controllers\WordCloudController;


class GetWordCloudTest extends TestCase
{
    /**
     * 
     * @covers App\Http\Controllers\PaperController::combineAbstractsFromIEEEPapers 
     *
     */
    public function testCombineIEEEAbstracts() {
		$controller = new PaperController();
		$papers = $controller->getPapersFromKeywords("asdf");
		$abstractText = $controller->combineAbstractsFromIEEEPapers($papers['document']);

		$this->assertEquals($abstractText, strtolower($abstractText));
    }


	/**
	 *
	 * @covers App\Http\Controllers\PaperController::createWordListFromText
	 *
	 */
	public function testCreateWordListFromText(){
		$controller = new PaperController();
		$papers = $controller->getPapersFromKeywords("asdf");
		$abstractText = $controller->combineAbstractsFromIEEEPapers($papers['document']);
		$wordList = $controller->createWordListFromText($abstractText);

		$this->assertEquals(count($wordList) <= 100, 1);
	}


	/**
	 *
	 * @covers App\Http\Controllers\WordCloudController::createWordCloudString
	 *
	 */
	public function testCreateWordCloudString(){
		$controller = new PaperController();
		$papers = $controller->getPapersFromKeywords("asdf");
		$abstractText = $controller->combineAbstractsFromIEEEPapers($papers['document']);
		$wordList = $controller->createWordListFromText($abstractText);
		$wccontroller = new WordCloudController();
		$wcString = $wccontroller->createWordCloudString($wordList, "asdf", "keyword");

		$this->assertEquals(count($wcString), 1);
	}

}
