/**
 * Returns the date in the format DD-MM
 * @param {Date} date 
 * @returns 
 */
export const shortDateFormat = (date) =>
  date.toISOString().slice(0, 10).split('-').slice(1).reverse().join('-');