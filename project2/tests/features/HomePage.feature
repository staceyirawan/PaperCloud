
Feature: HomePage Author Search
	When User first enters the page
	the User has the ability to access
	all functionalities.

	@javascript
	Scenario: Searching for Authors as a User
		Given there is a textbox in the homePage web page
		When I add "Halfond" into the textbox
		And I click the search by scholar button
		Then I should see a word Cloud

	@javascript
	Scenario: Searching for Keywords as a User
		Given there is a textbox in the homePage web page
		When I add "Computer Science" into the textbox
		And I click search by keyword button
		Then I should see a word Cloud

	@javascript
	Scenario: Wordcloud generation progress bar
		Given a keyword or author is being searched
		Then when the button is clicked
		Then a progress bar will show the status of the cloud generation

	@javascript
	Scenario: Accessing previous searches
		Given the homepage
		And that I have previously searched last names or keyterms
		Then there should be a list of previous searches below the search bar

	@javascript
	Scenario: Top pages displayed
		Given that a word is searched on the search bar
		Then the words from the top papers that are most searched will be displayed in the form of a word cloud

	@javascript	
	Scenario: Searching for invalid author
		Given that an invalid author is input in the search box
		And the search button for author is pressed
		Then a pop up box will display an error message

	@javascript
	Scenario: Searching for invalid keyword
		Given that an invalid keyword is input in the search box
		And the search button for author is pressed
		Then a pop up box will display an error message



