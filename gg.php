<?php
$input_line='Aa8$aaaaaaa';
echo preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[%\$#@&\*\^\|\/~\{\}\[\]\\\])[A-Za-z\d%\$#@&\*\^\|\/~\{\}\[\]\\\]{8,}$/', $input_line);
?>