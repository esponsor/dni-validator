const DNI_PATTERN = /^[XYZ]?\d{5,8}[A-Z]$/;

const CHECK_LETTERS = 'TRWAGMYFPDXBNJZSQVHLCKET';

const NIE_PREFIXES = 'XYZ';

export function dniSpainClean(value: string): string {
  return value.toUpperCase().replace(/[^\dA-Z]/g, '');
}

export function dniSpainFormat(value: string): string {
  return dniSpainClean(value);
}

/**
 * Validates both the DNI (digits only) and the NIE (X, Y or Z prefix) using the modulo-23 letter.
 */
export function dniSpainValidate(value: string): boolean {
  const dni = dniSpainClean(value);

  if (!DNI_PATTERN.test(dni)) {
    return false;
  }

  const body = dni
    .slice(0, -1)
    .replace(/^[XYZ]/, (prefix) => String(NIE_PREFIXES.indexOf(prefix)));

  return CHECK_LETTERS[Number(body) % 23] === dni.slice(-1);
}
