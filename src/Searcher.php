<?php

namespace PSobucki\CourseSearcher;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Searcher
{
    public function __construct(
        private ClientInterface $httpClient,
        private Crawler $crawler
    ) {
    }

    public function search(string $url): array
    {
        $response = $this->httpClient->request('GET', $url);

        $html = $response->getBody();
        $this->crawler->addHtmlContent($html);

        $courseElements = $this->crawler->filter('span.card-curso__nome');
        $courses = [];

        foreach ($courseElements as $element) {
            $courses[] = $element->textContent;
        }

        return $courses;
    }
}
