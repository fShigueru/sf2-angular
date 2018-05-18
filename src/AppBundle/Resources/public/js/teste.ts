class Teste {
    _nome:string;
    constructor(public nome:string){
        this._nome = nome;
    }
    exibir(): void{
        console.log(this._nome);
    }
}

var t = new Teste("Teste typescript");
t.exibir();