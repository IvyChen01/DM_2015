function login()
{
	FB.login(function(response){});
}

function feed(link, picture)
{
	FB.ui(
	  {
	    method: 'feed',
	    name: 'Tecno app',
	    link: link,
	    picture: picture,
	    caption: 'Tecno app',
	    description: 'Tecno app'
	  },
	  function(response) {}
	);
}

function invite()
{
	FB.ui({method: 'apprequests',
	  message: 'Tecno'
	}, function (response){});
}

function addPage(redirect_uri)
{
	FB.ui({
	  method: 'pagetab',
	  redirect_uri: redirect_uri
	}, function(response){});
}
