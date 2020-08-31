GRAPHITE
=======

Lager grafisk fremstilling av en excel-fil (typisk fra jotform)


## For å bruke:

URL'en du ønsker å bruke legger føringer for hvor filene skal lagres:

URL defineres som følgende, https://graphite.ukm.no/åå/filnavn, hvor 

- `åå` definerer årstall med 2 sifre
- `filnavn` består av bokstavene `a-Z`, understrek (`_`) og/eller bindestrek (`-`)


**Datagrunnlaget** lagres i .xlsx-format i mappen `Datagrunnlag` og må ha navnestandarden `åå-filnavn.xlsx`

**Designfilen** lagres i .twig-format i mappen `Views/` og må ha navnestandarden `20åå/Filnavn.html.twig`
Merk at mappen må starte med 20, og at filnavnet må starte med stor forbokstav.