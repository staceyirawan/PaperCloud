<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\PaperController;

class GetPaperFromWordTest extends TestCase
{
    /**
     * 
     * @covers getPapersFromAuthor() && getPaperTitles()
     *
     */
    public function testGetPaperTitles() {

    	$controller = new PaperController();

    	$papers = $controller->getPapersFromAuthor('Wang');

        $paperTitles = $controller->getPaperTitles($papers['document']);


        $this->assertEquals(count($papers['document']), count($paperTitles)); 
    	
    }
    /**
     * 
     * @covers getPapersFromAuthor() && getPaperAuthors()
     *
     */

    public function testGetPaperAuthors() {

        $controller = new PaperController();

        $papers = $controller->getPapersFromAuthor('Wang');

        $paperAuthors = $controller->getPaperAuthors($papers['document']);

        $this->assertEquals(count($papers['document']), count($paperAuthors));
    }
    /**
     * 
     * @covers getPapersFromAuthor() && separateAuthors()
     *
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
     * @covers getPapersFromAuthor() && getPaperConferences()
     *
     */
    public function testGetPaperConferences() {

        $controller = new PaperController();

        $papers = $controller->getPapersFromAuthor('Wang');

        $paperConferences = $controller->getPaperConferences($papers['document']);

        $this->assertEquals(count($papers['document']), count($paperConferences));
    }
}
