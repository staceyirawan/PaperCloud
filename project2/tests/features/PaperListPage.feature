Feature: Paper Page Options
	When User first enters the page
	the User has the ability to access
	all functionalities.

	Scenario: Post wordcloud navigation
		Given I clicked on a word from the word cloud
		Then I should see a page with lists of papers
		And column headers appropriately listed

	Scenario: Downloading a paper
		Given I am on the paperlist page
		When I click on the download link of a paper
		Then a file is downloaded

	Scenario: Accessing the bibtex

	Scenario: Downloading paperlist in PDF 
		Given I am on the paperlist page
		When I click export to PDF
		Then a PDF file will be downloaded with the paperlist

	Scenario: Downloading paperlist in plain text
		Given I am on the paperlist page
		When I click export to plain text
		Then a plain text will be downloaded with the paperlist

	Scenario: When on paper page clicking new author
		Given I am on the paperlist page
		When I click on another authors name
		Then a new search is initiated on that author
		And the user is navigated to the new word cloud page

	Scenario: Progress bar when new author is clicked
		Given I have clicked on a new author name
		And a new search and word cloud is generated
		Then a progress bar should respectively display the generation of the word cloud

	Scenario: Clicking on conference name
		Given I am on the paperlist page
		When I click on a conference name
		Then I should see a list of papers from that conference clicked

	Scenario: Clicking on title
		Given I am on the paperlist page
		When I click on the title of a paper
		Then the abstract should be displayed
		And the previous word should be highlighted in the abstract

	Scenario: Generating a subset wordcloud
		Given you are on the paperlist page
		When I click on checkboxes of specific papers
		And click on a button generate a new wordcloud
		Then a new word cloud should generate with these selected papers

	Scenario: Downloading highlighted paper
		Given that I am on the paper list page
		When I click to download a paper
		Then I should have a PDF file with the specified word highlighted

	Scenario: Back buttons
		Given that I am on the paperlist page
		When I click on the back button
		Then I should go back to the previous page with the wordcloud