
function pswd(){
	// var pas={
	// 	'a' : '1', 'b' : '2', 'c' : '3', 'd' : '4', 'e' : '5', 'f' : '6', 'g' : '7', 'h' : '8', 
	// 	'i' : '9', 'j' : '10', 'k' : '11', 'l' : '12', 'm' : '13', 'n' : '14', 'o' : '15', 'p' : '16',
	// 	'w' : '17', 'r' : '18', 's' : '19', 't' : '20', 'u' : '21', 'v' : '22', 'w' : '23', 'x' : '24',
	// 	 'y' : '25', 'z' : '26', '1' : '27', '2' : '28', '3' : '29', '4' : '30', '5' : '31', '6' : '32',
	// 	'7' : '33', '8' : '34', '9' : '35', '0' : '36'
	// }
	
	var pas       = '';
    var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    var max_position = words.length - 1;
    for( i = 0; i < 10; ++i ) {
        position = Math.floor ( Math.random() * max_position );
        pas = pas + words.substring(position, position + 1);
    }
    $('#pass').val(pas);
}

// $("#gen").click(function() {
//         $("#pass").val(pswd());       
// })

;
