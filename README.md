# WhatsApp Manager — FilamentPHP + Evolution API

Sistema SaaS completo de gerenciamento de conexões WhatsApp com Evolution API, construído em Laravel 11 + FilamentPHP v3 com arquitetura multi-tenant.

---

## 📋 Visão Geral

O **WhatsApp Manager** é uma plataforma SaaS para gerenciar múltiplas instâncias WhatsApp através da [Evolution API](https://doc.evolution-api.com/). Cada empresa (tenant) possui seus dados completamente isolados.

### Stack

| Camada | Tecnologia |
|--------|-----------|
| Backend | PHP 8.2+ / Laravel 11 |
| Painel Administrativo | FilamentPHP v3 |
| Banco de Dados | MySQL 8.0+ |
| Cache/Queue | Redis |
| API WhatsApp | Evolution API |
| Frontend | TailwindCSS (via CDN) |

---

## 🗂️ Estrutura do Projeto

```
app/
├── DTOs/
│   ├── EvolutionInstanceDTO.php    # DTO para criação de instância
│   └── EvolutionMessageDTO.php     # DTO para envio de mensagem
├── Filament/
│   ├── Pages/
│   │   └── Dashboard.php           # Dashboard principal
│   ├── Resources/
│   │   └── WhatsappInstanceResource.php  # Resource de instâncias
│   └── Widgets/
│       ├── WhatsappStatsWidget.php  # Cards de estatísticas
│       └── RecentInstancesWidget.php  # Tabela de instâncias recentes
├── Http/
│   ├── Controllers/
│   │   ├── Auth/RegisterController.php   # Registro + criação de tenant
│   │   ├── WelcomeController.php          # Landing page
│   │   └── Webhook/WebhookController.php  # Recebe eventos da Evolution API
│   └── Middleware/
│       └── TenantMiddleware.php           # Injeta tenant no contexto
├── Jobs/
│   └── ProcessWebhookJob.php       # Processa eventos via fila
├── Models/
│   ├── Tenant.php                   # Empresa/organização
│   ├── User.php                     # Usuário com tenant
│   ├── WhatsappInstance.php         # Instância WhatsApp
│   └── WebhookLog.php               # Log de webhooks
├── Providers/
│   ├── AppServiceProvider.php
│   └── Filament/AdminPanelProvider.php  # Configuração do painel
└── Services/
    ├── EvolutionApiService.php      # Comunicação com Evolution API
    └── WhatsappInstanceService.php  # Lógica de negócios de instâncias
```

---

## 🚀 Instalação

### 🐳 Docker (recomendado)

**Pré-requisito:** Docker 24+ e Docker Compose v2.

```bash
# 1. Clone o repositório
git clone https://github.com/powman/whatsapp-filament.git
cd whatsapp-filament

# 2. Copie o arquivo de configuração Docker
cp .env.docker .env

# 3. Gere a chave da aplicação
docker compose run --rm app php artisan key:generate --show
# Cole o valor gerado em APP_KEY no seu .env

# 4. Ajuste as variáveis de ambiente no .env
#    EVOLUTION_API_BASE_URL, EVOLUTION_API_KEY, WEBHOOK_SECRET

# 5. Suba todos os serviços (build + start)
docker compose up -d --build

# 6. (Opcional) Execute o seeder para criar um usuário demo
docker compose exec app php artisan db:seed
```

A aplicação ficará disponível em **http://localhost:8000**.

> **Serviços iniciados pelo Docker Compose:**
> | Serviço | Descrição | Porta |
> |---------|-----------|-------|
> | `app` | PHP 8.2-FPM (Laravel) | interno |
> | `nginx` | Web server | 8000 |
> | `mysql` | MySQL 8.0 | interno |
> | `redis` | Cache / Filas | interno |
> | `queue` | Laravel Queue Worker | — |

#### Comandos úteis

```bash
# Ver logs
docker compose logs -f app

# Executar artisan
docker compose exec app php artisan <comando>

# Parar os serviços
docker compose down

# Parar e remover volumes (limpa banco de dados)
docker compose down -v
```

---

### 💻 Instalação local (manual)

**Pré-requisitos:** PHP 8.2+, Composer, MySQL 8.0+, Redis, Node.js 20+ / npm, Evolution API rodando.

```bash
# 1. Clone o repositório
git clone https://github.com/powman/whatsapp-filament.git
cd whatsapp-filament

# 2. Instale as dependências PHP
composer install

# 3. Copie o arquivo de configuração
cp .env.example .env

# 4. Gere a chave da aplicação
php artisan key:generate

# 5. Configure o banco de dados e a Evolution API no .env
# DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
# EVOLUTION_API_BASE_URL, EVOLUTION_API_KEY

# 6. Execute as migrations
php artisan migrate

# 7. (Opcional) Execute o seeder para criar um usuário demo
php artisan db:seed

# 8. Instale as dependências JS
npm install && npm run build

# 9. Configure o storage
php artisan storage:link

# 10. Inicie o servidor
php artisan serve

# 11. Inicie o worker de filas (em outro terminal)
php artisan queue:work
```

---

## ⚙️ Configuração do .env

```env
# Aplicação
APP_NAME="WhatsApp Manager"
APP_URL=http://localhost:8000

# Banco de Dados
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=whatsapp_filament
DB_USERNAME=root
DB_PASSWORD=

# Filas (use database ou redis)
QUEUE_CONNECTION=database

# Cache
CACHE_DRIVER=redis

# Evolution API
EVOLUTION_API_BASE_URL=http://localhost:8080
EVOLUTION_API_KEY=sua-chave-api-aqui

# Webhook Secret
WEBHOOK_SECRET=seu-secret-aqui
```

---

## 🔧 Funcionalidades

### 1. Landing Page
- Hero section com apresentação do produto
- Seção de recursos
- Como funciona (3 passos)
- Benefícios
- CTA para cadastro
- Layout responsivo com TailwindCSS

### 2. Autenticação e Multi-Tenant
- Registro cria automaticamente um `Tenant` vinculado ao usuário
- Cada usuário pertence a um tenant
- `TenantMiddleware` injeta o tenant no contexto da aplicação
- Isolamento total de dados via `tenant_id`

### 3. Gerenciamento de Instâncias WhatsApp
- **Criar**: cria localmente + registra na Evolution API
- **Listar**: tabela com status em tempo real (badges coloridos)
- **Conectar**: gera QR Code para escaneamento
- **Desconectar**: logout da instância
- **Atualizar Status**: sincroniza com a Evolution API
- **Excluir**: remove local e da Evolution API

### 4. Dashboard FilamentPHP
- Widget com total/ativas/desconectadas/aguardando QR
- Tabela de instâncias recentes
- Ações rápidas direto na tabela

### 5. Webhooks
- Endpoint: `POST /api/webhook/{tenantId}`
- Processamento assíncrono via `ProcessWebhookJob`
- Log de todos os eventos recebidos
- Suporte a `CONNECTION_UPDATE` e `QRCODE_UPDATED`

### 6. Integração Evolution API (`EvolutionApiService`)
```php
$service = app(EvolutionApiService::class);

// Criar instância
$service->createInstance($dto);

// Conectar e obter QR Code
$service->connectInstance($instanceName);

// Desconectar
$service->disconnectInstance($instanceName);

// Obter status
$service->getConnectionState($instanceName);

// Enviar mensagem
$service->sendTextMessage($instanceName, $messageDto);
```

---

## 🏗️ Arquitetura

### Multi-Tenancy
```
User → belongsTo → Tenant
WhatsappInstance → belongsTo → Tenant
WebhookLog → belongsTo → Tenant

// Todas as queries são filtradas por tenant_id
WhatsappInstance::where('tenant_id', auth()->user()->tenant_id)->get();
```

### Service Layer
```
Controller/Resource → Service → EvolutionApiService
                   → Model
```

### Queue/Jobs
```
WebhookController → WebhookLog::create() → ProcessWebhookJob::dispatch()
                                        → Processa evento
                                        → Atualiza WhatsappInstance
```

---

## 🔐 Segurança

- Autenticação via Laravel/Filament
- Proteção por tenant em todas as queries
- CSRF em formulários web
- Rate limiting no endpoint de webhook
- Filas para processar webhooks de forma assíncrona

---

## 📦 Dependências Principais

| Pacote | Versão | Uso |
|--------|--------|-----|
| `laravel/framework` | ^11.0 | Framework principal |
| `filament/filament` | ^3.3 | Painel administrativo |
| `guzzlehttp/guzzle` | ^7.9 | Cliente HTTP para Evolution API |

---

## 📄 Licença

MIT License — Livre para uso pessoal e comercial.