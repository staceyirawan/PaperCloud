Feature: Author Search
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
	
	//Written by Jason	

	Scenario: Clicking on a word in the word cloud
		Given a word is clicked from the word cloud
		Then papers should be listed by word frequency
		And title, authors frequency, conference, and download links should be available
		Then clicking on column headers sort the column

	Scenario: Wordcloud generation progrss bar
		Given a keyword or author is being searched
		Then when the button is clicked
		Then a progress bar will show the status of the cloud generation

	Scenario: Accessing previous searches
		Given I am on the homepage
		And that I have previously searched last names or keyterms
		Then there should be a list of previous searches


	Scenario: Downloading an image of a generated wordcloud
		Given that I am on the home page and a wordcloud is made
		When I click on download wordcloud
		Then a image file should exist in my designated folder

	Scenario: Top pages displayed
		Given that a word is searched on the search bar
		Then the top pages are papers that are most searched in the form of a word cloud

	



