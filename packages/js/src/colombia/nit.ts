export function nitColombiaClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function nitColombiaFormat(value: string): string {
  return nitColombiaClean(value).replace(/^(\d{3})(\d{3})(\d{3})(\d)$/, '$1.$2.$3-$4');
}

/**
 * Structural check only: the NIT check digit is not verified.
 */
export function nitColombiaValidate(value: string): boolean {
  return nitColombiaClean(value).length === 10;
}
