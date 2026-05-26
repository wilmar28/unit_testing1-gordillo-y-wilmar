// Ejercicio 1 — StringHelper

class StringHelper {

  /**
   * Trunca el texto a maxLength caracteres.
   * Si tiene longitud <= maxLength, devuelve el texto original.
   * Si maxLength <= 0, lanza una excepción.
   */
  truncate(text, maxLength, suffix = '...') {
    if (maxLength <= 0) {
      throw new Error('maxLength debe ser un número positivo.');
    }
    if (text.length <= maxLength) {
      return text;
    }
    return text.slice(0, maxLength) + suffix;
  }

  /**
   * Convierte texto a slug URL-friendly.
   * "¡Hola Mundo! 2024" → "hola-mundo-2024"
   */
  toSlug(text) {
    return text
      .toLowerCase()
      .normalize('NFD')                    // descomponer caracteres con tilde
      .replace(/[\u0300-\u036f]/g, '')     // eliminar diacríticos (tildes)
      .replace(/[^a-z0-9\s-]/g, '')        // eliminar caracteres especiales
      .trim()
      .replace(/\s+/g, '-')               // espacios → guiones
      .replace(/-+/g, '-');               // guiones múltiples → uno solo
  }

  /**
   * Cuenta las palabras de un texto.
   * Maneja espacios múltiples. Texto vacío o null → 0.
   */
  countWords(text) {
    if (!text || text.trim() === '') return 0;
    return text.trim().split(/\s+/).length;
  }
}

module.exports = StringHelper;
