function calcularEndividamento() {
    const receita = parseFloat(document.getElementById("receita").value);
    const despesa = parseFloat(document.getElementById("despesa").value);
    const resultadoElemento = document.getElementById("resultado");

    if (isNaN(receita) || isNaN(despesa)) {
        resultadoElemento.textContent = "Por favor, insira valores válidos para receitas e despesas.";
        resultadoElemento.style.color = "red";
        return;
    }

    const endividamento = (despesa / receita) * 100;

    let mensagem;
    if (endividamento < 30) {
        mensagem = `Seu nível de endividamento é saudável (${endividamento.toFixed(2)}%). Continue assim!`;
        resultadoElemento.style.color = "green";
    } else if (endividamento >= 30 && endividamento <= 50) {
        mensagem = `Seu nível de endividamento é moderado (${endividamento.toFixed(2)}%). Atenção aos seus gastos.`;
        resultadoElemento.style.color = "orange";
    } else {
        mensagem = `Seu nível de endividamento está alto (${endividamento.toFixed(2)}%). Considere reduzir suas despesas.`;
        resultadoElemento.style.color = "red";
    }

    resultadoElemento.textContent = mensagem;
}
