<?php

namespace App\Services;


/**
 * Service responsible for building prompts for the LLM
 * using retrieved context chunks and the user question.
*/
class PromptBuilderService
{
    /**
     * Build a RAG-style prompt combining context and question.
     *
     * @param string $question User input question
     * @param array $chunks Retrieved document chunks with content
     * @return string Final formatted prompt for the LLM
    */
    public function build(string $question, array $chunks): string
    {
        $context = collect($chunks)
            ->pluck('content')
            ->implode("\n\n---\n\n");

        return "You are a helpful assistant. Use ONLY the context below to answer. CONTEXT: {$context} QUESTION: {$question} Answer clearly and concisely.";
    }
}