// Array de todos os gastos
let gastos = []

const lista = document.querySelector('#listaGastos');
const form = document.querySelector('#formGasto');
const total = document.querySelector('#total')

// ADICIONAR GASTOS
form.addEventListener('submit', function(event) {
    event.preventDefault();

    const descricao = document.querySelector('#descricao').value;
    const categoria = document.querySelector('#categoria').value;
    const valor = document.querySelector('#valor').value;

    // Validação
    if (descricao === '' || valor === '' || isNaN(valor) || valor <= 0)
    {
        alert('Insira valores validos!');
        return;
    }

    // Converte valor string para INT
    const valorFloat = parseFloat(valor);

    // Cria objeto do gasto
    const gasto = {
        descricao: descricao,
        categoria: categoria,
        valor: valorFloat
    }

    gastos.push(gasto);
    // Salva
    salvarDados();

    // DEBUG!
    console.log(gastos);

    renderizarLista();
    renderizarTotal();
    
    document.querySelector('#descricao').value = '';
    document.querySelector('#valor').value = '';
});

// EXIBIR LISTA
function renderizarLista() {
    // Primeiro limpa a lista
    lista.innerHTML = '';

    gastos.forEach(function(gasto, index) {
        const divGasto = document.createElement("div");
        divGasto.classList.add("gasto");

        const img = document.createElement("img");

        let source;

        switch (gasto.categoria) {
            case 'Lazer':
                source = "imgs/icones/icone-lazer.png";
                break;
            case 'Alimentacao':
                source = "imgs/icones/icone-comida.png";
                break;
            case 'Transporte':
                source = "imgs/icones/icone-transporte.png";
                break;
            case 'Outro':
                source = "imgs/icones/icone-outro.png";
                break;
            default:
                source = "imgs/icones/icone-outro.png";
        }
        img.src = source;

        const info = document.createElement("div");

        const titulo = document.createElement("span");
        titulo.classList.add("titulo-gasto");
        titulo.textContent = gasto.descricao;

        const categoria = document.createElement("span");
        categoria.textContent = gasto.categoria;

        const valor = document.createElement("span");
        valor.classList.add("valor-gasto");
        valor.textContent = `R$ ${gasto.valor.toFixed(2)}`;

        info.appendChild(titulo);
        info.appendChild(categoria);
        info.appendChild(valor);

        const botao = document.createElement("button");
        botao.textContent = "REMOVER";

        botao.addEventListener("click", function() {
            const confirmar = confirm(`Remover "${gasto.descricao}"?`);

            if (confirmar) {
                gastos.splice(index, 1);
                // Salva
                salvarDados();

                renderizarLista();
                renderizarTotal();
            }
        });

        divGasto.appendChild(img);
        divGasto.appendChild(info);
        divGasto.appendChild(botao);

        lista.appendChild(divGasto);
    });
}

// RENDERIZAR TOTAL!!!
function renderizarTotal() {
    let valorTotal = 0
    
    gastos.forEach(function(gasto, index) {
        valorTotal += gasto.valor;
    })

    total.textContent = `R$ ${valorTotal.toFixed(2)}`;
}

// SALVAR!

function salvarDados() {
    localStorage.setItem("gastos", JSON.stringify(gastos));
}

function carregarDados() {
    const dados = localStorage.getItem("gastos");

    if (dados) {
        gastos = JSON.parse(dados);
        renderizarLista();
        renderizarTotal();
    }
}

// Carrega ao iniciar
document.addEventListener("DOMContentLoaded", function() {
    carregarDados();
});