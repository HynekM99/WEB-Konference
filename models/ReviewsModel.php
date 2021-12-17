<?php
namespace app\models;

use app\utils\Db;

class ReviewsModel {
    public function getReview(int $review_id) {
        return Db::requestRow("
            SELECT * FROM reviews
            WHERE id = ?
        ", array($review_id));
    }

    public function getUnfinishedReviews(int $reviewer_id) {
        return Db::requestAll("
            SELECT * FROM reviews
            WHERE (id_reviewer = ?)
            AND (overall_score IS NULL
            OR comment IS NULL)
        ", array($reviewer_id));
    }

    public function getFinishedReviews(int $reviewer_id) {
        return Db::requestAll("
            SELECT * FROM reviews
            INNER JOIN articles ON reviews.id_article = articles.id
            WHERE reviews.id_reviewer = ?
            AND reviews.overall_score IS NOT NULL
            AND reviews.comment IS NOT NULL
            AND articles.published IS NULL
        ", array($reviewer_id));
    }

    public function getReviews(int $article_id) {
        return Db::requestAll("
            SELECT reviews.id AS id_review, reviews.*, users.* FROM reviews
            INNER JOIN users ON reviews.id_reviewer = users.id
            WHERE id_article = ?
        ", array($article_id));
    }

    public function getAvailableReviewers($allReviewers, int $article_id) {
        $availableReviewers = [];

        foreach ($allReviewers as $reviewer) {
            $review = Db::requestRow("
                SELECT * FROM reviews
                WHERE id_reviewer = ?
                AND id_article = ?
            ", array($reviewer['id'], $article_id));
            if (!$review) array_push($availableReviewers, $reviewer);
        }

        return $availableReviewers;
    }

    public function setReviewer(int $reviewer_id, int $article_id) {
        Db::request("
            INSERT INTO `reviews` 
            (`id_reviewer`, `id_article`) VALUES
            (?, ?);
        ", array($reviewer_id, $article_id));

        return Db::requestLastInsertId();
    }

    public function setReview(int $reviewer_id, int $article_id, int $contentScore, int $relevanceScore, int $languageScore, int $overallScore, string $comment) {
        return Db::request("
            UPDATE reviews SET content_score = ?, relevance_score = ?, language_score = ?, overall_score = ?, comment = ?
            WHERE id_article = ? AND id_reviewer = ?
        ", array($contentScore, $relevanceScore, $languageScore, $overallScore, $comment, $article_id, $reviewer_id));
    }

    public function deleteReview(int $review_id) {
        return Db::requestRow("
            DELETE FROM reviews
            WHERE id = ?
        ", array($review_id));
    }
}