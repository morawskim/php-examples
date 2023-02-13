<?php

namespace App\Controller;

use Aws\Polly\PollyClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AwsPollyController
{
    #[Route("/polly/synthesize-speech", name: 'polly.speech', methods: ['GET'])]
    public function synthesizeSpeech(PollyClient $pollyClient): Response
    {
        $result = $pollyClient->synthesizeSpeech([
            'Engine' => 'neural', // other option is standard
            'LanguageCode' => 'pl-PL',
            'OutputFormat' => 'mp3',
            // https://pl.wikipedia.org/w/index.php?title=Wikipedia&printable=yes
            'Text' => 'Wikipedia – wielojęzyczna encyklopedia internetowa działająca zgodnie z zasadą otwartej treści. Funkcjonuje w oparciu o oprogramowanie MediaWiki (haw. wiki – „szybko”, „prędko”), wywodzące się z koncepcji WikiWikiWeb, umożliwiające edycję każdemu użytkownikowi odwiedzającemu stronę i aktualizację jej treści w czasie rzeczywistym. Słowo Wikipedia jest neologizmem powstałym w wyniku połączenia wyrazów wiki i encyklopedia. Slogan Wikipedii brzmi: „Wolna encyklopedia, którą każdy może redagować”. Serwis był notowany w rankingu Alexa na miejscu 13',
            // https://docs.aws.amazon.com/polly/latest/dg/ntts-voices-main.html
            'VoiceId' => 'Ola',
        ]);

        $voiceContent = $result->get('AudioStream')->getContents();
        return new Response(
            $voiceContent,
            200,
            ['Content-Type' => 'audio/mpeg']
        );
    }
}
