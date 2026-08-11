const WEIGHTS = [2, 9, 8, 7, 6, 3, 4];

export function ciUruguayClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function ciUruguayFormat(value: string): string {
  return ciUruguayClean(value).replace(/^(\d)(\d{3})(\d{3})(\d)$/, '$1.$2.$3-$4');
}

export function ciUruguayCheckDigit(body: string): number {
  const padded = body.padStart(7, '0');
  let sum = 0;

  for (let i = 0; i < WEIGHTS.length; i++) {
    sum += (WEIGHTS[i] * Number(padded[i])) % 10;
  }

  return (10 - (sum % 10)) % 10;
}

export function ciUruguayValidate(value: string): boolean {
  const ci = ciUruguayClean(value);

  if (ci.length < 7 || ci.length > 8) {
    return false;
  }

  return ciUruguayCheckDigit(ci.slice(0, -1)) === Number(ci.slice(-1));
}
