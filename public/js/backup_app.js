//$(document).foundation();

function rating_change(rating){
	var output = '<option value="">Select Exact Score</option>';
	
	if (rating == "super"){
		var min_score = 90;
		for (i = min_score; i < (min_score + 11); i++){
			output += '<option value="' + (i) + '">' + (i) + '</option>';
		}
	}
	if (rating == "excellent"){
		var min_score = 80;
		for (i = min_score; i < (min_score + 10); i++){
			output += '<option value="' + (i) + '">' + (i) + '</option>';
		}
	}
	if (rating == "good"){
		var min_score = 70;
		for (i = min_score; i < (min_score + 10); i++){
			output += '<option value="' + (i) + '">' + (i) + '</option>';
		}
	}
	if (rating == "fair"){
		var min_score = 60;
		for (i = min_score; i < (min_score + 10); i++){
			output += '<option value="' + (i) + '">' + (i) + '</option>';
		}
	}
	if (rating == "poor"){
		var min_score = 50;
		for (i = min_score; i < (min_score + 10); i++){
			output += '<option value="' + (i) + '">' + (i) + '</option>';
		}
	}
	return output;
}