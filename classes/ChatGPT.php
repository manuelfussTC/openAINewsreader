<?php

require __DIR__ . '/../vendor/autoload.php';

use Orhanerday\OpenAi\OpenAi;

class ChatGPT
{

    function summarizeArticles($article, $topic)
    {
        //YOUR OpenAI API KEY HERE
        $open_ai = new OpenAi('YOUR OpenAI API KEY HERE. You get it here after login: https://platform.openai.com/account/api-keys');

        $article = substr($article, 0, 2000);


        // Prompt to get short summaries with highlighted topics and key words at the end. Result is in german
        $prompt = $article . ' summarize this text with max 400 characters. Add red html styling color to the single words that are most important in the text. Do not color the whole text in red! Add an html-formatted list at the end with a maximum of 5 keywords that best describe the text. Write it in German';

        // GPT-3 Prompt Params
        $complete = $open_ai->completion([
            'model' => 'text-davinci-003',
            'prompt' => $prompt,
            'temperature' => 0,
            'max_tokens' => 400,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);

        $onlyText = json_decode($complete)->choices[0]->text;

        return $onlyText;
    }
}