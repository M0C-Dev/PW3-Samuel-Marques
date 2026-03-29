// ARRAY COM OS OBJETO DOS PRODUTOS, bem mais facil do q eu criar item por item. coceito de POO euacho
const listaDeProdutos = [
    {nome: "Camiseta Regata", preco: 19.90},
    {nome: "Camiseta Social", preco: 59.90},
    {nome: "Blusa", preco: 199.90},
    {nome: "Pullover", preco: 39.90},
    {nome: "Sapato", preco: 99.90},
    {nome: "Calça", preco: 38.90},
    {nome: "Meias", preco: 9.90},
    {nome: "Luvas", preco: 24.90},
    {nome: "Jaqueta", preco: 329.90},
    {nome: "Bermuda", preco: 69.90},
    {nome: "Chinelo", preco: 14.90},
    {nome: "Boné", preco: 6.90}
];

const tbody = document.getElementById("corpo-table");

listaDeProdutos.forEach((produto, index) => {
    const tr = document.createElement("tr");

    //data-index ===== é um negocio do html q podemos colocar qualquer coisa so para salvar um valor, no caso o index do item na lista de produtos (o array).
    tr.innerHTML = `
        <td>
            <input type="checkbox" class="produto-checked" data-index="${index}">
            ${produto.nome}
        </td>
        <td>
            ${produto.preco.toFixed(2)}
        </td>
        <td>
            <input type="number" class="quantidade-number" min="1" value="1" data-index="${index}">
        </td>
    `; // to fixed faz ter casas depois da virgula

    tbody.appendChild(tr)
});

function calcular() {
    // cria listas com os coiso que tem essa class ai
    const checkboxes = document.querySelectorAll(".produto-checked");
    const quantidades = document.querySelectorAll(".quantidade-number");

    const vista = document.getElementById("vista");
    const parcelado = document.getElementById("parcelado");
    const vezes = document.getElementById("vezes");

    const resultadoBox = document.getElementById("resultado-box");

    let total = 0; // valor da compra

    // vai indo pra cada item la e pega o index
    checkboxes.forEach((checkbox, index) => {
        // se tiver marcado o item
        if (checkbox.checked) {
            const preco = listaDeProdutos[index].preco;
            // pega o numero la q a pessoa pois de item
            const quantidade = parseInt(quantidades[index].value);
            //bota no valor total la
            total += preco * quantidade;
        }
    });

    // ------------- PRA CASO O CARA N COLOCOU NADA
    if (total === 0) {
        resultadoBox.value = "Selecione pelo menos um produto!!!";
        return
    }
    // --------------- A VISTAAAAAAAAAAAA
    if (vista.checked) {
        const desconto = total * 0.085; // 8,5% de desconto.
        const totalFinal = total - desconto;

        resultadoBox.value =
            `Total: ${total.toFixed(2)}\n` +
            `Desconto: ${desconto.toFixed(2)}\n` +
            `Total à vista: ${totalFinal.toFixed(2)}`
        ;
        //tofixed pra ter casa depois da virgulaaa
    } 
    // -----------------PARCELADOOOOOOOOOOOOOOOOOO
    else if (parcelado.checked) {
        const numParcelas = parseInt(vezes.value); // O VALOR É STRING TEM Q CONVERTER

        const taxa = (total * 0.06) + (6.90 * numParcelas); // 6% do valor da venda e mais R$ 6,90 para cada parcela.
        const totalFinal = total + taxa;
        const valorParcela = totalFinal / numParcelas; // valor de cada parcela

        // checando se ta o valor minimo
        if (valorParcela < 10) {
            resultadoBox.value = "Valor da parcela não pode ser menor que R$ 10,00!!!";
            return
        }
        resultadoBox.value =
            `Total: ${total.toFixed(2)}\n` +
            `Taxa: ${taxa.toFixed(2)}\n` +
            `Total com juros: ${totalFinal.toFixed(2)}\n` +
            `${numParcelas}x de ${valorParcela.toFixed(2)}`
        ;
        //tofixed pra ter casa depois da virgulaaa
    }
}