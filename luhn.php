<?php

require_once 'Luhn.class.php';

$luhn = new Luhn();
$luhn->setNumeroCartao('4012001037141112');

if ($luhn->numeroValido()) {
    echo 'N�mero cart�o v�lido';
} else {
    echo 'N�mero cart�o inv�lido';
}