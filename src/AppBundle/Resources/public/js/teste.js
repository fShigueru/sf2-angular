var Teste = (function () {
    function Teste(nome) {
        this.nome = nome;
        this._nome = nome;
    }
    Teste.prototype.exibir = function () {
        console.log(this._nome);
    };
    return Teste;
}());
var t = new Teste("Teste typescript");
t.exibir();
