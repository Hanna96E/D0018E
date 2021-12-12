<?php
//Start the session
session_start();
?>

<?php
session_unset(); 
session_destroy();
?>

<script>
	window.location.replace("/");
</script>