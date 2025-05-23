# VDS Producten Plugin

De **VDS Producten Plugin** is speciaal ontwikkeld voor Dienstverlening van der Sluis om eenvoudig producten te beheren en te presenteren op een WordPress-website. De plugin biedt ondersteuning voor aangepaste posttypes, meta-boxen voor productinformatie, en op maat gemaakte templates.

---

## Functionaliteiten

- **Aangepast Posttype**  
  Registreert een speciaal posttype `vds_product` voor het beheren van producten.

- **Meta-boxen**  
  Voeg extra productinformatie toe, zoals prijs, afbeeldingen, hefhoogte, draaiuren, en meer.

- **Shortcodes**  
  Gebruik `[last_three_products]` om de laatste drie producten weer te geven.

- **Aangepaste Templates**  
  Voorzie productarchieven en individuele productpagina’s van eigen templates.

- **Scripts en Stijlen**  
  Inclusief op maat gemaakte CSS en JavaScript voor een verbeterde gebruikerservaring.

---

## Installatie

1. Download of clone deze repository naar de map `wp-content/plugins/` binnen je WordPress-installatie.
2. Activeer de plugin via het WordPress-beheerderspaneel onder **Plugins**.
3. Voeg producten toe via het nieuwe menu-item **VDS Producten** in het dashboard.

---

## Gebruik

### Producten toevoegen

1. Ga in het WordPress-dashboard naar **VDS Producten**.
2. Klik op **Nieuw product**.
3. Vul de titel, prijs en eventuele afbeeldingen in.
4. Publiceer het product.

### Shortcode

- **Laatste drie producten weergeven**  
  Voeg de shortcode `[last_three_products]` toe aan een pagina of bericht om de drie meest recente producten te tonen.

---

## Bestandsstructuur

```
DienstverleningVDS-ProductPlugin/
├── includes/
│   ├── cpt-vds-product.php      # Registreert het aangepaste posttype
│   ├── meta-boxes.php           # Beheert meta-boxen voor productinformatie
│   ├── templates.php            # Laadt aangepaste templates
│   └── enqueue.php              # Voegt scripts en stijlen toe
├── templates/
│   ├── archive-vds_product.php  # Template voor productoverzicht
│   ├── single-vds_product.php   # Template voor individuele productpagina
├── assets/
│   ├── css/
│   │   ├── archive-product.css
│   │   └── single-product.css
│   └── js/
│       └── vds-product.js
├── pages/
│   └── shortcode.php            # Shortcode functionaliteit
└── vdSluisProducten.php         # Hoofdpluginbestand
```

---

## Hooks en Filters

### Acties (Actions)

- `init` — Registreert het aangepaste posttype.
- `add_meta_boxes` — Voegt meta-boxen toe aan het productposttype.
- `save_post` — Verwerkt en slaat meta-boxgegevens op.
- `wp_enqueue_scripts` — Laadt frontend scripts en stijlen.

### Filters

- `template_include` — Overschrijft standaardtemplates met aangepaste producttemplates.

---

## Voor Ontwikkelaars

### Shortcodes

De shortcode `[last_three_products]` is gedefinieerd in [`shortcode.php`](pages/shortcode.php). Deze toont de drie meest recente producten met hun titel, prijs en afbeelding.

### Meta-boxen

De meta-boxen bevinden zich in [`meta-boxes.php`](includes/meta-boxes.php). Hier kunnen extra velden worden toegevoegd of bestaande velden aangepast.

### Templates

- **Archiefpagina**  
  `archive-vds_product.php` toont een overzicht van alle producten.

- **Individuele productpagina**  
  `single-vds_product.php` toont een detailpagina van één product.

---

## Ondersteuning

Voor vragen of ondersteuning kun je contact opnemen met de ontwikkelaar:  
**[Jorian Beukens](https://jorianbeukens.nl)**

---

## Licentie

Deze plugin is gelicenseerd onder de **GNU General Public License v3.0**. Voor meer informatie over de licentievoorwaarden, zie [LICENSE](https://www.gnu.org/licenses/gpl-3.0.html).