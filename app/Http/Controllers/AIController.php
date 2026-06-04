<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VectorSearchService;
use App\Services\PromptBuilderService;
use App\Services\ChatService;

class AIController extends Controller
{
    /**
     * Controller responsible for AI-related operations such as
     * semantic search and chat-based question answering.
    */
    public function __construct(
        protected VectorSearchService $search,
        protected PromptBuilderService $prompt,
        protected ChatService $chat
    ) { }

    /**
     * Performs a vector-based semantic search over stored documents.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function search(Request $request)
    {
        $question = $request->input('question');

        return response()->json(
            $this->search->search($question)
        );
    }

    /**
     * Handles a full RAG (Retrieval-Augmented Generation) chat flow:
     * 1. Receives a user question
     * 2. Retrieves relevant document chunks via vector search
     * 3. Builds an AI prompt with context
     * 4. Sends the prompt to the chat service for completion
     * 5. Returns both the generated answer and source chunks
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function chat(Request $request){

        $question = $request->input('question');

        $chunks = $this->search->search($question);

        $prompt = $this->prompt->build($question, $chunks);

        $answer = $this->chat->answer($prompt);

        return response()->json([
            'answer' => $answer,
            'sources' => $chunks,
        ]);
    }

}
