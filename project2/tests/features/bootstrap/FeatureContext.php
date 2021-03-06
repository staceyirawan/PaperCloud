<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, SnippetAcceptingContext
{

    private $homePageStatus;
    private $paperListPageStatus;
    private $paperPageStatus;
    private $wordCloudStatus;
    public $driver;
    public $session;
    public $page;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        // $this->homePageStatus = new HomePageStatus();
        //$session->executeScript('document.body.firstChild.innerHTML = "";');
        // $driver = new \Behat\Mink\Driver\GoutteDriver();
        // $session = new \Behat\Mink\Session($driver);
        // $session->start();
        // $session->visit('http://127.0.0.1:8000/');

    }


    /**
     * @Given there is a textbox in the homePage web page
     */
    public function thereIsATextboxInTheHomepageWebPage()
    {
        // $driver = new \Behat\Mink\Driver\GoutteDriver();
        $driver = new \Behat\Mink\Driver\Selenium2Driver();
        
        // $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://localhost:8000');
        $page = $session->getPage();
        $textbox = $page->findField("myText");
        if(null === $textbox){
            throw new Exception('The element is not found');
        }
        $session->stop();
    }

    /**
     * @When I add :arg1 into the textbox
     */
    public function iAddIntoTheTextbox($arg1)
    {
        // $driver = new \Behat\Mink\Driver\GoutteDriver();
        // $driver = new \Behat\Mink\Driver\Selenium2Driver();

        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue($arg1);
        echo $textbox->getValue();
        if($textbox->getValue() != $arg1){
            throw new Exception('The insertion was unsuccessful');
        }
        $session->stop();
        
    }

    // /**
    //  * @Then I should see :suggestions in the :dropdown box
    //  */
    // public function iShouldSeeSuggestionsInTheDropdownBox($suggestions, $dropdown)
    // {
    //     $allSuggestionsAreHere = true;
    //     for ($k = 0; $k< sizeof($suggestions); $k++) 
    //     {   
    //         $suggestionIsHere = false;
    //         for ($j = 0; $j <sizeof($dropdown); $j++)
    //         {
    //             if($suggestions[$k] == $dropdown[$j])
    //             {
    //                 $suggestionIsHere = true;
    //             }
    //         }
    //         if(!$suggestionIsHere)
    //         {
    //             $allSuggestionsAreHere = false;
    //         }
    //     }
    // }

    /**
     * @Then I should see a word Cloud
     */
    public function iShouldSeeAWordCloud()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @When I click the search by scholar button
     */
    public function iClickTheSearchByScholarButton()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        if(null === $button){
            throw new Exception('The element is not found');
        }
        $session->stop();
    }

    /**
     * @When I click search by keyword button
     */
    public function iClickSearchByKeywordButton()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Computer Science");
        $button = $page->findButton('keywordButton');
        $button->mouseOver();
        $button->click();
        if(null === $button){
            throw new Exception('The element is not found');
        }
        $session->stop();
    }


    /**
     * @Given a :keyword or :author is being searched
     */
    public function aKeywordOrAuthorIsBeingSearched($keyword, $author)
    {
        if ($keyword == NULL and $author == NULL)
        {
            return false;
        }
    }

    /**
     * @Then when the :button is clicked
     */
    public function whenTheButtonIsClicked($button)
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        if(null === $button){
            throw new Exception('The element is not found');
        }
        $session->stop();

    }

    /**
     * @Then a progress bar will show the status of the cloud generation
     */
    public function aProgressBarWillShowTheStatusOfTheCloudGeneration()
    {
        // throw new PendingException();
    }

    /**
     * @Given the homepage
     */
    public function theHomepage()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000');
        $webString = "http://127.0.0.1:8000/";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect. :".$session->getCurrentUrl() );
        }
        // throw new PendingException();
    }

    /**
     * @Given that I have previously searched last names or keyterms
     */
    public function thatIHavePreviouslySearchedLastNamesOrKeyterms()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $previousWord = $page->findById("prev2");  
        if ($previousWord == null) {
            throw new Exception("There is no previous word found");
        }
        $previousWord->mouseOver();
        $previousWord->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/keyword/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @Then there should be a list of previous searches below the search bar
     */
    public function thereShouldBeAListOfPreviousSearchesBelowTheSearchBar()
    {
        // throw new PendingException();
    }

    /**
     * @Given that a word is searched on the search bar
     */
    public function thatAWordIsSearchedOnTheSearchBar()
    {
        // throw new PendingException();
    }

    /**
     * @Then the words from the top papers that are most searched will be displayed in the form of a word cloud
     */
    public function theWordsFromTheTopPapersThatAreMostSearchedWillBeDisplayedInTheFormOfAWordCloud()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        }

        //almost finished??? Don't know.
    }


    /**
     * @Given I clicked on a word from the word cloud
     */
    public function iClickedOnAWordFromTheWordCloud()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
    }

    /**
     * @Then I should see a page with lists of papers
     */
    public function iShouldSeeAPageWithListsOfPapers()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        // var_export($session->getCurrentUrl);
        // $wordCloud = $page->find("wordcloud");
        // if ()
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @Then column headers appropriately listed
     */
    public function columnHeadersAppropriatelyListed()
    {
        // throw new PendingException();
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        $page = $session->getPage();




        // This is almost done. ask Stacey for table stuff.
    }

    /**
     * @Given I am on the paperlist page
     */
    public function iAmOnThePaperlistPage()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        // var_export($session->getCurrentUrl);
        // $wordCloud = $page->find("wordcloud");
        // if ()
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $session->stop();
    }

    /**
     * @When I click export to PDF
     */
    public function iClickExportToPdf()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $pdfButton = $page->findById("downloadButton0");
        $pdfButton->mouseOver();
        $pdfButton->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }
        $session->wait(5000);
        $session->stop();

    }

    /**
     * @Then a PDF file will be downloaded with the paperlist
     */
    public function aPdfFileWillBeDownloadedWithThePaperlist()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $pdfButton = $page->findById("downloadButton0");
        $pdfButton->mouseOver();
        $pdfButton->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }

        // try to look for some pop up
        $session->stop();
    }

    // @javascript
    // Scenario: Downloading paperlist in plain text
    //     Given I am on the paperlist page
    //     When I click export to plain text
    //     Then a plain text will be downloaded with the paperlist

    // /**
    //  * @When I click export to plain text
    //  */
    // public function iClickExportToPlainText()
    // {
    //     $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
    //     $session = new \Behat\Mink\Session($driver);
    //     $session->start();
    //     $session->visit('http://127.0.0.1:8000/');
    //     $page = $session->getPage();
    //     $textbox = $page->findField("myText");  
    //     $textbox->setValue("Halfond");
    //     $button = $page->findButton('scholarButton');
        // $button->mouseOver();
    //     $button->click();
    //     $page = $session->getPage();
    //     $webString = "http://localhost:8000/papers/scholar/Halfond/10";
    //     if ($session->getCurrentUrl() != $webString) 
    //     {
    //         throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
    //         // throw new PendingException();
    //     }
    //     $wordClicked = $page->findLink("can");
    // checkIfNull($wordClicked);
    // if($wordClicked == null)
    //     {
    //         throw new Exception ("There is no word: ".$wordClicked);
    //     }
        // $wordClicked->mouseOver();
    //     $wordClicked->click();
    //     $webString = "http://localhost:8000/list/can";
    //     if ($session->getCurrentUrl() != $webString) 
    //     {
    //         throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
    //         // throw new PendingException();
    //     }
    //     $bibTexButton = $page->findLink("bibtex1");
        // $bibTexButton->mouseOver();
    //     $wordClicked->click();
    //     $webString = "http://localhost:8000/list/can/bibtex1";
    //     if ($session->getCurrentUrl() != $webString) 
    //     {
    //         throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
    //         // throw new PendingException();
    //     }

    //     $session->stop();
    // }

    // *
    //  * @Then a plain text will be downloaded with the paperlist
     
    public function aPlainTextWillBeDownloadedWithThePaperlist()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
    checkIfNull($wordClicked);
    if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $plainTextButton = $page->findLink("downloadButton1");
        $plainTextButton->mouseOver();
        $plainTextButton->click();
        //$webString = "http://localhost:8000/list/can/bibtex1";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }

        // try to look for some pop up

        $session->stop();
    }

    /**
     * @When I click on another authors name
     */
    public function iClickOnAnotherAuthorsName()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $authorName = $page->findLink("Alex Orso");
        if($authorName == null)
        {
            throw new Exception ("There is no author: ".$authorName);
        }
        $authorName->mouseOver();
        $authorName->click();
    }

    /**
     * @Then a new search is initiated on that author
     */
    public function aNewSearchIsInitiatedOnThatAuthor()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $authorName = $page->findLink("Alex Orso");
        if($authorName == null)
        {
            throw new Exception ("There is no author: ".$authorName);
        }
        $authorName->mouseOver();
        $authorName->click();
        // THis is part of checking if it's on the right word Cloud.
        $webString = "http://localhost:8000/papers/scholar/%20%20Alex%20Orso/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @Then the user is navigated to the new word cloud page
     */
    public function theUserIsNavigatedToTheNewWordCloudPage()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $authorName = $page->findLink("Alex Orso");
        if($authorName == null)
        {
            throw new Exception ("There is no author: ".$authorName);
        }
        $authorName->mouseOver();
        $authorName->click();
        // THis is part of checking if it's on the right word Cloud.
        $webString = "http://localhost:8000/papers/scholar/%20%20Alex%20Orso/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @Given I have clicked on a new author name
     */
    public function iHaveClickedOnANewAuthorName()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $authorName = $page->findLink("Alex Orso");
        if($authorName == null)
        {
            throw new Exception ("There is no author: ".$authorName);
        }
        $authorName->mouseOver();
        $authorName->click();
        // THis is part of checking if it's on the right word Cloud.
        $webString = "http://localhost:8000/papers/scholar/%20%20Alex%20Orso/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @Given a new search and word cloud is generated
     */
    public function aNewSearchAndWordCloudIsGenerated()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $authorName = $page->findLink("Alex Orso");
        if($authorName == null)
        {
            throw new Exception ("There is no author: ".$authorName);
        }
        $authorName->mouseOver();
        $authorName->click();
        // THis is part of checking if it's on the right word Cloud.
        $webString = "http://localhost:8000/papers/scholar/%20%20Alex%20Orso/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @Then a progress bar should respectively display the generation of the word cloud
     */
    public function aProgressBarShouldRespectivelyDisplayTheGenerationOfTheWordCloud()
    {
        // throw new PendingException();
    }

    /**
     * @When I click on a conference name
     */
    public function iClickOnAConferenceName()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $conferenceClicked = $page->findLink("2016 IEEE International Conference on Software Maintenance and Evolution (ICSME)");
        if($conferenceClicked == null)
        {
            throw new Exception ("There is no conference access");
        }
        $conferenceClicked->mouseOver();
        $conferenceClicked->click();
    }

    /**
     * @Then I should see a list of papers from that conference clicked
     */
    public function iShouldSeeAListOfPapersFromThatConferenceClicked()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $conferenceClicked = $page->findLink("2016 IEEE International Conference on Software Maintenance and Evolution (ICSME)");
        $conferenceClicked->mouseOver();
        $conferenceClicked->click();
        $webString = "http://localhost:8000/conference/2016%20IEEE%20International%20Conference%20on%20Software%20Maintenance%20and%20Evolution%20(ICSME)";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @When I click on the title of a paper
     */
    public function iClickOnTheTitleOfAPaper()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $titleClicked = $page->findLink("Detecting");
        // checkIfNull($titleClicked);
        if($titleClicked == null)
        {
            throw new Exception ("There is no title: ".$titleClicked);
        }
        $titleClicked->mouseOver();
        $titleClicked->click();
    }

    /**
     * @Then the abstract should be displayed
     */
    public function theAbstractShouldBeDisplayed()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $titleClicked = $page->findLink("Detecting");
        // checkIfNull($titleClicked);
        if($titleClicked == null)
        {
            throw new Exception ("There is no word: ".$titleClicked);
        }
        $titleClicked->mouseOver();
        $titleClicked->click();

        $webString = "http://localhost:8000/abstract/Detecting%20and%20Localizing%20Visual%20Inconsistencies%20in%20Web%20Applications/can";
        if ($session->getCurrentUrl() != $webString)
        {
            throw new Execption("The page is incorrect.".$session->getCurrentUrl());
        }
    }

    /**
     * @Then the previous word should be highlighted in the abstract
     */
    public function thePreviousWordShouldBeHighlightedInTheAbstract()
    {
        // throw new PendingException();
    }

    

    /**
     * @Given you are on the paperlist page
     */
    public function youAreOnThePaperlistPage()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @When I click on checkboxes of specific papers
     */
    public function iClickOnCheckboxesOfSpecificPapers()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        for($i=1;$i<=3;$i++)
        {  
            $currentCheckBox = $page->findById("box".$i);
            if($wordClicked == null) {
                throw new Exception("There is no checkbox:".$currentCheckBox);
            }
            $currentCheckBox->mouseOver();
            $currentCheckBox->click();
        }
        
    }

    /**
     * @When click on a button generate a new wordcloud
     */
    public function clickOnAButtonGenerateANewWordcloud()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        for($i=1;$i<=3;$i++)
        {  
            $currentCheckBox = $page->findById("box".$i);
            if($wordClicked == null) {
                throw new Exception("There is no checkbox:".$currentCheckBox);
            }
            $currentCheckBox->mouseOver();
            $currentCheckBox->click();
        }
        $buttonClicked = $page->findById("downloadButton2");

    }

    /**
     * @Then a new word cloud should generate with these selected papers
     */
    public function aNewWordCloudShouldGenerateWithTheseSelectedPapers()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        for($i=1;$i<=3;$i++)
        {  
            $currentCheckBox = $page->findById("box".$i);
            if($wordClicked == null) {
                throw new Exception("There is no checkbox:".$currentCheckBox);
            }
            $currentCheckBox->mouseOver();
            $currentCheckBox->click();
        }
        $buttonClicked = $page->findById("downloadButton2");
        $webString = "http://localhost:8000/papers/subset/ftttff";
        if ($session->getCurrentUrl() == $webString) {
            throw new Exception("New word cloud was not generated:".$session->getCurrentUrl());
        }
    }

    /**
     * @When I click on the download link of a paper
     */
    public function iClickOnTheDownloadLinkOfAPaper()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        for($i=1;$i<=3;$i++)
        {  
            $currentCheckBox = $page->findById("box".$i);
            if($wordClicked == null) {
                throw new Exception("There is no checkbox:".$currentCheckBox);
            }
            $currentCheckBox->mouseOver();
            $currentCheckBox->click();
        }
        $buttonClicked = $page->findById("pdf1");
        if($buttonClicked == null) {
            throw new Exception("There is no link");
        }
        $buttonClicked->mouseOver();
        $buttonClicked->click();

    }

    /**
     * @Then a file is downloaded
     */
    public function aFileIsDownloaded()
    {
        // throw new PendingException();
    }

    /**
     * @Given that I am at the paper list page
     */
    public function thatIAmAtThePaperListPage()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
    }

    /**
     * @When I click to download a paper
     */
    public function iClickToDownloadAPaper()
    {
       $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        for($i=1;$i<=3;$i++)
        {  
            $currentCheckBox = $page->findById("box".$i);
            if($wordClicked == null) {
                throw new Exception("There is no checkbox:".$currentCheckBox);
            }
            $currentCheckBox->mouseOver();
            $currentCheckBox->click();
        }
        $buttonClicked = $page->findById("pdf1");
        if($buttonClicked == null) {
            throw new Exception("There is no link");
        }
        $buttonClicked->mouseOver();
        $buttonClicked->click();
    }

    /**
     * @Then I should have a PDF file with the specified word highlighted
     */
    public function iShouldHaveAPdfFileWithTheSpecifiedWordHighlighted()
    {
        // throw new PendingException();
    }

    /**
     * @Given a word is clicked from the word cloud
     */
    public function aWordIsClickedFromTheWordCloud()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
    }

    /**
     * @Then papers should be listed by word frequency
     */
    public function papersShouldBeListedByWordFrequency()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        // checkIfNull($wordClicked);
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
    }

    /**
     * @Then title, authors frequency, conference, and download links should be available
     */
    public function titleAuthorsFrequencyConferenceAndDownloadLinksShouldBeAvailable()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $page = $session->getPage();
        $frequencyCheck = $page->findById("freq1");
        if($frequencyCheck == null) {
            throw new Exception("The frequency is incorrect");
        }
    }

    /**
     * @Then clicking on column headers sort the column
     */
    public function clickingOnColumnHeadersSortTheColumn()
    {
        // throw new PendingException();
    }

    /**
     * @Given that I am on the home page and a wordcloud is made
     */
    public function thatIAmOnTheHomePageAndAWordcloudIsMade()
    {
        // throw new Exception ("the page is incorrect.");
    }

    /**
     * @When I click on download wordcloud
     */
    public function iClickOnDownloadWordcloud()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $buttonClicked = $page->findById("downloadButton");
        if($buttonClicked == null) {
            throw new Exception("There is no button");
        }
        $buttonClicked->mouseOver();
        $buttonClicked->click();
        
    }

    /**
     * @When I click bibtex
     */
    public function iClickBibtex()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $page = $session->getPage();
        $bibtexClick = $page->findById("bibtex1");
        $bibtexClick->mouseOver();
        $bibtexClick->click();
        $session->stop();
    }

    /**
     * @Then the bibtex should appear
     */
    public function theBibtexShouldAppear()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
        $page = $session->getPage();
        $webString = "http://localhost:8000/papers/scholar/Halfond/10";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $wordClicked = $page->findLink("can");
        if($wordClicked == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $wordClicked->mouseOver();
        $wordClicked->click();
        $webString = "http://localhost:8000/list/can";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $page = $session->getPage();

        $bibtexClick = $page->findById("bibtex1");
        if($bibtexClick == null)
        {
            throw new Exception ("There is no word: ".$wordClicked);
        }
        $bibtexClick->mouseOver();
        $bibtexClick->click();
        $webString = "http://localhost:8000/bibtex/WASP:%20Protecting%20Web%20Applications%20Using%20Positive%20Tainting%20and%20Syntax-Aware%20Evaluation/IEEE";
        if ($session->getCurrentUrl() != $webString) 
        {
            throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
            // throw new PendingException();
        }
        $session->stop();
    }

    /**
     * @Then a image file should exist in my designated folder
     */
    public function aImageFileShouldExistInMyDesignatedFolder()
    {
        // throw new PendingException();
    }

    /**
     * @Given that I am at the paperlist page
     */
    public function thatIAmAtThePaperlistPage2()
    {
        // $driver = new \Behat\Mink\Driver\GoutteDriver();
        // $session = new \Behat\Mink\Session($driver);
        // $session->start();
        // $session->visit('http://127.0.0.1:8000/');
        // $page = $session->getPage();
        // if(null === $page){
        //     throw new Exception('The element is not found');
        // }
    }

    /**
     * @Given that I am on the paper list page
     */
    public function thatIAmOnThePaperListPage2()
    {
        // throw new PendingException();
    }

    /**
     * @Given that an invalid author is input in the search box
     */
    public function thatAnInvalidAuthorIsInputInTheSearchBox()
    {
        // throw new PendingException();
    }

    /**
     * @Given the search button for author is pressed
     */
    public function theSearchButtonForAuthorIsPressed()
    {
        $driver = new \Behat\Mink\Driver\Selenium2Driver('firefox');
        $session = new \Behat\Mink\Session($driver);
        $session->start();
        $session->visit('http://127.0.0.1:8000/');
        $page = $session->getPage();
        $textbox = $page->findField("myText");  
        $textbox->setValue("Halfond");
        $button = $page->findButton('scholarButton');
        $button->mouseOver();
        $button->click();
    }

    /**
     * @Then a pop up box will display an error message
     */
    public function aPopUpBoxWillDisplayAnErrorMessage()
    {
        // throw new PendingException();
    }

    /**
     * @Given that an invalid keyword is input in the search box
     */
    public function thatAnInvalidKeywordIsInputInTheSearchBox()
    {
        // throw new PendingException();
    }

    /**
    * This is just getting the function so less clutter.
    */

    // public function checkIfNull($wordClicked)
    // {
    //     if($wordClicked == null)
    //     {
    //         throw new Exception ("There is no word: ".$wordClicked);
    //     } 
    // }

    //almost u s   e   l ss ees 
    // $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }// $pdfButton = $page->findById("pdf1");
        // $pdfButton->mouseOver();
        // $wordClicked->click();
        // $webString = "http://localhost:8000/list/can/pdfDowload";
        // if ($session->getCurrentUrl() != $webString) 
        // {
        //     throw new Exception ("The page is incorrect.".$session->getCurrentUrl());
        //     // throw new PendingException();
        // }
}
