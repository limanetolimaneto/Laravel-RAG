<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VectorSearchService;
use App\Services\PromptBuilderService;
use App\Services\ChatService;

class AIController extends Controller
{

    public function __construct(
        protected VectorSearchService $search,
        protected PromptBuilderService $prompt,
        protected ChatService $chat
    ) { }

    public function search(Request $request)
    {
        $question = $request->input('question');

        return response()->json(
            $this->search->search($question)
        );
    }

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
