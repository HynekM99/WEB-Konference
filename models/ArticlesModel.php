<?php
namespace app\models;

use app\utils\Db;

class ArticlesModel {
    public function getUndecidedArticles() {
        return Db::requestAll("
            SELECT * FROM articles
            WHERE published IS NULL
        ");
    }

    public function getDecidedArticles() {
        return Db::requestAll("
            SELECT * FROM articles
            WHERE published IS NOT NULL
        ");
    }

    public function getPublishedArticles() {
        return Db::requestAll("
            SELECT * FROM articles
            WHERE published = true
        ");
    }

    public function getArticle(int $id) {
        return Db::requestRow("
            SELECT * FROM articles
            WHERE id = ?
        ", array($id));
    }

    public function getUserArticles(int $author_id) {
        return Db::requestAll("
            SELECT articles.*, articles_authors.id_article, articles_authors.id_author FROM articles
            INNER JOIN articles_authors ON articles_authors.id_article = articles.id
            WHERE articles_authors.id_author = ?
        ", array($author_id));
    }

    public function getArticlesAuthors(int $article_id) {
        return Db::requestAll("
            SELECT users.id, users.full_name FROM users
            INNER JOIN articles_authors ON articles_authors.id_author = users.id
            WHERE articles_authors.id_article = ?
        ", array($article_id));
    }

    public function updateArticleStatus(int $article_id, bool $accepted = null) {
        if (isset($accepted)) {
            Db::request("
                UPDATE articles 
                SET published = ? 
                WHERE id = ?
            ", array($accepted, $article_id));
        } else {
            Db::request("
                UPDATE articles 
                SET published = NULL 
                WHERE id = ?
            ", array($article_id));
        }
    }
}