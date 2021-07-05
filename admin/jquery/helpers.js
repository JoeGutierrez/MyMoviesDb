function articlesFirst(str) {
	if(str.substr(str.lastIndexOf(', The'), 5) === ', The') {
		str = 'The ' + str.substr(0, str.length - 12) + str.substr(-7);
	}
	else if(str.substr(str.lastIndexOf(', An'), 4) === ', An') {
		str = 'An ' + str.substr(0, str.length - 11) + str.substr(-7);
	}
	else if(str.substr(str.lastIndexOf(', A'), 3) === ', A') {
		str = 'A ' + str.substr(0, str.length - 10) + str.substr(-7);
	}
	return str;
// str.substr(str.lastIndexOf(', The'), 5) means: get the last index of ", The" in the string and from there, return the next five characters, e.g.: ", The".
// str.substr(0, str.length - 12) means: start at position 0 of the string, return the specified amount of characters resulting from the length of the string minus 12 (the 12 chars. in ", The (2014)").
// str.substr(-7) means: return the last 7 characters of the string, e.g.: " (2014)".
} // Added: 09/22/2014. Source: http://stackoverflow.com/questions/25970531/javascript-substr-get-characters-in-the-middle-of-the-string (Shai's answer.)
