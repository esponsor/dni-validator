const CUIT_PATTERN = /^(20|23|24|27|30|33|34)\d{9}$/;

const WEIGHTS = [5, 4, 3, 2, 7, 6, 5, 4, 3, 2];

export function cuitCuilClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function cuitCuilFormat(value: string): string {
  return cuitCuilClean(value).replace(/^(\d{2})(\d{8})(\d)$/, '$1-$2-$3');
}

export function cuitCuilCheckDigit(body: string): number {
  if (body.length !== 10) {
    return -1;
  }

  let sum = 0;

  for (let i = 0; i < WEIGHTS.length; i++) {
    sum += Number(body[i]) * WEIGHTS[i];
  }

  const digit = 11 - (sum % 11);

  if (digit === 11) {
    return 0;
  }

  return digit === 10 ? 9 : digit;
}

export function cuitCuilValidate(value: string): boolean {
  const cuit = cuitCuilClean(value);

  if (!CUIT_PATTERN.test(cuit)) {
    return false;
  }

  return cuitCuilCheckDigit(cuit.slice(0, 10)) === Number(cuit.slice(-1));
}
