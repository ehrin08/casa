<?php

namespace App\Services;

class SentimentAnalysisService
{
    /**
     * Analyze sentiment based on rating and comment keywords.
     *
     * @param int $rating
     * @param string $comment
     * @return array
     */
    public function analyze(int $rating, string $comment): array
    {
        $score = $this->calculateRatingScore($rating);
        $score += $this->calculateKeywordScore($comment);

        $sentiment = $score >= 0 ? 'positive' : 'negative';
        $keySnippet = $this->extractKeySnippet($comment);

        return [
            'sentiment' => $sentiment,
            'sentiment_score' => $score,
            'key_snippet' => $keySnippet,
        ];
    }

    /**
     * Calculate base score from rating.
     */
    private function calculateRatingScore(int $rating): float
    {
        return match ($rating) {
            5 => 2.0,
            4 => 1.0,
            3 => 0.0,
            2 => -1.0,
            1 => -2.0,
            default => 0.0,
        };
    }

    /**
     * Calculate score based on predefined positive/negative keywords.
     */
    private function calculateKeywordScore(string $comment): float
    {
        $score = 0.0;
        $comment = strtolower($comment);

        $positiveKeywords = [
            'relaxing', 'clean', 'friendly', 'professional', 'excellent',
            'satisfied', 'recommended', 'worth it', 'comfortable', 'amazing',
            'good', 'great', 'smooth', 'helpful', 'perfect', 'best'
        ];

        $negativeKeywords = [
            'late', 'delayed', 'dirty', 'rude', 'painful', 'uncomfortable',
            'expensive', 'disappointed', 'bad', 'poor', 'not satisfied',
            'rushed', 'noisy', 'waiting', 'issue', 'worst', 'terrible'
        ];

        foreach ($positiveKeywords as $word) {
            if (str_contains($comment, $word)) {
                $score += 1.0;
            }
        }

        foreach ($negativeKeywords as $word) {
            if (str_contains($comment, $word)) {
                $score -= 1.0;
            }
        }

        return $score;
    }

    /**
     * Extract a short, meaningful snippet from the comment.
     */
    private function extractKeySnippet(string $comment): string
    {
        if (empty(trim($comment))) {
            return '';
        }

        // Try to split by sentence terminators
        $sentences = preg_split('/(?<=[.?!])\s+(?=[a-z])/i', $comment);
        
        $snippet = trim($sentences[0]);

        // Truncate to 150 chars if too long
        if (strlen($snippet) > 150) {
            $snippet = substr($snippet, 0, 147) . '...';
        }

        return $snippet;
    }
}
