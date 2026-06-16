# Plan for LTS 2026

Bas: `4.11.6`. Nuvarande LTS-head: `bf518053`. Ny upstream-bas: `5.23.1`.

## Slutsats

Rebasen bör utgå från upstream `5.23.1` och bara återskapa LTS-specifika
paketerings-, säkerhets- och kompatibilitetsval. Flera äldre LTS-fixar är
redan ersatta av upstreams bredare refaktoreringar.

## Arbetsplan

- [ ] Starta från upstream `5.23.1`.
- [ ] Återskapa Composer/pluginmetadata för LTS: paketnamn, licens och
      installer-konfiguration.
- [ ] Behåll upstreams nya controller- och sanitizer-kontrakt.
- [ ] Återskapa datalist-stödet i `Field` om det fortfarande används.
- [ ] Återskapa MU/textdomain-kompatibilitet smalt om paketet fortfarande kan
      laddas som MU-plugin.
- [ ] Verifiera komponenterna `Collection__item`, `Field`, `Nav`, `Drawer` och
      `Card` mot de LTS-beteenden som finns i dagens fork.

## Beslutstabell

| Område | Vår slutändring | Upstream-läge | Bedömning | Berörda commits |
| --- | --- | --- | --- | --- |
| Composer och pluginmetadata | Bytte paketnamn till `municipio/wp-plugin-hbg-component-library`, GPL och installer-konfiguration. | `5.23.1` använder fortfarande `helsingborg-stad/component-library`, MIT och ny upstream dependency-yta. | Återskapa smalare | `feb04bd7`, `01d8f0db`, dokumentations-/licenscommits |
| Tag- och ID-sanitization | Lade till bred `TagSanitizer` samt ID-sanitization för komponentattribut. | Upstream har `TagSanitizerInterface` och `sanitizeIdAttribute()`, men inte samma breda rekursiva stripping. | Ersätt ID-fixen, verifiera/återskapa XSS-skydd smalare | `d0f8f6ea`, `cefea174` |
| Signature updated-only | Tillät signatur när bara uppdateringsdatum finns. | Upstreams `Signature` hanterar publicerad/uppdaterad data bredare. | Släpp | `cf897959` |
| Field datalist | Lade till datalist-stöd i fältkomponenten. | Hittades inte i `5.23.1`. | Behåll | `948b26f7`, `77dfa867` |
| MU/textdomain-kompatibilitet | Justerade textdomain-laddning för MU-plugin-scenarier. | Upstreams bootstrap använder fortfarande vanlig textdomain-laddning. | Återskapa smalare | `5ba45144` |
| Tillgänglighetsfixar | Tog bort ogiltiga ARIA-attribut och justerade drawer/nav/card-markup. | Upstream har omfattande komponentförändringar och flera motsvarande förbättringar. | Ersätt, verifiera i de komponenter där LTS hade lokala patchar | `053245cc`, `27b3b9d`, `1410508f`, `301689cb`, `7bb68a7d`, `544305b3` |
| Collection displayIcon | Gjorde ikonvisning styrbar via config. | Upstream har ändrat component data-yta. | Verifiera manuellt | `b8694f68` |
| Workflows, byggartefakter, asset-churn | Tog bort eller ändrade CI/assets. | Ska inte rebasas som källa. | Ej relevant | workflow-/assetcommits |

## Risker att verifiera

- Den breda LTS-`TagSanitizer` kan bryta tillåtna component payloads om den
  förs över rakt av.
- Datalist-stödet saknar upstream-motsvarighet och behöver UI-testas.
- Textdomain-laddning måste fungera både som vanlig plugin och som MU-plugin.

## Analyskommandon

- `git diff --stat 4.11.6..HEAD`
- `git diff --stat 4.11.6..5.23.1`
- `git diff --stat HEAD..5.23.1`
- `git log --reverse --format='%h%x09%ad%x09%s' --date=short 4.11.6..HEAD`
- `git log --reverse --format='%h%x09%ad%x09%s' --date=short 4.11.6..5.23.1`
- Riktade `git diff`, `git show`, `git grep` och `git cherry` för Composer,
  bootstrap, `BaseController`, `TagSanitizer`, `Field`, `Signature` och
  berörda component views.
