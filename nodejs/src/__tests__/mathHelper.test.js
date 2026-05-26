// Paso 1 — Tests de funciones simples

const { add, divide } = require('../mathHelper');

describe('mathHelper', () => {

  describe('add()', () => {
    it('suma dos números positivos correctamente', () => {
      // Arrange
      const a = 2, b = 3;
      // Act
      const result = add(a, b);
      // Assert
      expect(result).toBe(5);
    });

    it('suma números negativos', () => {
      expect(add(-1, -4)).toBe(-5);
    });

    it('suma cero con un número devuelve el mismo número', () => {
      expect(add(0, 7)).toBe(7);
    });
  });

  describe('divide()', () => {
    it('devuelve el cociente correcto', () => {
      expect(divide(10, 4)).toBe(2.5);
    });

    it('devuelve resultado entero cuando es exacto', () => {
      expect(divide(10, 2)).toBe(5);
    });

    it('lanza error al dividir entre cero', () => {
      expect(() => divide(5, 0)).toThrow('No se puede dividir entre cero.');
    });
  });

});
