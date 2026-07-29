## [0.1.0] - Unreleased

Added validators for Argentina (CUIT/CUIL), Brazil (CPF, CNPJ), Canada (SIN), Colombia (CC, NIT, PASS), Ecuador (CI, RUT, PASS), Peru (DNI, RUC), Spain (DNI/NIE), the United States and Puerto Rico (SSN) and Uruguay (CI, RUT), in PHP and TypeScript.
Added a Laravel validation rule per document and registered every document in both registries; country and type lookups are now case insensitive.
Added country subpath exports to the JS package and shared JSON test vectors that drive both test suites through the registry.
Documented which documents are validated structurally instead of by checksum.
Fixed: CPF rejects repeated-digit values, Uruguayan CI requires 7-8 digits before the check digit, and Peruvian DNI requires 8 digits plus an optional verification character.
Existing Chile RUT and Mexico CURP APIs are unchanged.

## [0.0.1] - 2026-05-18

Initial release — CL (RUT) and MX (CURP) validators
PHP + JS packages with shared test vectors
