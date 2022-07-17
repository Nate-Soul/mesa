<?php
require_once("../bootstrap/autoload.php");
Login::restrictVendors();
require_once(LAYOUTS_DIR."/user_header.inc.php");
?>
    <h2> User Orders </h2>
<?php
require_once(LAYOUTS_DIR."/user_footer.inc.php");
?>