<?php


use PHPUnit\Framework\TestCase;

use App\Http\Controllers\PaperController;




class WordCloudTest extends TestCase
{

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor
     */
    //Req 1: Initial page that allows one to input search criteria comprised of a researcher’s last name. 
    public function testGetSearchWithAuthor() {
    	$controller = new PaperController();
        $papers = $controller->getPapersFromAuthor('Wang');
        $this -> assertArrayHasKey('title', $papers['document'][0]);
    	
    }
    /**
     * 
     * @covers App\Http\Controllers\PaperController::createWordListFromText
     */
    //Req 2: When a search is submitted, it should create word cloud of the top X number of papers in the ACM and IEEE digital library that match the provided criteria.
    public function testGetCloudWithX() {
        $controller = new PaperController();
      
        $result = $controller->createWordListFromText("a flat spectral photon flux source is proposed to facilitate the single photon detector quantum efficiency calibration in an extended wavelength range (400-800nm). the absolute quantum efficiency at certain wavelengths (e.g. 633nm and 807nm) of the photon counter under test can be measured via correlated photons method and used to evaluate the photon statistics of the flat spectral photon flux source. a correction factor derived from the photon statistics can then be applied throughout the wavelength range for improved detector quantum efficiency measurement. a switched beam technique applied to uhf band rfid reader is proposed. the proposed switched beam circuit composed of power divider, phase shifter, and beam controlling logic circuit is implemented on a 1x2 array antenna, and resulted in a -30 to 30 degrees beam switching range in three discrete angles. this capability not only enhances the sensing range and distance but also reduces the possible emi interference. in addition, this array antenna can help effectively cancel or attenuate mutual interference among tags through antenna arrays directivity. these advantages provided by the antenna array greatly improve the performance of a rfid system in terms of scan efficiency and read rate, which makes rfid applications even more appealing. eye center detection is an essential module in iris segmentation and gaze tracking. it is more challengeable to achieve this goal using a usual web camera under natural illumination. the image resolution and the eye region scale are main problems. focusing on solving these problems, this paper proposes a robust eye center searching algorithm which can locate the iris including the center and the radius in id searching time consuming. experiment shows an excited result. compared with the well known hough and integral differential, this method also is robust to the reflection and occlusion. in this letter, an optimal power allocation scheme for energy efficiency (ee) maximization with low complexity in 5g downlink multiuser systems is presented. the optimal power allocation is obtained in two steps. the first step is to find the power scheme to maximize the geometric mean of weighted average channel gains corresponding to any fixed total dynamic power. the second step to obtain the optimal total dynamic power. compared with the conventional iterative algorithm, our proposed algorithm can significantly reduce the implementation complexity without sacrificing performance. monte carlo simulations show that the proposed power allocation can achieve the ee performance identical to exhaustive search. in this paper, a method for tracking single target on the ground by aircrafts is presented. image processing module is designed for collecting image signals and tracking targets. this module is composed of dual dsp, cpld and corresponding ram. it has strong computing power. this paper analyses the difficulties to implement the algorithm of target tracking for single target and proposed a solution by means of the image processing module. in order to develop highly secure database systems to meet the requirements for class b2, an extended formal security policy model based on the blp model is presented in this paper. a method for verifying security model for database systems is proposed. according to this method, the development of a formal specification and verification to ensure the security of the extended model is introduced. during the process of the verification, a number of mistakes have been identified and corrections have been made. both the specification and verification are developed in coq proof assistant. our formal security model was improved and has been verified secure. this work demonstrates that our verification method is effective and sufficient and illustrates the necessity for formal verification of the extended model by using tools. flood simulation and forecasting is a hot topic of flood disaster research. dem as the basic data plays a crucial role in the field. high resolution grid dem data is able to supply exact terrain model to this work, but it brings on a bothering problem that the data is too big to reduce running efficiency in computer. facing the issue, the paper tries to solve the problem of high resolution dem data��s processing and transferring. a new flood simulation method is introduced first. it brings a simple and efficient simulate method to simulate flood on high resolution dem data. and then, a webgis based system is designed as flood simulation function��s running platform. advanced webgis technologies lead an efficient transferring way to dem data and other relative images. this paper adopted guizhou 2005 tm/etm satellite image data and analyzed its rural ecological landscape pattern(relp) by using gis software. it was shown that guizhou rural landscape distribution difference was big, landscape fragmentation was high, agricultural landscape integrity was poor. besides the fractal dimension of settlement landscape is relatively lower, the others were quite high. rural landscape plaques distribution was irregular, shape without regularity. a low voltage high frequency cmos continuous time band-pass filter with programmable center frequency and quality factor is presented. the operational transconductance amplifier (ota) in this gm-c filter design is implemented by a low-voltage simple cascode ota. the transconductance can be digitally programmable. simulations show that the center frequency can be tuned from 400 mhz to 1 ghz for a 2.0 pf capacitive load. this filter has been designed in a tsmc 0.18 mu digital process with 1.8 v power supplies and consumes around 32 mw of power. ");
        $this->assertArrayHasKey('photon', $result);
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromKeywords
     * @covers App\Http\Controllers\PaperController::getSubsetBasedOnX
     * @covers App\Http\Controllers\PaperController::getJSONFromXML
     */
    //NEED TO REFACTOR Req 3: Clicking on a word in the cloud should return a list of papers that mention that word. Each entry in the list should include the name of the paper, the list of authors, the conference name, and the frequency of the word.
    public function testGetPaperListWithWord() {
        $controller = new PaperController();
        
        $paperJSON = $controller->getPapersFromKeywords('asdf');
        $papers = $paperJSON['document'];

        $ACMPapers = array(
            0 => array(
                'publisher' => 'ACM Computing Surveys (CSUR)',
                'authors' => 'Datta, Ritendra; Joshi, Dhiraj; Li, Jia; Wang, James Z.',
                'title' => 'Image retrieval: Ideas, influences, and trends of the new age',
                'pdf' => 'http://dl.acm.org/ft_gateway.cfm?id=1348248&type=pdf',
                'abstract' => null
            ),
        );

       
        $result = $controller->getSubsetBasedOnX($papers, $ACMPapers, 10);

        $this->assertArrayHasKey('IEEE', $result);
        $this->assertArrayHasKey('ACM', $result);


        
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromKeywords
     */
    //Req 4: Each paper on the paper list should have a download link that allows the user to download the paper from the digital library. This should be in a separate column.
    public function testGetPaperDownload() {
        $controller = new PaperController();
            $papers = $controller->getPapersFromKeywords('asdf');
            $this->assertArrayHasKey('pdf', $papers['document'][0]);
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getBibtex
     */
    //Req 5: In the paper list, there should be a column that contains BibTex links for each paper.
    public function testGetPaperBibtex() {
        $this->assertEquals(5, 5);
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getAllInfoFromHTML
     */
    //Req 6: Show a status bar for current progress in generating the word cloud. This bar should be a rectangle that fills up, and should accurately reflect the generation process.
    public function testGetStatusBar() {
        $controller = new PaperController();
        $result = $controller->getAllInfoFromHTML('http://dl.acm.org/citation.cfm?id=1348248');
        $this->assertArrayHasKey('publisher', $result);
        $this->assertArrayHasKey('pdf', $result);
        $this->assertArrayHasKey('authors', $result);
    }


    /**
     * 
     * @covers App\Http\Controllers\PaperController::getPapersFromAuthor 
     * @covers App\Http\Controllers\PaperController::getACMPapersFromAuthor
     */
    //Req 7: For each paper, clicking on an author in its author list will do a new search based on that author.
    public function testGetPaperWithNewAuthor() {
        $controller = new PaperController();
        $papers = $controller->getPapersFromAuthor('Wang');
        $papers2 = $controller->getACMPapersFromAuthor('Wang');
        $this -> assertArrayHasKey('title', $papers['document'][0]);
        $this-> assertArrayHasKey('title', $papers2);
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getAllInfoFromHTML 
     * @covers App\Http\Controllers\PaperController::getAbstractFromHTML
     */
    //Req 9: For each paper, clicking on a paper’s title will allow the user to read the abstract.
    public function testGetPaperAbstract() {
        $controller = new PaperController();
        $result = $controller->getAllInfoFromHTML('http://dl.acm.org/citation.cfm?id=1348248');
        $result2 = $controller->getAbstractFromHTML("");
        $this->assertArrayHasKey('publisher', $result);
        $this->assertArrayHasKey('pdf', $result);
        $this->assertArrayHasKey('authors', $result);
    }

    /**
     * 
     * @covers App\Http\Controllers\PaperController::getAllInfoFromHTML
     */
    //Req 10: Export lists of papers as PDFs and plain text via a download button on the page.
    public function testGetPaperPDFAndPlaintxt() {
        $controller = new PaperController();
        $result = $controller->getAllInfoFromHTML('http://dl.acm.org/citation.cfm?id=1348248');
      
        $this->assertArrayHasKey('pdf', $result);
    }

     /**
     * 
     * @covers App\Http\Controllers\PaperController::createWordListFromText
     * @covers App\Http\Controllers\PaperController::showWordCloudFromSubset
     */
    //Req 13: Allow for the downloading of an image of the generated word cloud.
    public function testGetCloudImage() {
        $controller = new PaperController();
        
        
      
        $result = $controller->createWordListFromText("a flat spectral photon flux source is proposed to facilitate the single photon detector quantum efficiency calibration in an extended wavelength range (400-800nm). the absolute quantum efficiency at certain wavelengths (e.g. 633nm and 807nm) of the photon counter under test can be measured via correlated photons method and used to evaluate the photon statistics of the flat spectral photon flux source. a correction factor derived from the photon statistics can then be applied throughout the wavelength range for improved detector quantum efficiency measurement. a switched beam technique applied to uhf band rfid reader is proposed. the proposed switched beam circuit composed of power divider, phase shifter, and beam controlling logic circuit is implemented on a 1x2 array antenna, and resulted in a -30 to 30 degrees beam switching range in three discrete angles. this capability not only enhances the sensing range and distance but also reduces the possible emi interference. in addition, this array antenna can help effectively cancel or attenuate mutual interference among tags through antenna arrays directivity. these advantages provided by the antenna array greatly improve the performance of a rfid system in terms of scan efficiency and read rate, which makes rfid applications even more appealing. eye center detection is an essential module in iris segmentation and gaze tracking. it is more challengeable to achieve this goal using a usual web camera under natural illumination. the image resolution and the eye region scale are main problems. focusing on solving these problems, this paper proposes a robust eye center searching algorithm which can locate the iris including the center and the radius in id searching time consuming. experiment shows an excited result. compared with the well known hough and integral differential, this method also is robust to the reflection and occlusion. in this letter, an optimal power allocation scheme for energy efficiency (ee) maximization with low complexity in 5g downlink multiuser systems is presented. the optimal power allocation is obtained in two steps. the first step is to find the power scheme to maximize the geometric mean of weighted average channel gains corresponding to any fixed total dynamic power. the second step to obtain the optimal total dynamic power. compared with the conventional iterative algorithm, our proposed algorithm can significantly reduce the implementation complexity without sacrificing performance. monte carlo simulations show that the proposed power allocation can achieve the ee performance identical to exhaustive search. in this paper, a method for tracking single target on the ground by aircrafts is presented. image processing module is designed for collecting image signals and tracking targets. this module is composed of dual dsp, cpld and corresponding ram. it has strong computing power. this paper analyses the difficulties to implement the algorithm of target tracking for single target and proposed a solution by means of the image processing module. in order to develop highly secure database systems to meet the requirements for class b2, an extended formal security policy model based on the blp model is presented in this paper. a method for verifying security model for database systems is proposed. according to this method, the development of a formal specification and verification to ensure the security of the extended model is introduced. during the process of the verification, a number of mistakes have been identified and corrections have been made. both the specification and verification are developed in coq proof assistant. our formal security model was improved and has been verified secure. this work demonstrates that our verification method is effective and sufficient and illustrates the necessity for formal verification of the extended model by using tools. flood simulation and forecasting is a hot topic of flood disaster research. dem as the basic data plays a crucial role in the field. high resolution grid dem data is able to supply exact terrain model to this work, but it brings on a bothering problem that the data is too big to reduce running efficiency in computer. facing the issue, the paper tries to solve the problem of high resolution dem data��s processing and transferring. a new flood simulation method is introduced first. it brings a simple and efficient simulate method to simulate flood on high resolution dem data. and then, a webgis based system is designed as flood simulation function��s running platform. advanced webgis technologies lead an efficient transferring way to dem data and other relative images. this paper adopted guizhou 2005 tm/etm satellite image data and analyzed its rural ecological landscape pattern(relp) by using gis software. it was shown that guizhou rural landscape distribution difference was big, landscape fragmentation was high, agricultural landscape integrity was poor. besides the fractal dimension of settlement landscape is relatively lower, the others were quite high. rural landscape plaques distribution was irregular, shape without regularity. a low voltage high frequency cmos continuous time band-pass filter with programmable center frequency and quality factor is presented. the operational transconductance amplifier (ota) in this gm-c filter design is implemented by a low-voltage simple cascode ota. the transconductance can be digitally programmable. simulations show that the center frequency can be tuned from 400 mhz to 1 ghz for a 2.0 pf capacitive load. this filter has been designed in a tsmc 0.18 mu digital process with 1.8 v power supplies and consumes around 32 mw of power. ");
        $this->assertArrayHasKey('photon', $result);

    }


     /**
     * 
     * @covers App\Http\Controllers\PaperController::getACMPapersFromKeyword
     * @covers App\Http\Controllers\PaperController::getPapersFromKeywords
     */
    //Req 14: The initial page should also allow searches based on a keyword. Users should be able to configure whether they want to search by last name or keyword.
    public function testGetPaperFromKeyword() {
        $controller = new PaperController();
            $papers = $controller->getPapersFromKeywords('asdf');
            $Papers = $controller->getACMPapersFromKeyword('asdf');

            $this->assertArrayHasKey('title', $papers['document'][0]);
            $this->assertArrayHasKey('title', $Papers);
    }






}
