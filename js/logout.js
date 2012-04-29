 var logoutButton = {
		 init: function(config) {
			 this.config = config;
			 this.config.button.on('click', this.logout);
		 },
		 
		 logout: function() {
			 logoutButton.deleteCookie('lcc-user-id');
			 logoutButton.deleteCookie('lcc-admin');
			 if (logoutButton.getCookie("lcc-remember") == "false") {
				 logoutButton.deleteCookie('lcc-username');
				 logoutButton.deleteCookie('lcc-remember');
			 }
			 window.location.href = "/index.php"
		 },
		 
		 deleteCookie: function(name) {
			document.cookie = name + '=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
		 },
		 
		 getCookie: function getCookie(name) {
			 var results = document.cookie.match ( '(^|;) ?' + name + '=([^;]*)(;|$)' );
			 if (results)
				 return (unescape(results[2]));
			 else
				 return null;
		 }
 }
 
 logoutButton.init({
	 button: jQuery("#logout")
 });