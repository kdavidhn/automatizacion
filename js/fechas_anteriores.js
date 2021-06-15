
// FECHA MINIMA HOY
let today = new Date();
let dd = today.getDate();
let mm = today.getMonth() + 1; //January is 0!
let yyyy = today.getFullYear();
if (dd < 10) {
dd = '0' + dd;
}
if (mm < 10) {
mm = '0' + mm;
}

today = yyyy + '-' + mm + '-' + dd;

let fecha_inicio = document.getElementById('fecha_inicio');
let fecha_final = document.getElementById('fecha_final');
let fecha_adic_canc = document.getElementById('fecha_adic_canc');

fecha_inicio.min = today;
fecha_final.min = today;
fecha_adic_canc.min = today;