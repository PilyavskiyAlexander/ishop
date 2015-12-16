<?php
setcookie('name', null, time()-5000, '/');
?>	
<script>
setTimeout(function(){window.location = '../index.php';}, 300);

</script>

