<?php
// удаляем куки пользователя, после этого перенаправляем на индекс
setcookie("id", $idus, time()-23760, "/");
setcookie("idgroup", $idus, time()-23760, "/");
header("Location: index.php");

?>