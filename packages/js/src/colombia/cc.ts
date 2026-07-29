export function ccColombiaClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function ccColombiaFormat(value: string): string {
  return ccColombiaClean(value).replace(/^(\d)(\d{3})(\d{3})(\d{3})$/, '$1.$2.$3.$4');
}

/**
 * Structural check only: the cédula de ciudadanía carries no published check digit.
 */
export function ccColombiaValidate(value: string): boolean {
  const length = ccColombiaClean(value).length;

  return length === 8 || length === 10;
}
