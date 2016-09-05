/**
 * Valida��o de n�mero de cart�o de cr�dito
 *
 * @author Leandro Teixeira <leandro_mnc@yahoo.com.br>
 */
function Luhn() {
    var self = this;
    /**
     * @type String
     */
    self.numeroCartao = '';

    /**
     * @type String
     */
    self.numeroCartaoSemDigito = '';

    /**
     * @type Number
     */
    self.digitoVerificador = '';

    /**
     * Set� o n�mero do cart�o
     * @returns {Undefined}
     */
    self.setNumeroCartao = function(value) {
        self.numeroCartao = value;
    };

    /**
     * Set� o n�mero do cart�o sem digito verificador
     * e pega o digito verificador
     *
     * @returns {Undefined}
     */
    self.setNumeroCartaoSemDigito = function() {
        var len = self.numeroCartao.length;
        if (len === 0) {
            return ;
        }

        self.numeroCartaoSemDigito = self.numeroCartao.substr(0, len - 1);
        self.digitoVerificador = parseInt(self.numeroCartao.substr(len - 1));
    };

    /**
     * Verifica se o n�mero do cart�o foi passado corretamente
     *
     * @returns {Boolean}
     */
    self.numeroPreenchido = function() {
        var regNumero = /^[0-9]{13,19}$/;
        return regNumero.test(self.numeroCartao);
    };

    /**
     * Multiplica��o para valida��o
     *
     * @returns {Number}
     */
    self.multiplicaESoma = function() {
        var cont = 0;
        var soma = 0;
        for (var i=0;i<self.numeroCartaoSemDigito.length;i++) {
            var numeroAtual = parseInt(self.numeroCartaoSemDigito.charAt(i));
            if (cont++ % 2 === 0) { // Par
                soma += parseInt(numeroAtual * 2);
            } else {
                soma += parseInt(numeroAtual * 1);
            }
        }
        return soma;
    };

    /**
     * Faz o c�lculo do resto da divis�o do c�lculo 
     * de multiplica��o do n�mero do cart�o
     *
     * @returns {Number}
     */
    self.calculoRestoDivisao = function(valor) {
        if (valor === 0) {
            return 0;
        }
        return valor % 10;
    };

    /**
     * Efetua a valida��o do n�mero do cart�o
     *
     * @returns {Boolean}
     */
    self.numeroValido = function() {
        if (self.numeroPreenchido() !== true) {
            return false;
        }

        // Seta o n�mero do cart�o sem o digito e o digito verificador
        self.setNumeroCartaoSemDigito();

        // Regra de multiplica��o e soma
        var soma = self.multiplicaESoma();

        // Resto da divis�o do valor multiplicado e somado
        var restoDivisao = self.calculoRestoDivisao(soma);

        // Pega o digito verificador do n�mero do cart�o
        var dv = 10 - restoDivisao;

        return dv === self.digitoVerificador;
    };

    return self;
}
