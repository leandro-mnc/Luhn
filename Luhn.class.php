<?php

/**
 * Validação de número de cartão de crédito
 *
 * @author Leandro Teixeira <leandro_mnc@yahoo.com.br>
 */
class Luhn
{
    /**
     * @var String
     */
    private $numeroCartao = '';

    /**
     * @var int
     */
    private $numeroCartaoSemDigito = '';

    /**
     * @var int
     */
    private $digitoVerificador = '';

    public function __construct($numeroCartao = '')
    {
        $this->setNumeroCartao($numeroCartao);
    }

    /**
     * Seta o numero do cartão
     *
     * @param string $numeroCartao
     */
    public function setNumeroCartao($numeroCartao)
    {
        $this->numeroCartao = $numeroCartao;
        return $this;
    }

    /**
     * Setá o número do cartão sem digito verificador
     * e pega o digito verificador
     *
     * @return void
     */
    protected function setNumeroCartaoSemDigito() {
        $len = strlen($this->numeroCartao);
        if ($len === 0) {
            return ;
        }

        $this->numeroCartaoSemDigito = substr($this->numeroCartao, 0, $len - 1);
        $this->digitoVerificador = (int) substr($this->numeroCartao, $len - 1, 1);
    }

    /**
     * Verifica se o número do cartão foi passado corretamente
     *
     * @returns {Boolean}
     */
    protected function numeroPreenchido() {
        $numeroValido = preg_match('/^[0-9]{13,19}$/', $this->numeroCartao);
        return $numeroValido === 1;
    }

    /**
     * Multiplicação para validação
     *
     * @returns {Number}
     */
    protected function multiplicaESoma() {
        $cont = 0;
        $soma = 0;
        for ($i=0;$i<strlen($this->numeroCartaoSemDigito);$i++) {
            $numeroAtual = (int) $this->numeroCartaoSemDigito{$i};
            if ($cont++ % 2 === 0) { // Par
                $soma += (int) $numeroAtual * 2;
            } else {
                $soma += (int) $numeroAtual * 1;
            }
        }
        return $soma;
    }

    /**
     * Faz o cálculo do resto da divisão do cálculo 
     * de multiplicação do número do cartão
     *
     * @returns {Number}
     */
    protected function calculoRestoDivisao($valor) {
        if ($valor === 0) {
            return 0;
        }
        return $valor % 10;
    }

    /**
     * Efetua a validação do número do cartão
     *
     * @returns {boolean}
     */
    public function numeroValido() {
        if ($this->numeroPreenchido() !== true) {
            throw new Exception('Número de Cartão precisa ser somente número válido, entre 13 e 19 caracteres!');
        }

        // Seta o número do cartão sem o digito e o digito verificador
        $this->setNumeroCartaoSemDigito();

        // Regra de multiplicação e soma
        $soma = $this->multiplicaESoma();

        // Resto da divisão do valor multiplicado e somado
        $restoDivisao = $this->calculoRestoDivisao($soma);

        // Pega o digito verificador do número do cartão
        $dv = 10 - $restoDivisao;

        return $dv === $this->digitoVerificador;
    }
}
