export function rutEcuadorClean(value: string): string {
  return value.replace(/\D/g, '');
}

/**
 * Structural check only: thirteen digits; the check digit is not verified.
 */
export function rutEcuadorValidate(value: string): boolean {
  return rutEcuadorClean(value).length === 13;
}
