Feature: HomePage Author Search
	When User first enters the page
	the User has the ability to access
	all functionalities.

	Scenario: Searching for Authors as a User
		Given there is a textbox in the homePage web page
		When I add "Halfond" into the textbox
		Then I should see suggestions in the dropdown box
		And I should have the ability to choose the paper from the cloud

	Scenario: Searching for Keywords as a User
		Given there is a textbox in the homePage web page
		When I add "Computer Science" into the textbox
		And I should have the ability to choose the paper from the cloud


	Scenario: Wordcloud generation progrss bar
		Given a keyword or author is being searched
		Then when the button is clicked
		Then a progress bar will show the status of the cloud generation

	Scenario: Accessing previous searches
		Given I am on the homepage
		And that I have previously searched last names or keyterms
		Then there should be a list of previous searches below the search bar


	Scenario: Top pages displayed
		Given that a word is searched on the search bar
		Then the top papers are papers that are most searched in the form of a word cloud

	



