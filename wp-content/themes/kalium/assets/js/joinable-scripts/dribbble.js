/**
* Dribbble.js
*
* @author Tim Davies
*/

/**
* Fetch and parse Dribbble JSON
*
* @param dribbbleID   int/string  Dribbble User ID or username
* @param elm          string      Dom Element ID to add the shots to (optional, defaults to 'shots')
* @param limit        int         Number of shots to draw (optional, defaults to 3)
*/

// Define Global Vars
var dribbble = {
	// How many shots to display
	shotLimit : 3,
	// The div ID to draw to
	element : 'shots',
	// How many users we're loading
	usersToLoad : 0,
	// All API results
	allShots : [],
	// Complete callback
	complete : function () {},
	// Shots sort function
	order : function (a,b) {
	  if (a.id > b.id)
		 return -1;
	  if (a.id < b.id)
		return 1;
	  return 0;
	}
}

function getShotsForID(users, elm, limit, callback)
{
	if(typeof dribbble.index != 'number')
	{
		dribbble.index = 0;
		dribbble.items = {};
	}
	
	dribbble.index++;
	
	/* Initialise funcation variables */
	dribbble.shotLimit = (!limit)? 3 : limit;
	dribbble.element = (!elm)? 'shots' : elm;
	dribbble.complete = callback || dribbble.complete;

	dribbble.usersToLoad = users.length;
	
	var parser_id = "parseShots" + dribbble.index;
	
	dribbble.items[parser_id] = {
		shotLimit: (!limit)? 3 : limit,
		element: (!elm)? 'shots' : elm,
		complete: callback || dribbble.complete,
	};
	
	window[parser_id] = function(shots)
	{
		var item = dribbble.items[parser_id];
		
		var htmlString = "\n<ul>\n"

		for(var i = 0; i < item.shotLimit; i++)
		{
			var shot = shots.shots[i];
			htmlString = htmlString+"\n<li class=\"dribbble_shot\">";
			htmlString = htmlString+"<a href=\""+shot.url+"\">";
			htmlString = htmlString+"<div class=\"dribbble-title\"><h3>"+shot.title+"</h3>";
			htmlString = htmlString+"</div>";
			htmlString = htmlString+"<img src=\""+shot.image_url+"\" alt=\""+shot.title+"\" />"; 
			htmlString = htmlString+"</a>";
			htmlString = htmlString+"</li>\n";
		}

		htmlString = htmlString + "\n</ul>\n";

		document.getElementById(item.element).innerHTML = htmlString;
		
		jQuery('#'+item.element).removeClass('is-loading');
		
		item.complete();
	}
	
	jQuery(document).ready(function ()
	{
		for(var indx in users)
		{
			var url = 'http://api.dribbble.com/players/'+users[indx]+'/shots?callback=' + parser_id; 	
			var myscript = document.createElement('script');
			myscript.src = url;
			document.body.appendChild(myscript);
		}
	});
}