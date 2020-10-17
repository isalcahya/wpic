import $ from 'jquery';

class test {
	constructor(){
		console.log($);
	}
}

$(document).ready( () => {
	(new test())
} )