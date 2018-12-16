# Micro framework php en procédural et MVC

Ce projet est un micro framework développé dans le cadre de mon poste de formateur Simplon à l'ADEP de Roubaix.

Il a pour objectif de proposer aux étudiants un cadre de travail organisé tout en restant simple et abordable pour des débutants. Il les prépare ainsi à des notions abordées plus tard dans le programme et les familiarise avec des outils standards tels que le routeur. Ici par exemple un modèle basique de routeur entièrement en PHP leur est proposé pour leur usage.

## Démarrage

Pour utiliser ce petit framework, il suffit de le cloner sur mon repository et de s'en servir comme base de travail.

Attention, il ne sert à rien de faire des copier-coller des différents pour les intégrer à un projet existant. Il faut utiliser le dossier en l'état. C'est à vous d'y inclure votre code et non l'inverse. Le moindre fichier manquant empêchera l'ensemble de fonctionner.

Attention également ce "framework" n'a qu'une visée pédagogique, il permet de mettre les étudiants en contact avec des notions présentes dans les frameworks professionnels de manière simplifiée. Il ne peut en aucun cas être utilisé pour une mise en production.

## La configuration

Pour être utilisé, le framework nécessite une configuration minimale afin de pouvoir utiliser tous les outils. Cette configuration se fait dans le fichier global.php qui se trouve dans le dossier config présent à la racine du projet.

Vous y trouverez un tableau associatif $config qui attend 4 éléments :
- Le protocol que vous pouvez laisser vide pour l'instant
- L'hôte, il s'agit de l'adresse de votre projet
- Un tableau contenant les différents statuts des utilisateurs sur votre site, attention ceux-ci doivent être indiqués dans l'ordre hiérarchique. Dans l'exemple donné, les administrateurs sont aux dessus des utilisateurs. Vous pouvez utiliser les statuts que vous voulez, les réécrire, en ajouter, en supprimer tant que vous respectez cette condition.
- La route par défaut, il s'agit de la route où le visiteur sera renvoyé si jamais il n'a pas le statut nécessaire pour accéder à une page

## Le routeur

Il s'occupe de gérer les points d'entrées de votre site, il faut bien comprendre que tout ce que vous taperez dans l'url passera par le routeur. Il récupére l'url tapée et s'occupe en accord avec les routes que vous avez configuré d'appeler le bon contrôleur et la bonne fonction.

Concrètement le routeur est appelé à la racine, sur index.php, c'est par ce que fichier que passeront obligatoirement vos visiteurs. De même les contrôleurs et les vues sont chargés depuis l'index.

Pour configurer le routeur il faut paramètrer le fichier routes.php qui se trouve dans le dossier config. C'est là que vous allez définir les routes de l'application.

Une route se définie comme suit :

```
"NomDeLaRoute" => [
  "Controller (exemple admin pour adminController)",
  "Fonction (exemple listAdmins pour listAdmins())",
  Optionnel, un tableau de paramètres attendus
   [
    "parametre1" => ["typeAttendu", optionnel[valeursAttendues]],
    "parametre2" => ["typeAttendu", optionnel[valeursAttendues]]
  ]
 "status" => "role du visiteur à possèder au minimum (voir le fichier de config)"
]

```
Trois types sont utilisables, "integer", "string" et "boolean".
Les valeurs spécifiques attendues sont indiquées les unes à la suite des autres dans un tableau.

## La gestion des redirections

Dans la mesure où vous utilisez un routeur, vous ne pouvez pas renvoyer votre utilisateur vers un fichier, vous devez l'envoyer vers une route.

Pour cela, dans tous vos contrôleurs vous avez accès à l'URL manager qui vous offre des fonctions pour gérer les href des liens, les actions des formulaires et les redirections.

Vous avez donc trois fonctions :
- setHref qui echo un attribut href au sein d'une balise <a>
- setAction qui echo un attribut action au sein d'une balise <form>
- redirectTo qui éxecute un header Location

Ces trois fonctions attendent un premier paramètre qui la route ciblée sous forme de string puis un paramètre optionnel qui est un tableau contenant les paramètres attendus par la route s'il y en a. Exemple d'une route single attendant un paramètre id :

```
redirectTo("single", ["id" => "2"]);

```

## La gestion des sessions

Une grande partie des sessions est gérée automatiquement par le routeur qui s'occupe de vérifier que l'utilisateur à les droits d'accès à une page.

A noter, si une page est protégée par un status, alors le routeur s'occupe de démarrer la session, vous n'avez pas à le refaire dans le contrôleur.

Si vous devez démarrer vous même une session sur une page, vous avez accès à deux fonctions :
- initializeAnonymousSession qui démarre une session dite anonyme et n'attend aucun argument.
- initializeUserSession qui stocke en session à l'index "user" l'utlisateur passé en argument à la fonction. Attention l'utlisateur doit être représenté par un tableau associatif.

## Chargement des fichiers

Si vous un service ou autre fichier doit être accessible dans toutes les pages, il convient alors de le charger dans l'index.php, il sera alors accessible partout puisque le routeur fait de l'index le point de départ de l'application.

Si un fichier n'est accessible que dans un contrôleur en particulier, alors il convient de le charger dans le contrôleur en question avant de déclarer les fonctions de celui-ci.
