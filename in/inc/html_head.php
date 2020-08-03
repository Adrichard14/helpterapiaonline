    <script>
        Object.defineProperty(HTMLScriptElement.prototype, 'src', {
            get: function() {
                return this.getAttribute('src')
            },
            set: function(url) {
                var prefix = "http://";

                if (url.startsWith(prefix))
                    url = "https://" + url.substr(prefix.length);

                console.log('being set: ' + url);
                this.setAttribute('src', url);
            }
        });
    </script>
	<?php $app_author = "Ship Tecnologia da informãção"; ?>
		<title>Marina - <?php echo PROJECT_NAME; ?></title>
		<!-- start: META -->
		<meta charset="utf-8" />
		<!--[if IE]><meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" /><![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="Marina, versão exclusiva de <?=PROJECT_NAME?>." name="description" />
		<meta content="<?php echo $app_author?>" name="author" />
		<!-- end: META -->
		<!-- start: MAIN CSS -->
        <?php
			$css = 'assets/css/';
			$fonts = 'assets/fonts/';
			$plugins = 'lib/plugins/';
			$scripts = array(
				$plugins.'bootstrap/css/bootstrap.min.css" media="screen',
				$plugins.'font-awesome/css/font-awesome.min.css',
				$fonts.'style.css',
				$css.'main.css?v=1.01',
				$css.'main-responsive.css',
				$plugins.'iCheck/skins/all.css',
				$plugins.'perfect-scrollbar/src/perfect-scrollbar.css',
				$css.'theme_light.css',
				$css.'jquery.datetimepicker.css',
				$css.'imgareaselect-default.css',
                $plugins.'gritter/css/jquery.gritter.css',
                $plugins.'jquery-ui-1.12.1.custom/jquery-ui.min.css',
                $plugins.'select2/select2.css',
                $plugins.'select2/select2-bootstrap.css',
                $plugins.'summernote/summernote.css',
                $plugins.'slim/slim.min.css'
			);
			Page::script($scripts, "css");
		?>
		<!--[if IE 7]>
        <?php Page::script($plugins.'font-awesome/css/font-awesome-ie7.min.css', 'css'); ?>
		<![endif]-->
		<!-- end: MAIN CSS -->
        <?php Page::script('assets/images/m.png', 'shortcut icon'); ?>
        <style>
            #title_parent #title_ifr { height: 60px !important; }img {max-width: 100%; }
            @media screen and (max-width: 767px) {
                table .dropdown-toggle {
                    float: none !important;
                }
                table .open .dropdown-menu {
                    float: none !important;
                    display: block !important;
                    position: relative !important;
                    top: auto !important;
                    left: auto !important;
                    right: auto !important;
                }
            }
        </style>