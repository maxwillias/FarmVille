# FarmVille
Sistema que auxilia no controle de uma fazenda de bovinos.

---

Pré-requisitos para rodar o projeto:

* PHP/Composer
* Symfony
* Docker

---

Instruções para rodar o projeto:

```bash
git clone https://github.com/maxwillias/DFranquias-FarmVille.git
cd ./DFranquias-FarmVille/
composer install
docker compose up --pull always -d --wait
symfony console doctrine:database:create
symfony console doctrine:migrations:migrate
symfony server:start
```

Acesse: http://localhost:8000/
