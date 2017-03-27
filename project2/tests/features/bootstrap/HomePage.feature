Feature: Author Search
	When User first enters the page
	the User has the ability to access
	all functionalities.

	Scenario: Searching for Authors or Keywords as a User
		Given there is a textbox in the homePage web page
		When I add "Halfond" into the textbox
		Then I should see suggestions in the dropdown box
		And I should have the ability to choose the paper