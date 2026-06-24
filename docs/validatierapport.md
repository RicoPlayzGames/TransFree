# Validatierapport — TransFree

Datum: 2026-06-24
Auteur: SRS

Samenvatting
---------
Dit document beschrijft de validatietests en resultaten voor de webapplicatie TransFree. De focus lag op navigatie, formulieren, upload-functionaliteit, gebruikersflows en beheerfuncties. Het doel was vaststellen welke functionaliteiten correct werken, welke fouten zijn gevonden en welke acties worden aanbevolen.

Scope
-----
- Functionele testen: registratie, inloggen, uploaden, downloaden, verwijderen, admin beheer.
- Niet-functionele controles: foutmeldingen, inputvalidatie en veiligheid (basischecks).

Testomgeving
-------------
- Lokale ontwikkelomgeving (XAMPP / PHP)
- Bestandsopslag: `public/uploads`
- Belangrijke bestanden met fixes: `app/controllers/AdminController.php`, `app/services/UploadService.php`

Testplan en Resultaten (kort)
-----------------------------

1) Navigatie
- Verwacht: links openen correcte pagina's.
- Uitkomst: bijna alle links werken; aanmelden (login) redirect naar uploadpagina in plaats van home/dashboard.

2) Formulieren
- Verwacht: vereiste velden valideren; juiste fout- en succesmeldingen.
- Uitkomst: lege of onvolledige formulieren geven een "required" foutmelding; correcte formulieren tonen succesmelding; ongeldige e-mail toont fout.

3) Upload-functionaliteit
- Verwacht: meerdere bestandstypen uploaden; juiste validatie op bestandstype en grootte.
- Uitkomst:
	- PNG: werkt, token wordt getoond.
	- JPG/MP4/ZIP: oorspronkelijk foutmelding "Only PNG files are allowed." (beperking); dit is aangepast in `UploadService.php` (zie Opgeloste fouten).
	- Te groot bestand (>5 MB): foutmelding correct.

4) Users (gebruikersflows)
- Registreren en inloggen: registratie en inloggen redirecten momenteel naar de uploadpagina in plaats van naar het dashboard.
- Uitloggen: keert terug naar het loginformulier.
- Verkeerd wachtwoord: geen duidelijke foutmelding, pagina refresh zonder melding.

5) Admin
- Uploads bekijken/bewerken/verwijderen: werken; uploads verdwijnen uit DB en bestandsstructuur.
- Users bekijken en verwijderen: werken.
- Rollen aanpassen (admin/user): mogelijk, maar beveiligingsverbetering gewenst (zie punten).
- Logs: zichtbaar en bruikbaar.

Gevonden en Gerelateerde Issues (Prioriteit)
--------------------------------------------

- Hoog:
	- Rollenwijziging zonder aanvullende authenticatie: het veranderen van een gebruiker naar admin (of andersom) vereist extra beveiliging, bijvoorbeeld het vragen om een admin-wachtwoord of multi-factor. (Aanbeveling: implementeren in `app/controllers/AdminController.php`.)

- Middel:
	- Redirect na inloggen: gebruikers worden naar de uploadpagina gestuurd in plaats van naar het juiste dashboard; verbetert gebruikservaring en consistentie.
	- Geen duidelijke foutmelding bij verkeerd wachtwoord: verbeter feedback bij aanmeldpogingen.

- Laag:
	- Oorspronkelijke beperking op alleen PNG-bestanden is aangepast, maar testmatrix moet worden uitgebreid naar meer bestandstypen en combinaties.

Opgeloste punten (zoals genoteerd)
---------------------------------
- Rollenwijziging: extra validatie toegevoegd in `app/controllers/AdminController.php`. (Status: klaar)
- UploadService: ondersteuning voor meerdere bestandstypes en aanpassing van mapgrootte is doorgevoerd in `app/services/UploadService.php`. (Status: klaar)

Aanbevelingen
-------------

- Beveiliging:
	- Zorg voor TLS/HTTPS op productie om gegevens en wachtwoorden te versleutelen.
	- Vereis extra bevestiging (wachtwoord/MFA) bij het wijzigen van gebruikersrollen.
	- Gebruik een moderne wachtwoord-hash (bijv. bcrypt/argon2) in plaats van eenvoudige sha-256 waar mogelijk.

- Functionaliteit & UX:
	- Corrigeer de redirect na inloggen: stuur gebruikers naar hun dashboard (of admin-dashboard afhankelijk van rol).
	- Toon duidelijke foutmelding bij onjuiste inloggegevens.
	- Breid bestandstype- en batch-uploadtesten uit en documenteer toegestane types en maxgrootte.

- Testen & Logging:
	- Automatiseer regressietests voor upload- en gebruikersflows.
	- Houd change-log bij voor fixes en teststatussen.

Conclusie
---------
De kernfunctionaliteit van TransFree werkt: uploaden, beheren en downloaden van bestanden, en admin beheer zijn aanwezig en grotendeels stabiel. Er zijn een paar belangrijke verbeterpunten op het gebied van beveiliging en gebruikersflow (redirects en authenticatie bij rolwijziging). Een korte verbetercyclus met prioriteit op beveiliging en UX zal de betrouwbaarheid en het vertrouwen van gebruikers aanzienlijk verhogen.

Wijzigingen / Changelog
-----------------------
- `app/controllers/AdminController.php`: extra validatie voor rolwijziging toegevoegd (prio: hoog) — afgerond.
- `app/services/UploadService.php`: bestandstype- en mapgrootte-aanpassingen doorgevoerd — afgerond.

Volgende stappen
----------------
1. Implementeer HTTPS op staging/production.
2. Voeg wachtwoordbevestiging of MFA toe bij rolwijziging.
3. Herstel login-redirects en verbeter foutmeldingen bij inloggen.
4. Breid upload-tests uit (JPG, MP4, ZIP, batch uploads).