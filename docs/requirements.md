# Security Requirements

Definieer de beveiligingseisen van het systeem:

- HTTPS
- Gebruikerslogin
- Hashes (sha-256)
- Foutafhandeling: duidelijke errors
- Inputvalidatie: SQL-injecties
- Logging:
  - Upload
  - Delete
  - Download

## Risico’s

- Malware in uploads -> kan de server besmetten
- Datalekken -> vertrouwelijke bestanden kunnen uitlekken
- Ongeautoriseerde toegang -> onbevoegden kunnen bestanden bekijken of verwijderen

## Aanvallen

- Man-in-the-middle
- SQL Injection
- DDoS
