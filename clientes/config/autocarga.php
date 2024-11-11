<?php
spl_autoload_register(function ($clase) {
    include "clases/$clase.php";
});
