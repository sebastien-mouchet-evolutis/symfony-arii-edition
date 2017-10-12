var args = require('system').args;
args.forEach(function(arg, i) {
    console.log(i+':	'+arg);
});

var app=args[2];
if (app=='_ALL_') {
	app='*';
}

var page = require("webpage").create(),
    url = 'http://'+args[1]+'/app_dev.php/report/fr/public/dashboard?app='+app+'&env='+args[3]+'&month='+args[4]+'&ref_past='+args[5]+'';
    console.log('url:	'+url);

page.open(url, function (status) {
    function checkReadyState() {
        setTimeout(function () {
            var loaded = page.evaluate(function () {
                return loaded;
            });
			console.log('.');
            if (loaded) {
				var file = 'dashboard_'+args[2]+'_'+args[3]+'_'+args[4];
				page.render(args[6]+'/'+file+'.jpg', {format: 'jpeg', quality: '100'});
				page.render(args[6]+'/'+file+'.pdf', {format: 'pdf'});

				phantom.exit();
            } else {
                checkReadyState();
            }
        },1000);
    }

    checkReadyState();
});