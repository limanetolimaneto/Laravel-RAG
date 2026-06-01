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

1. **Ingestion (`/ai-db-embedding`):** Scans the `storage/app/rag-data` folder ➡️ Dispatches queued jobs ➡️ Extracts text via specialized parsers ➡️ Segments text into chunks with mathematical overlap ➡️ Requests embeddings from Jina AI ➡️ Persists data into MySQL.
2. **Retrieval & Generation (`/ai-chat`):** Vectorizes the user's question ➡️ Runs Cosine Similarity across the database ➡️ Fetches top 3 matching chunks ➡️ Injects chunks into a system prompt ➡️ Requests a deterministic answer from Groq.

---

## 🛰️ API Endpoints

Method            Endpoint            Description
GET                /ai-db-embedding    Scans directory, triggers parsers, and pushes chunk/embedding jobs to the queue.
GET                /ai-search          Tests similarity. Returns the top 3 text chunks most relevant to the question parameter.
GET                /ai-chat            Full RAG workflow. Takes a question, searches context, and returns the AI-generated answer.

