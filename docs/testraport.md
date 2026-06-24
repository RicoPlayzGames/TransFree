# Testplan/rapport

## Navigatie

| Test | Verwacht resultaat | Uitkomst |
| --- | --- | --- |
| Alle links klikken | Juiste pagina opent | Bijna alle links werken. |
| Logo klikken | Home page opent | Het werkt! |

De enige link die niet werkt is wanneer je gaat inloggen. Wanneer dat gebeurt wordt je meteen doorgestuurd naar de upload pagina in plaats van home.

## Formulieren

| Test | Verwacht resultaat | Uitkomst |
| --- | --- | --- |
| Leeg formulier versturen | Foutmelding tonen | Foutmelding dat de velden required zijn |
| Verplicht veld niet invullen | Validatie | Foutmelding dat het veld required is |
| Correct formulier versturen | Succesmelding | Groene success melding |
| Ongeldig email invullen | Foutmelding | Melding dat je een geldige email moet invullen |

## Upload functionaliteit

| Test | Verwacht resultaat | Uitkomst |
| --- | --- | --- |
| PNG Uploaden | Upload success | Het werkt! De file is geüpload, en de token wordt aangegeven. |
| JPG Uploaden | Upload success | Het werkt niet. De foutmelding wordt laten zien: “Upload Failed\nInvalid file type.\nOnly PNG files are allowed.” |
| MP4 Uploaden | Upload success | Het werkt niet. De foutmelding wordt laten zien: “Upload Failed\nInvalid file type.\nOnly PNG files are allowed.” |
| ZIP Uploaden | Upload success | Het werkt niet. De foutmelding wordt laten zien: “Upload Failed\nInvalid file type.\nOnly PNG files are allowed.” |
| Te groot bestand uploaden | Foutmelding | Het werkt! De foutmelding wordt laten zien: “Upload Failed\nFile is too large. Maximum 5 MB allowed.” |
| Verboden bestandstype uploaden | Foutmelding | Het werkt! De foutmelding wordt laten zien: “Upload Failed\nInvalid file type.\nOnly PNG files are allowed.” |

## Users

| Test | Verwacht resultaat | Uitkomst |
| --- | --- | --- |
| Registreren | Ga naar login | Gaat naar upload pagina |
| Inloggen | Ga naar dashboard/admin dashboard | Gaat naar upload. |
| Uitloggen | Ga naar login | Gaat naar login formulier |
| Verkeerd wachtwoord | Foutmelding | Geen foutmelding, alleen een refresh. |

## Admin

| Test | Verwacht resultaat | Uitkomst |
| --- | --- | --- |
| Uploads bekijken | Krijg alle uploads te zien | Alle uploads komen in een tabel |
| Uploads bewerken | Kan naam & description aanpassen | Je kan per upload de naam en omschrijving aanpassen. |
| Uploads verwijderen | Upload gaat weg uit db en file structure | De upload gaat succesvol weg uit de database en file structure |
| Users bekijken | Krijg alle users te zien | Alle users komen in een mooie tabel |
| Users verwijderen | Users worden verwijderd | Je kan de user verwijderen zonder fouten |
| User role aanpassen | Admin kan role aanpassen | Je kan van elke user EN jezelf de role aanpassen |
| Logs bekijken | Alle logs worden zichtbaar | Je kan alle logs zien |

