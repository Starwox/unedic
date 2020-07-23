# Unedic - Test

## Prérequis:

- PHP 7
- Composer
- Symfony

## Commande à utiliser:
Composer: (Installation des dépendances)
```bash
composer install
```
Yarn: (Installation des dépendances)
```bash
yarn install
```
Webpack: (Compilation du CSS / JS)
```bash
yarn encore dev
```
Symfony: (Démarrage du serveur)
```bash
symfony server:start
```
Personnalisé: (Création d'un Department de test)
```bash
php bin/console app:create-department
```

## Route API:

### Principales:

[Get All Department](https://localhost:8000/api/department) / Method: GET

*Lien : https://localhost:8000/api/department*

```json
{
    "id"
    "Name"
    "Capacity"
    "student" => [
      "id",
      "FirstName",
      "LastName",
      "NumEtud"
    ]
}
```
  
-----

[Get All Department](https://localhost:8000/api/create_student) / Method: POST

*Lien : https://localhost:8000/api/create_student*

```json
{
    "success",
    "id",
    "firstname",
    "lastname",
    "numetud"
}
```
  
-----

[Add Student to Department](https://localhost:8000/api/add_studtodep) / Method: POST

*Lien : https://localhost:8000/api/create_student*

**Datas à envoyer:** *student_id* / *department_id*

```json
{
    "success"
}
```
  
-----

[Get Department by ID](https://localhost:8000/api/oneDepart) / Method: POST

*Lien : https://localhost:8000/api/create_student*

**Datas à envoyer:** *department_id*

```json
{
    "id"
    "Name"
    "Capacity"
    "student" => [
      "id",
      "FirstName",
      "LastName",
      "NumEtud"
    ]
}
```
  
-----


