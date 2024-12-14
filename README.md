# digipublishing

#oppgave 1:
Har ordnet med dotenv-fil for mer sikker samhandling med databasen.
Databasen er opprettet og heter registration_schema. Tabell med nødvendige felt:

- fornavn
- etternavn
- e-post
- telefonnummer
- fødselsdato

Alle er laget for å møte kravene. Fornavn, etternavn, tlf og fødselsdato er påkrevd. Etternavn er kun ett ord, ellers vil du ikke få sendt noe data til databasen, e-post er ikke påkrevd, men om det skrives inn noe i feltet, så må man utfylle det. alfakrøll er påkrevd når man allerede har skrevet noe inn i feltet. Telefonnummer skal starte med enten 9 eller 4. Fødselsdato følger DDMMYYYY. Personen må også være over 16 år, 16052014 vil gi feilmelding. Hvis alt er utfylt som det skal, så vil dataen som er sendt legge seg rett under registreringsskjemaet, det samme med info som har blitt lagt inni skjemaet fra før.

Dependencies:
dotenv
express
moment
mysql2

devDependencies:
nodemon

Oppgave 2:
