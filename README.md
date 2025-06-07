# 📚 Projeto **Biblioteca** – API em Laravel

Sistema de Gerenciamento de Empréstimos de Livros (Backend API)

---

## **Descrição**

API desenvolvida em **Laravel 12** para gerenciamento de empréstimos de livros, com autenticação baseada em tokens (Sanctum), modularização por CRUDs (categorias, autores, livros, leitores) e já preparada para TDD (Test Driven Development).

---

## **Tecnologias utilizadas**

- [Laravel 12](https://laravel.com/)
- [PHP 8.x](https://www.php.net/)
- [MySQL](https://www.mysql.com/)
- [Sanctum](https://laravel.com/docs/12.x/sanctum)
- [Laravel Breeze API](https://laravel.com/docs/12.x/starter-kits#laravel-breeze)
- [PHPUnit](https://phpunit.de/) (TDD)
- [Composer](https://getcomposer.org/)

---

## **Estrutura inicial do projeto**

```
biblioteca/
├── app/
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   ├── api.php
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── .env
├── composer.json
├── phpunit.xml
└── README.md
```

---

## **Passo a passo executado até o momento**

1. **Criação do projeto Laravel**
   ```bash
   composer create-project laravel/laravel biblioteca
   cd biblioteca
   ```

2. **Inicialização do repositório git**
   ```bash
   git init
   git add .
   git commit -m "feat: estrutura inicial do projeto Laravel biblioteca"
   ```

3. **Configuração do banco de dados MySQL**
   - Criada a base `biblioteca` no MySQL.
   - Ajustado o arquivo `.env`:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=biblioteca
     DB_USERNAME=seu_usuario
     DB_PASSWORD=sua_senha
     ```

4. **Execução das migrations iniciais**
   ```bash
   php artisan migrate
   ```

5. **Instalação do Laravel Breeze para API**
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install api
   php artisan migrate
   ```

6. **Configuração de autenticação via token (Sanctum)**
   - Adicionado trait `HasApiTokens` ao model `User`.
   - Ajustado o controller `AuthenticatedSessionController` para usar **token** (API) e não **sessão** (web).
   - Corrigido `.env` para:
     ```
     SESSION_DRIVER=array
     ```

7. **Criação de seeder para usuário admin**
   - Arquivo: `database/seeders/AdminUserSeeder.php`
   - Comando para rodar:
     ```bash
     php artisan db:seed
     ```
   - Usuário criado:
     ```
     email: admin@biblioteca.com
     senha: Senha123!
     role: admin
     ```

8. **Ajuste das rotas de autenticação**
   - Em `routes/api.php`:
     ```php
     Route::post('/register', [RegisteredUserController::class, 'store']);
     Route::post('/login', [AuthenticatedSessionController::class, 'store']);
     Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');
     Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
         return $request->user();
     });
     ```

9. **Testes de autenticação (via Postman/cURL)**
   - Registro: `POST /api/register`
   - Login: `POST /api/login` (retorna token)
   - Rotas protegidas: `GET /api/user` (usa header `Authorization: Bearer {token}`)

---

## **Como rodar o projeto**

1. Clone este repositório:
   ```bash
   git clone git@github.com:Alikson-Ramos/bliblioteca.git
   cd biblioteca
   ```

2. Instale as dependências:
   ```bash
   composer install
   ```

3. Copie o arquivo de variáveis de ambiente:
   ```bash
   cp .env.example .env
   ```

4. Configure o banco de dados no `.env` conforme sua máquina.

5. Gere a chave da aplicação:
   ```bash
   php artisan key:generate
   ```

6. Execute as migrations e seeders:
   ```bash
   php artisan migrate --seed
   ```

7. Inicie o servidor:
   ```bash
   php artisan serve
   ```

---

## **Como testar autenticação da API (exemplo com Postman ou cURL)**

### **Cadastro**
- Método: `POST`
- URL: `http://127.0.0.1:8000/api/register`
- Body (JSON):
  ```json
  {
    "name": "Novo Usuário",
    "email": "novo@usuario.com",
    "password": "Senha123!",
    "password_confirmation": "Senha123!"
  }
  ```

### **Login**
- Método: `POST`
- URL: `http://127.0.0.1:8000/api/login`
- Body (JSON):
  ```json
  {
    "email": "novo@usuario.com",
    "password": "Senha123!"
  }
  ```

- Retorno esperado:
  ```json
  {
    "user": { ... },
    "token": "eyJ0eXAiOiJKV1QiLCJ..."
  }
  ```

### **Acesso a rota protegida**
- Método: `GET`
- URL: `http://127.0.0.1:8000/api/user`
- Headers:
  ```
  Authorization: Bearer {token}
  ```

---

## ** TDD**

- Para rodar os testes:
  ```bash
  php artisan test
  ```
- Para criar novos testes:
  ```bash
  php artisan make:test NomeDoTeste
  ```

---

## **Autores**

- Desenvolvido por Alikson Ramos

---

