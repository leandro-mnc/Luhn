<?php

require_once 'Luhn.class.php';

$luhn = new Luhn();
$luhn->setNumeroCartao('4012001037141112');

if ($luhn->numeroValido()) {
    echo 'Número cartão válido';
} else {
    echo 'Número cartão inválido';
}