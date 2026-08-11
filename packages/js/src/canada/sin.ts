export function sinCanadaClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function sinCanadaFormat(value: string): string {
  return sinCanadaClean(value).replace(/^(\d{3})(\d{3})(\d{3})$/, '$1-$2-$3');
}

/**
 * Validates the Luhn check digit of the Social Insurance Number.
 */
export function sinCanadaValidate(value: string): boolean {
  const sin = sinCanadaClean(value);

  if (sin.length !== 9) {
    return false;
  }

  let sum = 0;

  for (let i = 0; i < 8; i++) {
    let digit = Number(sin[i]);

    if (i % 2 === 1) {
      digit *= 2;

      if (digit > 9) {
        digit -= 9;
      }
    }

    sum += digit;
  }

  return Number(sin[8]) === (10 - (sum % 10)) % 10;
}
