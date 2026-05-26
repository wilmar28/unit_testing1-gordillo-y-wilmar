const Calculadora = require('../src/Calculadora');
 
describe('Calculadora', () => {
  let calc;
 
  beforeEach(() => {
    calc = new Calculadora();
  });
 
  describe('sumar()', () => {
    it('suma dos números positivos', () => {
      expect(calc.sumar(2, 3)).toBe(5);
    });
 
    it('suma con número negativo', () => {
      expect(calc.sumar(10, -4)).toBe(6);
    });
  });
 
  describe('restar()', () => {
    it('resta dos números', () => {
      expect(calc.restar(10, 3)).toBe(7);
    });
 
    it('resta que da negativo', () => {
      expect(calc.restar(2, 8)).toBe(-6);
    });
  });
 
  describe('multiplicar()', () => {
    it('multiplica dos números', () => {
      expect(calc.multiplicar(4, 5)).toBe(20);
    });
 
    it('multiplicar por cero da cero', () => {
      expect(calc.multiplicar(9, 0)).toBe(0);
    });
  });
 
  describe('dividir()', () => {
    it('divide dos números', () => {
      expect(calc.dividir(10, 2)).toBe(5);
    });
 
    it('lanza error al dividir entre cero', () => {
      expect(() => calc.dividir(10, 0)).toThrow('No se puede dividir entre cero.');
    });
  });
});