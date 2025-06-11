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
