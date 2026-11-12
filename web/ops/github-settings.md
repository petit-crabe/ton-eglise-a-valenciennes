# Réglages GitHub faits hors du projet

Ce document liste les réglages faits dans GitHub pour le dépôt
`petit-crabe/ton-eglise-a-valenciennes` (AD-2). Les noms des menus et des
champs sont ceux de GitHub, qui est en anglais.

N'écris jamais ici un mot de passe ou un jeton. Quand tu changes un de ces
réglages, mets ce document à jour par une demande de fusion.

## Verrou sur les trois branches principales

Les branches `develop`, `preprod` et `main` ne changent que par une demande de
fusion (« pull request ») que tu acceptes toi-même. Personne ne peut y envoyer
un changement directement, ni les effacer, ni les réécrire, toi compris : ainsi
un envoi par erreur depuis un ordinateur ne peut ni modifier l'aperçu
(`preprod`) ni le vrai site (`main`).

### Comment le mettre en place

1. Ouvre le dépôt sur GitHub, puis **Settings** > **Rules** > **Rulesets**.
2. Clique **New ruleset** > **New branch ruleset**.
3. Remplis le haut de la page :
   - **Ruleset Name** : `protect-develop-preprod-main`
   - **Enforcement status** : **Active**
   - **Bypass list** : laisse vide. Si tu t'y ajoutes, GitHub te laissera
     envoyer directement et le verrou ne servira plus à rien.
4. Dans **Target branches**, clique **Add target** > **Include by pattern**
   trois fois, avec `develop`, puis `preprod`, puis `main`.
5. Dans **Branch rules**, coche seulement :
   - **Restrict deletions**
   - **Block force pushes**
   - **Require a pull request before merging**, avec **Required approvals**
     à `0` : tu es seul à accepter les demandes de fusion, et GitHub ne te
     laisse pas approuver la tienne.
   Laisse tout le reste décoché.
6. Clique **Create** en bas de la page.

### Comment vérifier sans rien risquer

1. Sur la page d'accueil du dépôt, choisis la branche `preprod`, ouvre
   n'importe quel fichier et clique le crayon pour le modifier.
2. Clique **Commit changes...** sans rien changer d'autre. GitHub ne doit plus
   proposer d'enregistrer sur `preprod` : il impose de créer une nouvelle
   branche. Clique **Cancel**.

Si GitHub propose encore d'enregistrer directement sur `preprod`, le verrou
n'est pas actif : reprends les étapes 3 à 5 (état, branches visées, règles).

### Réglage attendu

| Champ | Valeur |
| --- | --- |
| Ruleset Name | `protect-develop-preprod-main` |
| Enforcement status | Active |
| Bypass list | vide |
| Target branches | `develop`, `preprod`, `main` |
| Restrict deletions | coché |
| Block force pushes | coché |
| Require a pull request before merging | coché, Required approvals `0` |
| Autres règles | décochées |

## Historique des changements

| Date | Qui | Quoi |
| --- | --- | --- |
| à remplir | à remplir | Verrou posé sur `develop`, `preprod` et `main` |
