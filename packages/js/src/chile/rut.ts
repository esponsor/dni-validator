export function rutClean(value: string): string {
  return value
    .replace(/[^0-9kK]/g, '')
    .replace(/^0+/, '')
    .toUpperCase();
}

/** Digits and conventional RUT separators only (dots, hyphens, spaces, K). */
function isAllowedRutShape(value: string): boolean {
  return /^[0-9kK.\-\s]+$/.test(value);
}

export function rutFormat(value: string): string {
  const clean = rutClean(value);

  if (clean === '' || !/^\d+[0-9K]$/.test(clean)) {
    return '';
  }

  const body = clean.slice(0, -1);
  const check = clean.slice(-1);

  return `${body.replace(/\B(?=(\d{3})+(?!\d))/g, '.')}-${check}`;
}

/**
 * Validates a Chilean RUT (modulo-11). Body length is capped at 8 digits so checksum
 * work is bounded; calculation walks digits as characters (no Number/Infinity loop).
 */
export function rutValidate(value: string): boolean {
  if (!isAllowedRutShape(value)) {
    return false;
  }

  const rut = rutClean(value);

  // 1–8 body digits + check digit (SII-style bodies; leading zeros already stripped by clean).
  if (!/^\d{1,8}[0-9K]$/.test(rut)) {
    return false;
  }

  const body = rut.slice(0, -1);
  let m = 0;
  let s = 1;

  for (let i = body.length - 1; i >= 0; i--) {
    s = (s + Number(body[i]) * (9 - (m++ % 6))) % 11;
  }

  const check = s > 0 ? String(s - 1) : 'K';

  return check === rut[rut.length - 1];
}
