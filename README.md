# LeBonCode
Réalisez un site de vente de produit comme LeBonCoin.  
Vous commencez le projet avec un symfony skeleton.  
Vous disposez aussi d'un docker-compose.

##Advert

#### Create advert `POST`
Un utilisateur pourra ajouter un produit à vendre (`/advert`) avec ses informations :
- Titre de l'annonce
- Description du produit
- Prix de vente
- Code postal
- ville de vente
#### Delete advert  `DELETE`
Un utilisateur pourra supprimer une annonce (`/advert/{id}`).
la suppression rend l'annonce inactive
#### Update advert `PATCH`
Un utilisateur pourra modifier les informations d'une annonce (`/advert/{id}`).
Le titre de l'annonce ne peut pas être modifié.
#### List advert `GET`
Un utilisateur pourra récupérer la liste des annonces (`/advert`).
#### Advert by id `GET`
Un utilisateur pourra récupérer les informations d'une annonces (`/advert/{id}`) avec son `id` associé.
#### Search advert `GET`
Un utilisateur pourra chercher une annonce (`/advert/search`).
- title
- price min
- price max

#### Delete advert  `DELETE`
Un utilisateur pourra supprimer une annonce (`/advert/{id}`).
la suppression rend l’annonce inactive

##User

#### Register `POST`
Un utilisateur pourra s'enregistrer (`/register`) avec au minimum :
- Nom
- Prénom
- Numéro de téléphone
- Email
- Mot de passe
lors de la création l'utilisateur appartient au groupe `USER`

####Login `POST`
Par défaut, l'utilisateur appartiendra au groupe `USER`.
Un utilisateur pourra se connecter (`/login`) avec ses identifiant :
- Email
- Password
`https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation`

####Sécurisation des routes
Les routes ne sont plus accessibles que part des utilisateurs connecté