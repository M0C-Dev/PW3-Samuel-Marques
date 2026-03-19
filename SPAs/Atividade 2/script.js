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
    `;

    tbody.appendChild(tr)
});