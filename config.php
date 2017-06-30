define('DB_DRIVER', 'mysql');
define('DB_SERVER', 'localhost');
define('DB_SERVER_USERNAME', 'root');
define('DB_SERVER_PASSWORD', '');
define('DB_DATABASE', 'pre_enrollment');
 
// set site path and redirect URL
/* make sure the url end with a trailing slash */
define("SITE_URL", "http://demo.phphive.info/login_system_with_google/");
/* the page where you will be redirected for authorzation */
define("REDIRECT_URL", SITE_URL."login.php");
 
/* * ***** Google related activities start ** */
define("CLIENT_ID", "Your App CLIENT_ID Here"); 
define("CLIENT_SECRET", "Your App CLIENT_SECRET Here");
 
// retreive information from user based on scope/permission
define("SCOPE", 'https://www.googleapis.com/auth/userinfo.email '.
		'https://www.googleapis.com/auth/userinfo.profile' );
 
/* logout both from Google and your site **/
define("LOGOUT_URL", "https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=". urlencode(SITE_URL."logout.php"));