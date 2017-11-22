<?php

namespace AppBundle\Service;

use AppBundle\Entity\Article;
class ArticleManager
{
    /**
     * @param Article $article
     * @return Article
     */
    public function publish(Article $article) {
        return $article->setPublished(true);
    }
}