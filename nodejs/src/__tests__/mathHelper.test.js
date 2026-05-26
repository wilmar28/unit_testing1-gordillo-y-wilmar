const { add, divide, subtract, multiply } = require('../mathHelper');

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

  describe('subtract()', () => {
    it('resta dos números positivos', () => {
      expect(subtract(10, 3)).toBe(7);
    });

    it('resta que da resultado negativo', () => {
      expect(subtract(2, 8)).toBe(-6);
    });

    it('resta con cero devuelve el mismo número', () => {
      expect(subtract(5, 0)).toBe(5);
    });
  });

  describe('multiply()', () => {
    it('multiplica dos números positivos', () => {
      expect(multiply(4, 5)).toBe(20);
    });

    it('multiplicar por cero da cero', () => {
      expect(multiply(9, 0)).toBe(0);
    });

    it('multiplica números negativos entre sí da positivo', () => {
      expect(multiply(-3, -4)).toBe(12);
    });
  });

});