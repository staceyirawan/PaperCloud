Feature: Paper Page Options
	When User first enters the page
	the User has the ability to access
	all functionalities.

	Scenario: Downloading a paper
		Given I am on the paperlist page
		When I click on the download link of a paper
		Then a file is downloaded

	Scenario: Accessing the bibtex

	Scenario: Downloading paperlist in PDF and Plain Text
		Given I am on the paperlist page
		When I click export
		Then a plain text and PDF file will be downloaded with the paperlist
	Scenario: When on paper page clicking new author
		Given I am on the paperlist page
		When I click on another authors name
		Then a new search is initiated on that author

	Scenario: Clicking on conference name
		Given I am on the paperlist page
		When I click on a conference name
		Then I should see a list of papers from that conference clicked

	Scenario: Clicking on title
		Given I am on the paperlist page
		When I click on the title of a paper
		Then the abstract should be displayed with
		And the previous word should be highlighted in the abstract

	Scenario: Generating a subset wordcloud
		Given you are on the paperlist page
		When I click on checkboxes of specific papers
		Then a new word cloud should generate with these checked papers

	Scenario: Downloading highlighted paper
		Given that I am on the paper list page
		When I click to download a paper
		Then I should have a PDF file with the specified word highlighted