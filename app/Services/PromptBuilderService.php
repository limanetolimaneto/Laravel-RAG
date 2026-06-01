<?php

namespace App\Services;

class PromptBuilderService
{
    public function build(string $question, array $chunks): string
    {
        $context = collect($chunks)
            ->pluck('content')
            ->implode("\n\n---\n\n");

        return "You are a helpful assistant. Use ONLY the context below to answer. CONTEXT: {$context} QUESTION: {$question} Answer clearly and concisely.";
    }
}