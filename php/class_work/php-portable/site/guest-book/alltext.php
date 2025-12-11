<?php
echo (file_get_contents('book.txt'));
echo ( "<a href=".$_SERVER['HTTP_REFERER'].">Вернуться</a>");
?>