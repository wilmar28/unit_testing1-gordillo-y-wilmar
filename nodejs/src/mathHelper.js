// Paso 1 — Función simple
// Funciones puras sin clases ni dependencias externas

function add(a, b) {
  return a + b;
}

function divide(a, b) {
  if (b === 0) throw new Error('No se puede dividir entre cero.');
  return a / b;
}

module.exports = { add, divide };
