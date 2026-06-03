# Laravel RAG (Retrieval-Augmented Generation) School Assistant

A production-ready Retrieval-Augmented Generation (RAG) system built with Laravel, MySQL, Jina AI, and Groq. This application processes institutional data (PDF and TXT documents) from a simulated High School in Paarl, South Africa, stores their vector embeddings, and uses semantic search to provide accurate, context-aware answers to user queries using Large Language Models (LLMs).

---

## 🚀 Key Features

* **Asynchronous Ingestion Pipeline:** Uses Laravel Queues to parse files (`.txt`, `.pdf`) and generate vector embeddings without blocking the application.
* **Semantic Vector Search:** Implements a pure PHP/MySQL Cosine Similarity algorithm to find the most relevant context for any user query.
* **Context-Driven AI Chat:** Leverages Groq (`llama-3.3-70b-versatile`) and Jina AI (`jina-embeddings-v2-base-en`) to guarantee hallucination-free answers based *only* on provided school files.
* **Clean Architecture:** Fully decoupled components utilizing Interfaces, Factories, Jobs, and dedicated Service layers.

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

## 💻 Tech Stack

Framework: Laravel 11+ 
Database: MySQL
Queue Driver: Database / Redis
Embeddings Provider: Jina AI (jina-embeddings-v2-base-en)
LLM Orchestration: Groq API (llama-3.3-70b-versatile)
Dependencies: smalot/pdfparser (for PDF text extraction)

---

## 💾 Database Infrastructure Notes

The system architecture handles vector search depending on the MySQL environment version:
* **Development (MySQL 8.0.x):** Utilizes optimized SQL `JSON_EXTRACT` mathematical operations to compute dot products directly inside the database engine, avoiding PHP memory bottlenecks (`Embedding::all()` overhead).
* **Production/Upgrade (MySQL 8.4+ LTS):** Migrates the schema to use the native `VECTOR(768)` data type paired with the hardware-accelerated `VECTOR_DISTANCE(..., 'COSINE')` function for enterprise-grade performance.

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

