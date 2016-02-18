function translit(){
	var space = '_'; 

	var text = $('#name').val().toLowerCase();

	var transl = { 
					'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'е': 'e', 'ё': 'yo', 'ж': 'zh', 'з': 'z', 'и': 'i',
					'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p', 'р': 'r', 'с': 's', 'т': 't',
					'у': 'u', 'ф': 'f', 'х': 'h', 'ц': 'ts', 'ч': 'ch', 'ш': 'sh', 'щ': 'sch', 'ы': 'y',
					'э': 'e', 'ю': 'yu', 'я': 'ya',
					
					' ': space				
				 }
	
    var result = '';

	var ind = 0;
	
    for(i=0; i < text.length; i++) {
		if(transl[text[i]] != undefined) {
			if(text[i] != ' '){
				result += transl[text[i]];
				}
			else{						
				result += transl[text[i]];
				ind = i+1;
				break;
			}
		}				
	}

	if(transl[text[ind]] != undefined){
		if(i < text.length){
			result += transl[text[ind]];
		}	
	}	

	for(i=ind; i < text.length; i++) {
		if(text[i] == ' '){
			i++;
			break;
		}
	}	

	if(transl[text[i]] != undefined){
		if(i < text.length){
			result += transl[text[i]];
		}	
	}	
	
	$('#alias').val(result);
}


// $(function(){
// 	$('#name').keyup(function(){
// 		translit();
// 		return false;
// 	});
// })
;
