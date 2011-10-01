function change_layout(layout) {
	var url;
	switch (layout) {
		case 'content' : url = 'index.php/app_init/index/content'; break;
		case 'body' : url = 'index.php/app_init/index/body'; break;
	}
	$('body').load(url);
	
	return false;
}

function cek_offline() {
	if (!navigator.onLine){
		alert('WARNING !!! SERVER IS OFFLINE ... PLEASE CHECK YOUR BROWSER OR CONTACT ADMINISTRATOR');
		close();
	}
	return false;
}

cek_offline();