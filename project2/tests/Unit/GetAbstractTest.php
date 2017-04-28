<?php

use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;


class GetAbstractTest extends TestCase
{
    /**
     * 
     * 
     * @covers App\Http\Controllers\PaperController::getAbstractFromHTML
     */
    public function testGetAbstractFromHTML() {
		$controller = new PaperController();	
		$asdf = $controller->getIEEEPaperFromTitle('Time Interval Semantics and Reachability Analysis of Time Basic Nets');
        $response = "To model and analyze systems, whose overall correctness depend on time, a powerful formalism called Petri net can be used. Several extensions of Petri nets that are dealing with time have been proposed (i.e. timed Petri nets, stochastic Petri nets). In this paper we deal with high-level Petri nets called environment relationship nets (ER nets for short) and their special type called time basic nets (TB nets for short). Aim of this paper is to put a light on the possibility of solving the reachability problem for TB nets. We will introduce some methods and constructions that help us to solve this crucial problem.";
        
		$this->assertEquals($response, $asdf['document']['abstract']);
        
    }


}
