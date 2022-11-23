/**
 * return true if @param a is object else false
 */
export const isObject = a => !!a && a.constructor === Object;

/**
 * Return truw if @param n is number
 *
 * @param {any} n : Value to be checked whether number or not
 */
export function isNumber(n) {
  return typeof n === 'number' && !Number.isNaN(n) && Number.isFinite(n);
}

/**
 * return true is @param a is empty or non empty valid string
 */
export const isString = a => {
  return typeof a === 'string';

};

/**
 * return true if @param an is non-empty valid string
 */
export const isNonEmptyString = a => isString(a) && a !== '';
