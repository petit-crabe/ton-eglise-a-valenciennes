# Réglages Cloudflare faits hors du projet

Ce document liste les réglages du tableau de bord Cloudflare (AD-2). Les noms
des menus et des champs sont ceux du tableau de bord en français.

N'écris jamais ici un mot de passe, un jeton ou une clé (AD-14). Quand tu
changes un de ces réglages, mets ce document à jour par une demande de fusion.

Certains réglages sont aussi écrits dans `web/wrangler.jsonc`. Ceux-là, Cloudflare
les réapplique à chaque mise en ligne : si tu les changes seulement dans le
tableau de bord, la mise en ligne suivante les remettra comme dans le fichier.
Ils sont signalés par « (fichier) » ci-dessous.

## Construction du site (Compilations)

Où : **Workers et Pages** > `ton-eglise-a-valenciennes` > **Paramètres** >
**Compilations**.

| Champ | Valeur |
| --- | --- |
| Référentiel Git | `petit-crabe/ton-eglise-a-valenciennes` |
| Branche en production | `main` |
| Commande de build | `npm run build` |
| Déployer la commande | `npx wrangler deploy` |
| Builds pour les branches d'aperçu | activé |
| Commande d'aperçu | `npx wrangler preview` |
| Répertoire racine | `web` |
| Chemins de surveillance des builds | inclure `*`, rien d'exclu |
| Jeton d'API | celui nommé « Builds de Workers - 2026-10-19 10:11 » |
| Variables et secrets | aucun |
| Cache du build | désactivé |
| Version de Node | rien à régler : Cloudflare la lit dans `web/.nvmrc` |

Cloudflare ne permet pas ici de limiter les aperçus à la seule branche
`preprod` : chaque branche envoyée sur GitHub obtient son propre lien d'essai.
Ce n'est pas un problème, car ces liens ne sont publiés nulle part et le site y
interdit le référencement par Google.

Pendant la construction, Cloudflare indique quelle branche il construit. Seule
`main` est traitée comme le vrai site ; pour toutes les autres, la construction
demande à Google de ne pas référencer les pages (AD-10).

Le lien d'essai de `preprod` est :
`preprod-ton-eglise-a-valenciennes.contact-floriandesmet.workers.dev`.

## Adresses du site (Domaines)

Où : **Workers et Pages** > `ton-eglise-a-valenciennes` > **Domaines** >
**URL du Worker**.

| Ligne | État |
| --- | --- |
| Production (`ton-eglise-a-valenciennes.contact-floriandesmet.workers.dev`) | désactivée (fichier : `workers_dev: false`) |
| Aperçu (`*-ton-eglise-a-valenciennes.contact-floriandesmet.workers.dev`) | activée (fichier : `preview_urls: true`) |
| Domaines personnalisés et routes | aucun pour l'instant ; le vrai nom de domaine sera ajouté lors du passage à Cloudflare |

Avec les aperçus activés, Cloudflare crée aussi une adresse en `workers.dev`
pour chaque version du vrai site. Le site demande à Google de ne référencer
aucune adresse en `workers.dev`, même pour la version du vrai site, pour que ces
copies n'apparaissent pas dans les recherches (AD-10).

## Journaux d'activité (Observabilité)

Où : **Workers et Pages** > `ton-eglise-a-valenciennes` > **Paramètres** >
**Observabilité**, onglets **Production** et **Base des aperçus**.

| Réglage | Production | Base des aperçus |
| --- | --- | --- |
| Journaux Workers | activés (fichier) | désactivés (fichier) |
| Inclure les journaux d'invocation | oui (fichier) | — |
| Conserver les journaux sur le tableau de bord Workers | oui (fichier) | — |
| Échantillonnage des journaux | 100 % (fichier) | — |
| Workers Traces | désactivé (fichier) | désactivé (fichier) |
| Problèmes | désactivé | désactivé |

## Statistiques de visite (Web Analytics)

Où : **Observability** > **Analytics** > **Web Analytics**.

Aucun site n'y est déclaré pour l'église : rien n'est ajouté automatiquement
aux pages. Le code de statistiques sera ajouté à la main dans le site (AD-7).
Lors du passage du nom de domaine à Cloudflare, vérifie que la « Configuration
automatique » n'est pas activée pour `tonegliseavalenciennes.fr`.

## Historique des changements

| Date | Qui | Quoi |
| --- | --- | --- |
| 2026-11-12 | Florian Desmet | Projet relié à Cloudflare ; aperçus activés, adresse `workers.dev` du vrai site désactivée, journaux gardés pour le vrai site et coupés pour les aperçus |
