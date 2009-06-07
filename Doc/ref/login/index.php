<?php # Script 16.5 - index.php
// This is the main page for the site.

// Include the configuration file:
require_once ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Welcome to this Site!';
include ('includes/header.html');

// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}!";
}
echo '</h1>';
?>
<p>This is a demo of a control panel registration, login system.. Users can register, login, logout, and do other things from here.<br />
Try it out!</p>

<?php // Include the HTML footer file:
include ('includes/footer.html');
?>
