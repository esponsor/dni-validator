# Security policy

## Supported versions

| Version | Supported |
|---------|-----------|
| 0.1.x   | Yes |
| 0.0.x   | Best effort until 0.1.0 is published |

## Reporting a vulnerability

Please **do not** open a public GitHub issue for security problems.

Email [victorpuentem@gmail.com](mailto:victorpuentem@gmail.com) with:

- A description of the issue and its impact
- Steps to reproduce or a proof of concept
- Affected package versions (npm and/or Packagist) if known

You should receive an acknowledgement within a few business days. Once a fix is ready we will credit you in the release notes if you want that.

## Scope notes

This library only checks document **format and checksum/structure**. It does not contact government registries and cannot confirm that an ID was issued to a person. Treat validation results accordingly in security-sensitive flows.
