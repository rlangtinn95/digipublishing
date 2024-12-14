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
Krav:

- Man får ikke til å legge inn bare en dobbel, for eksempel kaffe kan legges inn, men hvis man prøver å bestille kun "dobbel", så vil det opp en feilmelding.
- CRUD-logikk er opprettet, testet og fungerer i thunder-client
- Kvittering vil komme opp etter man har bestilt, man har også oversikt over hva man har bestilt så langt før man trykker på bestill.
  -En start på nytt-knapp har blitt lagt til i tilfelle man klarer å trykke feil. Å trykke på den knappen vil også fjerne kvitteringen, så den er bra istedetfor å refreshe siden.
- Det er lagt ekstra vekt på design i tillegg. Lagt til litt "kaffefarger" for å få det til å se litt mer ut som en kaffesjappe og slik at nettsiden skal være mer koslig.

- I oppgave 2 så anbefaler jeg å lese schema.sql, måtte legge inn drinks og add_ons med verdier før jeg kunne legge inn noe på localhost. SQL-koden står i schema.sql under oppgave 2.
- Prepared statements og config-fil er ordnet for å fokusere mer på sikkerhet, samt. validering som er ett av kravene.
