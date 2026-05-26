// Ejercicio 1 — Tests de StringHelper

const StringHelper = require('../StringHelper');

describe('StringHelper', () => {
  let helper;

  beforeEach(() => {
    helper = new StringHelper();
  });

  // ── truncate() ─────────────────────────────────────────────────────────────

  describe('truncate()', () => {
    it('devuelve el texto original si es menor que maxLength', () => {
      expect(helper.truncate('Hola', 10)).toBe('Hola');
    });

    it('devuelve el texto original si es exactamente igual a maxLength (caso borde)', () => {
      expect(helper.truncate('Hola', 4)).toBe('Hola');
    });

    it('trunca y agrega el sufijo por defecto "..."', () => {
      expect(helper.truncate('Hola Mundo', 4)).toBe('Hola...');
    });

    it('usa un sufijo personalizado', () => {
      expect(helper.truncate('JavaScript es genial', 10, ' →')).toBe('JavaScript →');
    });

    it('lanza error si maxLength es 0', () => {
      expect(() => helper.truncate('Texto', 0))
        .toThrow('maxLength debe ser un número positivo.');
    });

    it('lanza error si maxLength es negativo', () => {
      expect(() => helper.truncate('Texto', -5))
        .toThrow('maxLength debe ser un número positivo.');
    });

    it('maneja texto vacío sin lanzar error', () => {
      expect(helper.truncate('', 5)).toBe('');
    });
  });

  // ── toSlug() ───────────────────────────────────────────────────────────────

  describe('toSlug()', () => {
    it('convierte mayúsculas a minúsculas', () => {
      expect(helper.toSlug('Hola Mundo')).toBe('hola-mundo');
    });

    it('reemplaza espacios por guiones', () => {
      expect(helper.toSlug('node js testing')).toBe('node-js-testing');
    });

    it('elimina caracteres especiales', () => {
      expect(helper.toSlug('¡Hola Mundo! 2024')).toBe('hola-mundo-2024');
    });

    it('elimina tildes y diacríticos', () => {
      expect(helper.toSlug('Programación en JavaScript')).toBe('programacion-en-javascript');
    });

    it('maneja múltiples espacios entre palabras', () => {
      expect(helper.toSlug('Hola    Mundo')).toBe('hola-mundo');
    });

    it('devuelve cadena vacía si el texto es vacío', () => {
      expect(helper.toSlug('')).toBe('');
    });
  });

  // ── countWords() ───────────────────────────────────────────────────────────

  describe('countWords()', () => {
    it('cuenta palabras en texto normal', () => {
      expect(helper.countWords('Hola Mundo')).toBe(2);
    });

    it('cuenta correctamente con espacios múltiples', () => {
      expect(helper.countWords('Hola   Mundo   Test')).toBe(3);
    });

    it('devuelve 0 con texto vacío', () => {
      expect(helper.countWords('')).toBe(0);
    });

    it('devuelve 0 con solo espacios', () => {
      expect(helper.countWords('     ')).toBe(0);
    });

    it('cuenta una sola palabra correctamente', () => {
      expect(helper.countWords('JavaScript')).toBe(1);
    });

    it('devuelve 0 con null o undefined', () => {
      expect(helper.countWords(null)).toBe(0);
      expect(helper.countWords(undefined)).toBe(0);
    });
  });

});
