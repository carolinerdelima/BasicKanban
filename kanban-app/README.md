# Kanban App

Aplicação web estilo Kanban construída com Laravel 11, PostgreSQL, autenticação via Sanctum e controle de permissões com Spatie. O ambiente é totalmente Dockerizado para facilitar o desenvolvimento.

---

## ✅ Tecnologias Utilizadas

- **Laravel 11**
- **PHP 8.2**
- **PostgreSQL 15**
- **Laravel Sanctum** (autenticação)
- **Spatie Laravel Permission** (papéis e permissões)
- **Node.js 20 + NPM** (frontend com Vite)
- **Bootstrap 5.3** (interface responsiva)
- **jQuery 3.7** (requisições AJAX)
- **Docker + Docker Compose**

---

## 🔍 Verificando o Ambiente

Antes de iniciar o projeto, certifique-se de que as tecnologias abaixo estão instaladas corretamente em sua máquina.

### ✅ Requisitos do Ambiente

| Tecnologia                 | Versão mínima | Comando para checar              |
|---------------------------|---------------|----------------------------------|
| PHP                       | 8.2+          | `php -v`                         |
| Composer                  | 2.x           | `composer --version`            |
| PostgreSQL                | 15.x          | `psql --version`                |
| Node.js                   | 20.x          | `node -v`                        |
| NPM                       | 9.x ou +      | `npm -v`                         |
| Docker                    | 24.x ou +     | `docker --version`              |
| Docker Compose            | 2.x ou +      | `docker compose version`        |


---

## 🚀 Instalação do Projeto com Docker

Requisitos:
> - Docker instalado: https://docs.docker.com/get-docker/
> - Docker Compose v2+

---

### 1. Clone o repositório

```bash
git clone https://github.com/carolinerdelima/BasicKanban.git
cd kanban-app
```

### 2. Copie o arquivo .env
```bash
cp .env.example .env
```

### 3. Suba os containers
```bash
docker-compose up -d --build
```

### 4. Instale as dependências PHP (dentro do container app)
```bash
docker exec -it kanban-app bash
composer install
```

### 5. Geração da chave de criptografia (APP_KEY)
```bash
php artisan key:generate
```

### 6. Rodar as migrations
Entre no container:

```bash
docker exec -it kanban-app bash

```

E após estar dentro do container:

```bash
php artisan migrate
```

### 7. Corrigindo as permissões no host (na máquina local)
```bash
sudo chown -R $USER:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage/logs
sudo chmod -R 775 storage/logs
```