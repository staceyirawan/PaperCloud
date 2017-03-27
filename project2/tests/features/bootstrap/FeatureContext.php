<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there is a textbox in the homePage web page
     */
    public function thereIsATextboxInTheHomepageWebPage()
    {
        throw new PendingException();
    }

    /**
     * @When I add :arg1 into the textbox
     */
    public function iAddIntoTheTextbox($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see suggestions in the dropdown box
     */
    public function iShouldSeeSuggestionsInTheDropdownBox()
    {
        throw new PendingException();
    }

    /**
     * @Then I should have the ability to choose the paper
     */
    public function iShouldHaveTheAbilityToChooseThePaper()
    {
        throw new PendingException();
    }

    /**
     * @Given there is a input in the textbox in the homePage
     */
    public function thereIsAInputInTheTextboxInTheHomepage()
    {
        throw new PendingException();
    }

    /**
     * @Given I haven't clicked the user yet
     */
    public function iHavenTClickedTheUserYet()
    {
        throw new PendingException();
    }

    /**
     * @Then there should be a drop down box
     */
    public function thereShouldBeADropDownBox()
    {
        throw new PendingException();
    }
}
