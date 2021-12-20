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

    public function updatePdfPath($article_id, $new_path) {
        Db::request("
            UPDATE articles 
            SET pdf_path = ? 
            WHERE id = ?
        ", array($new_path, $article_id));
    }

    public function insertArticle($author_ids, $title, $abstract, $pdf_path) {
        Db::request("
            INSERT INTO articles 
            (name, abstract, pdf_path)
            VALUES
            (?, ?, ?)
        ", array($title, $abstract, $pdf_path));

        $article_id = Db::requestLastInsertId();

        $this->updatePdfPath($article_id, "files/".$article_id.".pdf");

        foreach ($author_ids as $id_author) {
            Db::request("
                INSERT INTO articles_authors
                (id_author, id_article)
                VALUES
                (?, ?)
            ", array(intval($id_author), $article_id));
        }

        return $article_id;
    }

    public function deleteArticle(int $article_id) {
        Db::request("
            DELETE FROM articles
            WHERE id = ?
        ", array($article_id));
    }
}