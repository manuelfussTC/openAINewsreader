<?php


class NewsReader
{

    function removeElementsByTagName($tagName, $document)
    {
        $nodeList = $document->getElementsByTagName($tagName);
        for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0;) {
            $node = $nodeList->item($nodeIdx);
            $node->parentNode->removeChild($node);
        }
    }

    function readNewsByUrl($url)
    {
        // Crawl the News Pages

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);


        $doc = new DOMDocument();

        // return false if curl was not able to return content
        if (!$content) {
            return false;
        }

        // Skip pages with a paywall
        if (strpos($content, 'paywall') !== false) {
            return false;
        }
        if (strpos($content, 'barrier-banner') !== false) {
            return false;
        }


        $doc->loadHTML($content);


        // Get rid of not needed content to keep the result slim
        $this->removeElementsByTagName('script', $doc);
        $this->removeElementsByTagName('style', $doc);
        $this->removeElementsByTagName('link', $doc);
        $this->removeElementsByTagName('ul', $doc);
        $this->removeElementsByTagName('section', $doc);
        $this->removeElementsByTagName('img', $doc);
        $this->removeElementsByTagName('svg', $doc);
        $this->removeElementsByTagName('a', $doc);
        $returnHtml = $doc->saveHtml();
        if (strlen($returnHtml) <= 10000) {
            return false;
        }
        return $returnHtml;
    }
}