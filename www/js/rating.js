function rating_ready()
{
    $(".input").change(function(){
        if (parseInt(this.value)>parseInt(this.attributes.defvalue.value))
        $( this ).addClass("up").removeClass("down");
    
    if (parseInt(this.value)<parseInt(this.attributes.defvalue.value))
        $( this ).addClass("down").removeClass("up");
        if (parseInt(this.value)===parseInt(this.attributes.defvalue.value))
        $( this ).removeClass("up").removeClass("down");
    });
    console.log( "ready" );
}

    function send()
    {
    	//$.getScript("/js/jquery.redirect.js");
        var changes = [];
        var arse = $(".up").add(".down");
        arse.each(function(){
            changes.push({"id_t": $(this).attr("id_t"),"id_s": $(this).attr("id_s"),"score":$(this).val()});
        });
        if (changes.length>0)
        {
        	//var conf = confirm(JSON.stringify(changes));
        	//if (conf)
        		post(window.location.pathname,changes);
        }

    }

    function post(path, parameter) {
        var form = $('<form></form>');

        form.attr("method", "post");
        form.attr("action", path);
                    var field = $('<input />');
                    field.attr("type", "hidden");
                    field.attr("name", 'json');
                    field.attr("value", JSON.stringify(parameter));
                    form.append(field);

        $(document.body).append(form);
        form.submit();
    }

    function attendance_ready()
{
    $(".input").change(function(){
        if (this.checked!==this.defaultChecked)
        	$( this ).addClass("up");
		else
        	$( this ).removeClass("up");
    });
    console.log( "ready" );
}

    function attendance_send()
    {
    	//$.getScript("/js/jquery.redirect.js");
        var changes = [];
        var arse = $(".up");
        arse.each(function(){
            changes.push({"id_t": $(this).attr("id_t"),"id_s": $(this).attr("id_s"),"attendance":this.checked});
        });
        if (changes.length>0)
        {
        	//var conf = confirm(JSON.stringify(changes));
        	//if (conf)
        		post(window.location.pathname,changes);
        }

    }

