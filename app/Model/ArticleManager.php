<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\DatabaseManager;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Utils\ArrayHash;
use Nette\Utils\ArrayList;
use Nette\Utils\Strings;

/**
 * Model pro správu článků.
 * @package App\Model
 */
class ArticleManager extends DatabaseManager
{
    /** Konstanty pro práci s databází. */
    const
        TABLE_NAME = 'article',
        ARTICLE_ID = 'article_id',
        CATEGORY_TABLE_NAME = 'category',
        CATEGORY_ID = 'category_id',
        ARTICLE_CATEGORY_TABLE_NAME = 'articlecategory';

    /**
     * Vrátí seznam všech článků v databázi seřazený sestupně od naposledy přidaného.
     * @return Selection seznam všech článků
     */
    public function getArticles()
    {
        $articles = $this->database->table(self::TABLE_NAME)->order(self::ARTICLE_ID . ' DESC');
        $articleArray = $articles->fetchAll();
        foreach ($articleArray as $article)
        {
            $articleArray['categories'] = $this->getTitlesArticleCategoriesStr($article['article_id']);
        }
        return $articleArray;
    }
    
    /**
     * Vrátí seznam posledních tří článků v databázi seřazený sestupně od naposledy přidaného.
     * @return Selection seznam posledních tří článků
     */
    public function getLastThreeArticles()
    {
        return $this->database->table(self::TABLE_NAME)->order(self::ARTICLE_ID . ' DESC')->limit(3);
    }
    
    /**
     * Vrátí kategorie článku z databáze podle jeho id.
     * @param int $id id článku
     * @return false|array seznam kategorií článku
     */
    public function getArticleCategories($id)
    {
        return $this->database->fetchAll(
                 "SELECT `title` FROM `category`, `articlecategory` "
                 . "WHERE `category`.`category_id` = `articlecategory`.`category_id` AND "
                 . "`articlecategory`.`article_id` = ?", $id);
    }
    
    /**
     * Vrátí řetězec názvů kategorií článku z databáze podle jeho id.
     * @param int $id id článku
     * @return false|string řetězec názvů kategorií článku oddělených čárkou a mezerou
     */
    public function getTitlesArticleCategoriesStr($id)
    {
        $categoriesTitlesStr = "";
        foreach ($this->getArticleCategories($id) as $categoryTitle)
        {
            $categoriesTitlesStr = $categoriesTitlesStr . $categoryTitle['title'] . ", ";
        }
        if (Strings::endsWith($categoriesTitlesStr, ", "))
        {
            $categoriesTitlesStr = Strings::substring($categoriesTitlesStr, 0, Strings::length($categoriesTitlesStr) - 2);
        }
        return $categoriesTitlesStr;
    }
    
    /**
     * Vrátí kategorie článků.
     * @param int $articles články
     * @return false| seznam dvojic "id článku a jeho kategorie"
     */
    public function getArticlesCategories($articles)
    {
        $articlesCategories = new ArrayList;
        foreach ($articles as $article)
        {
            $articleCategory = new ArrayHash;
            $articleCategory["article_id"] = $article->article_id;
            $articleCategory["categories"] = $this->getTitlesArticleCategoriesStr($article->article_id);
            $articlesCategories[] = $articleCategory;
        }
        return $articlesCategories;
    }
    
    /**
     * Vrátí článek z databáze podle jeho id.
     * @param int $id id článku
     * @return false|ActiveRow první článek, který odpovídá id nebo false pokud článek s daným id neexistuje
     */
    public function getArticle($id)
    {
        return $this->database->table(self::TABLE_NAME)->where(self::ARTICLE_ID, $id)->fetch();
    }

    /**
     * Uloží článek do systému.
     * Pokud není nastaveno ID vloží nový článek, jinak provede editaci článku s daným ID.
     * @param array|ArrayHash $article článek
     */
    public function saveArticle(ArrayHash $article)
    {
        if (empty($article[self::ARTICLE_ID]))
        {
            unset($article[self::ARTICLE_ID]);
            return $this->database->table(self::TABLE_NAME)->insert($article);
        }
        else
        {
            return $this->database->table(self::TABLE_NAME)->where(self::ARTICLE_ID, $article[self::ARTICLE_ID])->update($article);
        }
    }

    /**
     * Odstraní článek s daným id.
     * @param int $id id článku
     */
    public function removeArticle(int $id)
    {
        $this->database->table(self::TABLE_NAME)->where(self::ARTICLE_ID, $id)->delete();
    }
}