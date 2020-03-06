function changeUrl(url) {

	var pathName = window.location.pathname; 
	pathName = pathName.split('/');
	var folder = pathName[1];

	history.replaceState(null,null,window.location.protocol + "//" + window.location.host +'/'+folder+'/'+url);

}

