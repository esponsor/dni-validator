export function rutClean(value: string): string {
  return value
    .replace(/[^0-9kK]/g, '')
    .replace(/^0+/, '')
    .toUpperCase();
}

export function rutFormat(value: string): string {
  const clean = rutClean(value);

  if (clean === '') {
    return '';
  }

  const body = clean.slice(0, -1);
  const check = clean.slice(-1);

  return `${body.replace(/\B(?=(\d{3})+(?!\d))/g, '.')}-${check}`;
}

export function rutValidate(value: string): boolean {
  const rut = rutClean(value);

  if (rut === '' || rut.length < 2) {
    return false;
  }

  let digits = parseInt(rut.slice(0, -1), 10);
  let m = 0;
  let s = 1;

  while (digits > 0) {
    s = (s + (digits % 10) * (9 - (m++ % 6))) % 11;
    digits = Math.floor(digits / 10);
  }

  const check = s > 0 ? String(s - 1) : 'K';

  return check === rut[rut.length - 1];
}
