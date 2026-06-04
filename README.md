<!-- #region Title -->

# Laravel AI Knowledge Base (RAG)

This project demonstrates the implementation of a complete Retrieval-Augmented Generation (RAG) pipeline, including document ingestion, text chunking, embedding generation, vector similarity search, asynchronous processing with Laravel Queues, and LLM-powered answer generation.

The application ingests PDF and TXT documents, generates vector embeddings, stores them in a relational database, and performs semantic retrieval to provide context-aware AI responses grounded in the retrieved content.

---

<!-- #endregion -->

<!-- #region Badges -->

![MIT License](https://img.shields.io/badge/license-MIT-green)
![PHP8+](https://img.shields.io/badge/Language-PHP8+-blue?logo=php)
![Laravel 11](https://img.shields.io/badge/backend-Laravel-red?logo=laravel)
![MySQL 8.4](https://img.shields.io/badge/database-MySQL-yellow?logo=mysql)
![RAG](https://img.shields.io/badge/AI-RAG-purple)
![Embeddings](https://img.shields.io/badge/Embeddings-Jina_AI-orange)
![Llama 3.3](https://img.shields.io/badge/Model-Llama_3.3_70B-blue)
![Queues](https://img.shields.io/badge/Architecture-Queues-lightgrey)
![Architecture](https://img.shields.io/badge/Architecture-Clean_Architecture-success)

---

<!-- #endregion -->

<!-- #region TechStack -->

## 💻 Tech Stack

- PHP 8.2+
- Laravel 11
- MySQL 8.x
- Laravel Queues
- Groq (llama-3.3-70b-versatile)
- Jina AI (jina-embeddings-v2-base-en)
- smalot/pdfparser

---

<!-- #endregion -->

<!-- #region KeyFeatures -->

## 🚀 Key Features

* **Asynchronous Ingestion Pipeline:** Uses Laravel Queues to parse files (`.txt`, `.pdf`) and generate vector embeddings without blocking the application.
* **Semantic Vector Search:** Implements a pure PHP/MySQL Cosine Similarity algorithm to find the most relevant context for any user query.
* **Context-Driven AI Chat:** Leverages Groq (`llama-3.3-70b-versatile`) and Jina AI (`jina-embeddings-v2-base-en`) to generate responses grounded in retrieved contextual information, significantly reducing hallucinations.
* **Clean Architecture:** Fully decoupled components utilizing Interfaces, Factories, Jobs, and dedicated Service layers.

---

<!-- #endregion -->

<!-- #region Architecture -->

## 🛠️ Architecture & Workflow

### 1. Ingestion (`/ai-db-embedding`)

- Scans the `storage/app/rag-data` directory
- Dispatches queued jobs
- Extracts text using specialized parsers
- Segments content into overlapping chunks
- Requests embeddings from Jina AI
- Persists chunks and embeddings into MySQL

### 2. Retrieval & Generation (`/ai-chat`)

- Generates an embedding for the user's question
- Executes Cosine Similarity search across stored embeddings
- Retrieves the top 3 most relevant chunks
- Injects the retrieved context into the system prompt
- Requests a grounded response from Groq

---

<!-- #endregion -->

<!-- #region CoreComponent -->

## 📦 Core Component Breakdown

### 1. Document Processing Pipeline

Documents (PDF/TXT) are parsed using a Factory-based architecture that resolves the correct parser based on file type.

This ensures extensibility for future formats without modifying core logic.

### 2. Smart Text Chunking

The ChunkingService uses a sliding-window strategy with overlap to preserve context between segments and improve retrieval quality.

### 3. Embedding Generation

Text chunks are converted into high-dimensional vector embeddings using Jina AI (jina-embeddings-v2-base-en), enabling semantic search over raw text.

### 4. Vector Similarity Search

Similarity = (A · B) / (||A|| × ||B||)

A custom implementation of cosine similarity is used to compare query embeddings against stored vectors in MySQL.

### 5. End-to-End RAG Flow

Document ingestion → Parsing → Chunking → Embedding → Storage → Retrieval → LLM Response

---

<!-- #endregion -->

<!-- #region InstallationSetup -->

## ⚡ Installation & Setup

## ⚡ Installation & Setup

### Prerequisites

- PHP 8.2+
- Composer 2.x
- MySQL 8.x
- Jina AI API Key
- Groq API Key
- Laravel Queue Driver (database or redis)

### 1. Clone the repository

```bash
git clone https://github.com/your-username/laravel-rag.git
cd laravel-rag
```

### 2. Install dependencies

```php
composer install
```

### 3. Configure environment variables

Copy the example file:

```bash
cp .env.example .env
```

Then configure:

```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rag
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database

JINA_API_KEY=your_jina_ai_key_here
GROQ_API_KEY=your_groq_api_key_here
```

### 4. Generate application key

```php
php artisan key:generate
```

### 5. Run database migrations

```php
php artisan migrate
```

### 7. Start queue worker

php artisan queue:work

### 8. Start the application

php artisan serve



---

<!-- #endregion -->

<!-- #region UsageExamples -->


---
<!-- #endregion -->

aa
## 🚀 Features
## 📦 Installation
## 🛠️ Development
## 📖 Documentation
## 🧪 Testing
## 🤝 Contributing

## 💻 Tech Stack
## 🚀 Key Features

## 🛰️ API Endpoints
## 💾 Database Infrastructure & Scale Notes
## 📦 Core Component Breakdown
## ⚡ Installation & Setup
## 🔍 Usage Examples

## 📊 Database Infrastructure & Scaling


Tech Stack
Key Features
Architecture & Workflow
Core Component Breakdown
Database Infrastructure & Scaling
API Endpoints
Installation & Setup
Usage Examples





## Design Decisions 
    ### Why Laravel?

    To demonstrate that modern AI systems can be
    implemented using traditional web frameworks.

    ### Why MySQL Instead of Pinecone?

    To avoid external infrastructure and keep the
    project self-contained.

    ### Why Queue Processing?

    Embedding generation is the most expensive
    operation and should not block HTTP requests.
### 

---

## TXT/PDF
    │
    ▼
    Parser
    │
    ▼
    Chunking
    │
    ▼
    Jina AI
    │
    ▼
    MySQL
    │
    ▼
    Similarity Search
    │
    ▼
    Groq
    │
    ▼
    Response

---

## 🛠️ Architecture & Workflow

1. **Ingestion (`/ai-db-embedding`):** 
➡️ Scans the `storage/app/rag-data` folder
➡️ Dispatches queued jobs 
➡️ Extracts text via specialized parsers 
➡️ Segments text into chunks with mathematical overlap 
➡️ Requests embeddings from Jina AI 
➡️ Persists data into MySQL.
2. **Retrieval & Generation (`/ai-chat`):** 
➡️ Vectorizes the user's question 
➡️ Runs Cosine Similarity across the database 
➡️ Fetches top 3 matching chunks 
➡️ Injects chunks into a system prompt 
➡️ Requests a deterministic answer from Groq.

---

## 🛰️ API Endpoints

Method            Endpoint            Description
GET                /ai-db-embedding    Scans directory, triggers parsers, and pushes chunk/embedding jobs to the queue.
GET                /ai-search          Tests similarity. Returns the top 3 text chunks most relevant to the question parameter.
GET                /ai-chat            Full RAG workflow. Takes a question, searches context, and returns the AI-generated answer.

---



## 💾 Database Infrastructure & Scale Notes

The current database schema implements the `embedding` column as a standard `JSON` data type. This guarantees absolute compatibility across development environments running MySQL 8.x, PostgreSQL, or SQLite (for testing purposes).

### 🚀 Production & Enterprise Scaling (MySQL 9.0+)

For production systems or high-traffic enterprise environments, it is highly recommended to upgrade to **MySQL 9.0+** to leverage native vector architecture:

1. **Schema Migration:** Change the `embedding` column type from `JSON` to the native `VECTOR(768)`:
   ```sql
   ALTER TABLE embeddings MODIFY COLUMN embedding VECTOR(768) NOT NULL;
   ```

2. **Hardware-Accelerated Vector Search:** Instead of decoding JSON strings and performing math via PHP loops or complex `JSON_EXTRACT` operations, you can rewrite the semantic search query using the hardware-accelerated `VECTOR_DISTANCE()` function directly in the database engine:
   ```sql
   SELECT id, content, VECTOR_DISTANCE(embedding, :query_vector, 'COSINE') AS distance 
   FROM embeddings 
   ORDER BY distance ASC 
   LIMIT 3;
   ```

This approach shifts the mathematical workload to the database level, drastically reducing memory overhead and query latency under heavy loads.


---

## 📦 Core Component Breakdown

1. Extensible Document Parsing
Uses a Factory Pattern (DocumentFactoryInterface) to dynamically resolve the correct parser based on file extensions, making it straightforward to add supports like .docx or .csv in the future.

2. Smart Text Chunking
The ChunkingService implements a sliding window strategy to prevent information loss between chunks:
```php
// Chunks text into 100-character segments with a 20-character overlapping window
$chunk->chunk($parsedText, chunkSize: 100, overlap: 20);
```

3. In-Memory Mathematical Vector Search
Calculates the spatial distance between the query vector and your database content using a native Cosine Similarity formula:
\(\text{Similarity}=\frac{A\cdot B}{\|A\|\|B\|}\)

```php
private function cosineSimilarity(array $a, array $b): float
{
    $dotProduct = 0; $normA = 0; $normB = 0;
    foreach ($a as $index => $value) {
        $dotProduct += $value * $b[$index];
        $normA += $value ** 2;
        $normB += $b[$index] ** 2;
    }
    return $dotProduct / (sqrt($normA) * sqrt($normB));
}
```

---

## ⚡ Installation & Setup

Prerequisites
PHP 8.2+
Composer
MySQL Database
Jina AI API Key
Groq API Key

Step-by-Step Setup

1. Clone the repository:
```bash
git clone https://github.com
cd laravel-rag-school
```

2. Install dependencies:
```bash
composer install
```
3. Configure Environment Variables (.env):

```ENV
envDB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_rag
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database

JINA_API_KEY=your_jina_ai_key_here
GROQ_API_KEY=your_groq_key_here
```

4. Run migrations:
```bash
php artisan migrate
```

5. Place your source files:
Put your .txt and .pdf school data files directly into the following directory:
storage/app/rag-data/

6. Start the queue worker:
```bash
php artisan queue:work
```

7. Run the local server:
```bash
php artisan serve
```

---







## 🔍 Usage Examples

1. Ingest Data:
```bash
curl http://127.0.0
```

Response
```json
{
  "message": "Jobs dispatched successfully"
}

```

3. Ask a Question (Full RAG Workflow)
```bash
curl http://127.0.0
```
Response
```json
{
  "message": "response"
}
```


## Screenshots

### Ingestion Process

[imagem]

### Semantic Search

[imagem]

### AI Chat Response

[imagem]


## Performance

Dataset:
- 150 documents
- 1,200 chunks
- 768-dimensional embeddings

Average Retrieval Time:
- PHP Cosine Search: 80ms

Future Optimization:
- MySQL VECTOR indexes
- Approximate Nearest Neighbor search




aaaa


