Feature: Word Cloud
	Having searched a keyword or an author
	I as a user will have the ability to use the 
	functionalities of the word cloud page

	Scenario: Clicking on a word in the word cloud
		Given a word is clicked from the word cloud
		Then papers should be listed by word frequency
		And title, authors frequency, conference, and download links should be available
		Then clicking on column headers sort the column

	Scenario: Downloading an image of a generated wordcloud
		Given that I am on the home page and a wordcloud is made
		When I click on download wordcloud
		Then a image file should exist in my designated folder