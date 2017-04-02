Feature: Paper Page Usage
	As a User having had entered 
	through the PaperListPage to access
	all functionalities.

	@javascript
	Scenario: Downloading a paper
		Given I am on the paperlist page
		When I click on the download link of a paper
		Then a file is downloaded

	@javascript
	Scenario: Downloading highlighted paper
		Given that I am on the paper list page
		When I click to download a paper
		Then I should have a PDF file with the specified word highlighted