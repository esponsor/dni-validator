const WEIGHTS = [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

export function rutUruguayClean(value: string): string {
  return value.replace(/\D/g, '');
}

export function rutUruguayFormat(value: string): string {
  return rutUruguayClean(value).replace(/^(\d{2})(\d{6})(\d{3})(\d)$/, '$1-$2-$3-$4');
}

export function rutUruguayCheckDigit(body: string): number {
  if (body.length !== 11) {
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

  return digit === 10 ? 1 : digit;
}

export function rutUruguayValidate(value: string): boolean {
  const rut = rutUruguayClean(value);

  if (rut.length !== 12) {
    return false;
  }

  return rutUruguayCheckDigit(rut.slice(0, 11)) === Number(rut.slice(-1));
}
