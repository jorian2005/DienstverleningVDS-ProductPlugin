# VDS Producten Plugin

De **VDS Producten Plugin** is speciaal ontwikkeld voor Dienstverlening van der Sluis om eenvoudig producten te beheren en te presenteren op een WordPress-website. De plugin biedt ondersteuning voor aangepaste posttypes, meta-boxen voor productinformatie, en op maat gemaakte templates.

## Functionaliteiten

- **Aangepast Posttype**  
  Registreert een speciaal posttype `vds_product` voor het beheren van producten.

- **Meta-boxen**  
  Voeg extra productinformatie toe, zoals prijs en afbeeldingen.

- **Aangepaste Templates**  
  Voorzie productarchieven en individuele productpagina’s van eigen templates.

- **Scripts en Stijlen**  
  Inclusief op maat gemaakte CSS en JavaScript voor een verbeterde gebruikerservaring.

## Installatie

1. Download of clone deze repository naar de map `wp-content/plugins/` binnen je WordPress-installatie.
2. Activeer de plugin via het WordPress-beheerderspaneel onder **Plugins**.
3. Voeg producten toe via het nieuwe menu-item **VDS Producten** in het dashboard.

## Bestandsstructuur

```
vdSluisProducten/
├── includes/
│   ├── cpt-vds-product.php      # Registreert het aangepaste posttype
│   ├── meta-boxes.php           # Beheert meta-boxen voor productinformatie
│   ├── templates.php            # Laadt aangepaste templates
│   └── enqueue.php              # Voegt scripts en stijlen toe
│
├── templates/
│   ├── archive-vds_product.php  # Template voor productoverzicht
│   ├── single-vds_product.php   # Template voor individuele productpagina
│
├── assets/
│   ├── css/
│   │   ├── archive-product.css
│   │   └── single-product.css
│   └── js/
│       └── vds-product.js
│
└── vdSluisProducten.php         # Hoofdpluginbestand
```

## Hooks en Filters

### Acties (Actions)

- `init` — Registreert het aangepaste posttype.
- `add_meta_boxes` — Voegt meta-boxen toe aan het productposttype.
- `save_post` — Verwerkt en slaat meta-boxgegevens op.
- `wp_enqueue_scripts` — Laadt frontend scripts en stijlen.

### Filters

- `template_include` — Overschrijft standaardtemplates met aangepaste producttemplates.

## Gebruik

### Producten toevoegen

1. Ga in het WordPress-dashboard naar **VDS Producten**.
2. Klik op **Nieuw product**.
3. Vul de titel, prijs en eventuele afbeeldingen in.
4. Publiceer het product.

### Templates

- **Archiefpagina**  
  `archive-vds_product.php` toont een overzicht van alle producten.

- **Individuele productpagina**  
  `single-vds_product.php` toont een detailpagina van één product.

## Voor Ontwikkelaars

### Scripts en Stijlen

Scripts en stijlen worden geladen via `vds_enqueue_scripts()` en `vds_enqueue_styles()` in [`enqueue.php`](includes/enqueue.php).

### Meta-boxen

De meta-boxen bevinden zich in [`meta-boxes.php`](includes/meta-boxes.php). Hier kunnen extra velden worden toegevoegd of bestaande velden aangepast.

### Aangepast Posttype

Het posttype `vds_product` wordt gedefinieerd in [`cpt-vds-product.php`](includes/cpt-vds-product.php).

## Ondersteuning

Voor vragen of ondersteuning kun je contact opnemen met de ontwikkelaar:  
**[Jorian Beukens](https://jorianbeukens.nl)**

## Licentie

Deze plugin is intellectueel eigendom van **Dienstverlening van der Sluis** en mag niet worden verspreid of hergebruikt zonder expliciete toestemming.
