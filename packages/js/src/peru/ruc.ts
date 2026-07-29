const VALID_PREFIXES = ['10', '15', '16', '17', '20'];

export function rucPeruClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function rucPeruFormat(value: string): string {
  return rucPeruClean(value);
}

/**
 * Structural check only: eleven digits with a known taxpayer prefix; the check digit is not verified.
 */
export function rucPeruValidate(value: string): boolean {
  const ruc = rucPeruClean(value);

  return ruc.length === 11 && VALID_PREFIXES.includes(ruc.slice(0, 2));
}
