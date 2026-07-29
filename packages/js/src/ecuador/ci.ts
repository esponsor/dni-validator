export function ciEcuadorClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function ciEcuadorFormat(value: string): string {
  return ciEcuadorClean(value).replace(/^(\d{9})(\d)$/, '$1-$2');
}

/**
 * Structural check only: ten digits; the check digit is not verified.
 */
export function ciEcuadorValidate(value: string): boolean {
  return ciEcuadorClean(value).length === 10;
}
