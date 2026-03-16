const funcoes = {
    dobro(a,b,c,d){
        return a*2
    },
    triplo(a,b,c,d){
        return a*3
    },
    quadruplo(a,b,c,d){
        return a*4
    },
    quintuplo(a,b,c,d){
        return a*5
    },

    sextuplo(a,b,c,d){
        return a*6
    },

    potDois(a,b,c,d){
        return a**2
    },

    potTres(a,b,c,d){
        return a**3
    },

    potQuatro(a,b,c,d){
        return a**4
    },

    potCinco(a,b,c,d){
        return a**5
    },

    potSeis(a,b,c,d){
        return a**6
    },

    mediaQuatro(a,b,c,d){
        return (a+b+c+d)/4
    },

    baskhara(a,b,c,d){
        const delta = b*b - 4*a*c
        if(delta < 0){
            return "Sem raízes reais!!!"
        }
        const x1 = (-b + Math.sqrt(delta)) / (2*a)
        const x2 = (-b - Math.sqrt(delta)) / (2*a)

        return "x1 = " + x1 + " / x2 = " + x2
    }
};

function calcular(){
    const tipo = document.getElementById("function").value;

    const num1 = Number(document.getElementById("num1").value);
    const num2 = Number(document.getElementById("num2").value);
    const num3 = Number(document.getElementById("num3").value);
    const num4 = Number(document.getElementById("num4").value);

    const resultado = funcoes[tipo](num1, num2, num3, num4);

    document.getElementById("resultado-box").value = resultado;
}