// Array de todos os gastos
let gastos = [];

const lista = document.querySelector('#listaGastos');
const form = document.querySelector('#formGasto');
const total = document.querySelector('#total');
const totalCategoria = document.querySelector('#total-categoria');
const filtro = document.querySelector('#filtroCategoria');
const ordem = document.querySelector('#ordenarPor');
const apagarHistorico = document.querySelector('#apagarHistorico');

// ADICIONAR GASTOS
form.addEventListener('submit', function(event) {
    event.preventDefault();

    const descricao = document.querySelector('#descricao').value;
    const categoria = document.querySelector('#categoria').value;
    const valor = document.querySelector('#valor').value;

    // Validação
    if (descricao === '' || valor === '' || isNaN(valor) || valor <= 0) {
        alert('Insira valores válidos!');
        return;
    }

    const valorFloat = parseFloat(valor);

    const gasto = {
        descricao: descricao,
        categoria: categoria,
        valor: valorFloat
    };

    gastos.push(gasto);
    salvarDados();

    renderizarLista();
    renderizarTotal();

    // limpar campos
    document.querySelector('#descricao').value = '';
    document.querySelector('#valor').value = '';
});


// EXIBIR LISTA
function renderizarLista() {
    lista.innerHTML = '';

    const categoriaSelecionada = filtro.value;
    const ordemSelecionada = ordem.value;

    let listaFiltrada = gastos;

    // FILTRO
    switch (categoriaSelecionada) {
        case "Alimentacao":
        case "Lazer":
        case "Transporte":
        case "Outro":
            listaFiltrada = gastos.filter(function(gasto) {
                return gasto.categoria === categoriaSelecionada;
            });
            break;

        case "Todos":
        default:
            listaFiltrada = gastos;
    }

    // CRIA CÓPIA PRA ORDENAR
    let listaFinal = [...listaFiltrada];

    // ORDENAÇÃO
    switch (ordemSelecionada) {
        case "maisRecente":
            listaFinal.reverse();
            break;

        case "maisAntigo":
            break;

        case "maiorMenor":
            listaFinal.sort(function(a, b) {
                return b.valor - a.valor;
            });
            break;

        case "menorMaior":
            listaFinal.sort(function(a, b) {
                return a.valor - b.valor;
            });
            break;
    }

    // RENDERIZA
    listaFinal.forEach(function(gasto) {
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
            default:
                source = "imgs/icones/icone-outro.png";
        }
        img.src = source;

        const info = document.createElement("div");

        const titulo = document.createElement("span");
        titulo.classList.add("titulo-gasto");
        titulo.textContent = gasto.descricao;

        const categoria = document.createElement("span");
        categoria.classList.add("tiny-grey");
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
                const indexReal = gastos.indexOf(gasto);
                gastos.splice(indexReal, 1);

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


// TOTAL
function renderizarTotal() {
    let valorTotal = 0;
    let valorTotalCategoria = 0;

    const categoriaSelecionada = filtro.value;

    gastos.forEach(function(gasto) {
        valorTotal += gasto.valor;

        if (categoriaSelecionada === "Todos" || gasto.categoria === categoriaSelecionada) {
            valorTotalCategoria += gasto.valor;
        }
    });

    total.textContent = `R$ ${valorTotal.toFixed(2)}`;

    if (totalCategoria) {
        totalCategoria.textContent = `R$ ${valorTotalCategoria.toFixed(2)}`;
    }
}


// SALVAR
function salvarDados() {
    localStorage.setItem("gastos", JSON.stringify(gastos));
}

function carregarDados() {
    const dados = localStorage.getItem("gastos");

    if (dados) {
        gastos = JSON.parse(dados);
    }

    renderizarLista();
    renderizarTotal();
}

apagarHistorico.addEventListener("click", function() {
    const confirmar = confirm(`APAGAR TODOS OS DADOS? (IRREVERSIVEL!)`);

    if (confirmar) {
        gastos = [];
        localStorage.removeItem("gastos");

        renderizarLista();
        renderizarTotal();
    }
});

// EVENTOS
document.addEventListener("DOMContentLoaded", function() {
    carregarDados();
});

filtro.addEventListener('change', function() {
    renderizarLista();
    renderizarTotal();
});

ordem.addEventListener('change', function() {
    renderizarLista();
});
