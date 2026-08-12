# LaraChat — ChatGPT Clone

A ChatGPT-style AI chat application built with **Laravel 13** and the official **Laravel AI SDK**, powered by **Google Gemini**. It features a real-time streaming chat interface, conversation history, and a set of AI "tools" that let the assistant query an in-application product/order catalog to answer product recommendations, order lookups, and business insight questions.

The frontend is built with **Livewire 4**, **Alpine.js**, and **Tailwind CSS 4**, styled after a classic ChatGPT layout with a dark theme.

---

## ✨ Features

- **Real-time streaming responses** — tokens are delivered incrementally via Server-Sent Events (SSE) as they are generated, with markdown rendering, syntax highlighting (Highlight.js), and one-click code copy.
- **Conversation memory** — multi-turn context is retained for each conversation via the Laravel AI SDK's agent conversation system.
- **Conversation sidebar** — list recent conversations, switch between them, start new chats, and delete individual conversations.
- **Attachments** — attach images (`.png`, `.jpg`, `.jpeg`) or documents (`.pdf`) to a message for multimodal AI analysis.
- **AI Tools (function calling)** — the assistant can query seeded business data:
  - `GetCurrentDateTime` — current date/time/day.
  - `SearchProducts` — filter products by category, keyword, max price; returns in-stock products.
  - `SearchOrders` — order status, category, and date-range queries with revenue totals.
- **Structured output agent** — a `ProductAnalyzerAgent` (currently disabled from the main agent's tool list) returns a schema-validated product evaluation (score, verdict, pros, cons, alternatives).
- **Dark ChatGPT-style UI** — sidebar, message bubbles, streaming cursor, suggestion chips, and markdown-powered responses.
- **No authentication required** — chat works as an anonymous "guest" participant out of the box.

---

## 🧱 Tech Stack

| Layer       | Technology                                                        |
| ----------- | ----------------------------------------------------------------- |
| Backend     | PHP 8.3+, Laravel Framework 13                                    |
| AI SDK      | Laravel AI (`laravel/ai`)                                          |
| AI Provider | Google Gemini (default), with many other providers configurable   |
| Realtime    | Server-Sent Events (SSE) streaming                                 |
| Frontend    | Livewire 4, Alpine.js 3, Tailwind CSS 4, Vite 8                    |
| Markdown    | marked + DOMPurify + Highlight.js (CDN)                            |
| Database    | SQLite (default)                                                   |

---

## 📁 Project Structure

```
app/
├── Ai/
│   ├── Agents/
│   │   ├── ChatAgent.php               # Main conversational agent (LaraChat)
│   │   └── ProductAnalyzerAgent.php    # Structured-output product analyzer (disabled)
│   └── Tools/
│       ├── GetCurrentDateTime.php      # Tool: current date/time/day
│       ├── SearchProducts.php          # Tool: product catalog search
│       └── SearchOrders.php            # Tool: order lookup & revenue
├── Http/Controllers/
│   └── StreamController.php            # SSE streaming endpoint
├── Livewire/Pages/
│   └── Chat.php                        # Livewire chat page component
├── Models/
│   ├── Order.php                       # Order model (belongs to User & Product)
│   ├── Product.php                     # Product model
│   └── User.php                        # User model
└── Providers/
    └── AppServiceProvider.php          # App defaults (CarbonImmutable, password rules)
config/
└── ai.php                              # AI provider configuration
database/
├── migrations/                         # users, cache, jobs, conversations, products, orders
└── seeders/                            # User, ProductSeeder, OrderSeeder
resources/views/
├── layouts/app.blade.php               # Base layout (CDN libs + Vite)
├── pages/⚡chat.blade.php              # Chat page (sidebar + chat box)
└── components/
    ├── ⚡chat-box.blade.php            # Message streaming UI + Alpine SSE client
    └── ⚡conversation-sidebar.blade.php# Conversation list/management
routes/
└── web.php                             # Routes (home, chat, SSE stream)
```

> **Note on file names:** Blade component/view files that contain a `⚡` character (e.g. `⚡chat.blade.php`) are **Livewire functional components**. This is a convention used by Custom `livewire/components` — do not rename them, as the routes and `livewire:` references depend on these exact names.

---

## 🚀 Installation

> Requirements: **PHP ^8.3**, **Composer**, **Node.js** (for Vite), and a **Google Gemini API key**.

### 1. Clone & install dependencies

```bash
git clone <your-repo-url> lara-ai-app
cd lara-ai-app

composer install
npm install
```

### 2. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Then open `.env` and set your AI provider:

```dotenv
# Pick the AI provider (default: openai)
AI_PROVIDER=gemini

# Google Gemini API key
GEMINI_API_KEY=your_google_gemini_api_key_here
```

The app has been built and tested against **Gemini 2.5 Flash**. If you use another provider, set the corresponding key/URL variables (the `config/ai.php` file documents the available providers: openai, anthropic, azure, gemini, groq, ollama, mistral, etc.).

### 3. Database setup

The default database is **SQLite**:

```bash
# Create the SQLite database file (if it doesn't already exist)
New-Item -ItemType File -Path database/database.sqlite -Force   # Windows (PowerShell)

# Run migrations and seed sample data
php artisan migrate --seed
```

The seeders create:
- A test user (`test@example.com`).
- **10 products** across categories: Laptops, Phones, Audio, Monitors, Accessories.
- **8 sample orders** with assorted statuses (completed, pending, cancelled).

> **Caution:** `Database\Factories\UserFactory` is referenced by the seeders (`User::factory()`) but is **missing from this repository**. Running `php artisan db:seed` / `--seed` will currently fail at the user factory step. Restore the standard `database/factories/UserFactory.php` (with a `definition()` returning `name`, `email`, and a hashed `password`) before seeding.

### 4. Build frontend assets & run

```bash
npm run build      # production build
php artisan serve  # start the dev server
```

For local development with hot reload:

```bash
npm run dev        # Vite dev server (in one terminal)
php artisan dev    # or: php artisan serve (in another terminal)
```

### 5. Open the app

Visit **`http://localhost:8000/chat`** to use LaraChat.

---

## 🧭 Routes

| Method | URI                    | Name          | Purpose                               |
| ------ | ---------------------- | ------------- | ------------------------------------- |
| GET    | `/`                    | `home`        | Landing / welcome page                |
| GET    | `/chat`                | `chat`        | Chat interface (new conversation)     |
| GET    | `/chat/{conversationId?}` | `chat`     | Chat interface (existing conversation)|
| POST   | `/chat/stream`         | `chat.stream` | SSE streaming endpoint                |

---

## ⚙️ How It Works

1. The user types a message (and optionally attaches a file) in the Livewire chat box.
2. A browser `fetch()` call is made to `POST /chat/stream`, which instantiates `App\Ai\Agents\ChatAgent` and calls `agent->stream(...)`.
3. The `StreamController` returns a **Server-Sent Events** response. Each `TextDelta` event is echoed as an SSE `data:` payload containing the incremental text, which the Alpine.js `chatStream` client renders as streaming markdown.
4. When streaming completes, the Laravel AI SDK persists the conversation and returns a `conversation_id`, which is sent back and used to hydrate the sidebar and reload chat history.
5. During a turn, the agent can invoke its registered **tools** (`SearchProducts`, `SearchOrders`, `GetCurrentDateTime`) to query the database and answer business questions.

---

## 🧠 The AI Agent

`App\Ai\Agents\ChatAgent` is the main assistant ("LaraChat"):

- Implements `Agent`, `Conversational`, and `HasTools`.
- Uses `RemembersConversations` for persistence and `Promptable` for instructions.
- Limited to `#[MaxSteps(2)]` — at most two model/tool round-trips per turn.

Registered tools can be extended by adding entries to the `tools()` method, e.g. uncommenting the included `ProductAnalyzerAgent` or the commented-out `WebFetch`/`WebSearch` examples.

---

## 🧪 Testing & Quality

```bash
# Run the full CI check (lint + static analysis + tests)
composer test

# Or run each step individually
composer lint              # Laravel Pint (code style)
composer types:check       # PHPStan (static analysis)
php artisan test           # PHPUnit
```

---

## 🛠️ Common Commands

```bash
php artisan migrate        # Run migrations
php artisan migrate:fresh --seed   # Reset DB + reseed sample data
php artisan db:seed        # Re-run all seeders
php artisan tinker         # REPL
php artisan pail           # Live log tail
composer dev               # Run Laravel dev server
npm run build              # Production build of frontend assets
```

---

## 📄 License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT) (see `composer.json`). It is built on the official Laravel Livewire starter kit and the Laravel AI SDK.
