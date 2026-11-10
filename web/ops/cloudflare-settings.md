# Réglages Cloudflare faits hors du projet

Ce document liste les réglages qui se font uniquement dans le tableau de bord
Cloudflare, et pas dans les fichiers du projet (AD-2). Les noms des menus et des
champs sont donnés en anglais, tels qu'ils apparaissent dans Cloudflare.

N'écris jamais ici un mot de passe, un jeton ou une clé (AD-14). Quand tu
changes un de ces réglages, mets ce document à jour par une demande de fusion.

## Relier le projet GitHub à Cloudflare (Workers Builds)

Où : **Workers & Pages** > le Worker `ton-eglise-a-valenciennes` > **Settings** >
**Builds**.

| Champ dans Cloudflare | Valeur à mettre |
| --- | --- |
| Git repository (dépôt GitHub) | `petit-crabe/ton-eglise-a-valenciennes` |
| Root directory (dossier du site) | `web` |
| Production branch (branche du vrai site) | `main` |
| Build command (commande de construction) | `npm run build` |
| Deploy command (mise en ligne du vrai site) | `npx wrangler deploy` |
| Non-production branch deploy command (mise en ligne des essais) | `npx wrangler preview` |
| Builds for non-production branches (construire les autres branches) | activé, pour `preprod` seulement (filtre des branches : `preprod`) |
| Version de Node | rien à régler : Cloudflare la lit dans `web/.nvmrc` |

Tu n'as aucune variable à ajouter. Pendant la construction, Cloudflare indique
quelle branche il construit. Seule `main` est traitée comme le vrai site ; pour
toutes les autres, la construction demande à Google de ne pas référencer les
pages (AD-10).

Le lien d'essai de `preprod` aura cette forme :
`preprod-ton-eglise-a-valenciennes.<ton sous-domaine>.workers.dev`. N'importe qui
peut l'ouvrir s'il a le lien, mais il n'est publié nulle part.

## Adresses du site

| Réglage | État |
| --- | --- |
| Adresse `workers.dev` du vrai site | désactivée (`workers_dev: false` dans `wrangler.jsonc`) |
| Liens d'essai (Preview URLs) | activés (`preview_urls: true` dans `wrangler.jsonc`) |

Avec les liens d'essai activés, Cloudflare crée aussi une adresse en
`workers.dev` pour chaque version du vrai site, de la forme
`<version>-ton-eglise-a-valenciennes.<ton sous-domaine>.workers.dev`. Le site
demande à Google de ne référencer aucune adresse en `workers.dev`, même pour la
version du vrai site, pour que ces copies n'apparaissent pas dans les recherches
(AD-10).

## Statistiques de visite (Web Analytics)

| Réglage | État |
| --- | --- |
| Ajout automatique du code de statistiques | désactivé (le code est ajouté à la main dans le site, AD-7) |

## Historique des changements

| Date | Qui | Quoi |
| --- | --- | --- |
| _à remplir par toi_ | _à remplir par toi_ | Projet relié à Cloudflare avec les réglages ci-dessus |
