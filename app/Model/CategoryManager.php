<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\DatabaseManager;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Utils\Strings;
use Nette\Utils\ArrayHash;
use Nette\Utils\ArrayList;

/**
 * Model pro správu kategorií článků.
 * @package App\Model
 */
class CategoryManager extends DatabaseManager
{
    /** Konstanty pro práci s databází. */
    const
        TABLE_NAME = 'category',
        CATEGORY_ID = 'category_id',
        CATEGORY_TITLE = 'title',
        ARTICLE_CATEGORY_TABLE_NAME = 'articlecategory',
        ARTICLE_CATEGORY_ID = 'articlecategory_id',
        ARTICLE_ID = 'article_id';

    /**
     * Vrátí seznam všech kategorií článků v databázi.
     * @return Selection seznam všech kategorií článků
     */
    public function getCategories()
    {
        return $this->database->table(self::TABLE_NAME)->order(self::CATEGORY_ID);
    }

    /**
     * Vrátí kategorii článku z databáze podle jejího názvu.
     * @param int $title název kategorie článku
     * @return false|ActiveRow první kategorie článku, která odpovídá id nebo false pokud kategorie s daným id neexistuje
     */
    public function getCategoryByTitle($title)
    {
        return $this->database->table(self::TABLE_NAME)->where(self::CATEGORY_TITLE, $title)->fetch();
    }
    
    /**
     * Vrátí počet článků kategorie z databáze podle jejího id.
     * @param int $id id kategorie
     * @return false|array počet článků kategorie
     */
    public function getArticleCountForCategory($id)
    {
        return $this->database->fetchAll(
                 "SELECT count(`article_id`) FROM `category`, `articlecategory` "
                 . "WHERE `category`.`category_id` = ? AND "
                 . "`articlecategory`.`category_id` = `category`.`category_id`", $id);
    }
    
    /**
     * Vrátí seznam dvojic "id kategorie článků a počet článků v kategorii".
     * @return array seznam dvojic "id kategorie článků a počet článků v kategorii"
     */
    public function getCategoriesArticlesCounts($categories)
    {
        $categoriesArticlesCounts = new ArrayList;
        foreach ($categories as $category)
        {
            $categoriesArticlesCount = new ArrayHash;
            $categoriesArticlesCount["category_id"] = $category->category_id;
            foreach ($this->getArticleCountForCategory($category->category_id) as $count) {
                    $categoriesArticlesCount["articles_count"] = $count[0];
            }
            $categoriesArticlesCounts[] = $categoriesArticlesCount;
        }
        return $categoriesArticlesCounts;
    }
    
    /**
     * Vrátí počet počet použitých kategorií.
     * @return false|int počet článků kategorie
     */
    public function getUsedCategoriesCount()
    {
        $countRows = $this->database->fetchAll(
                       "SELECT DISTINCT(`category`.`category_id`) "
                         . "FROM `category`, `articlecategory` "
                         . "WHERE `articlecategory`.`category_id` = `category`.`category_id`");
        
        $count = 0;
        foreach ($countRows as $countRow)
        {
            $count = $countRow[0];
        }
        
        return $count;
    }

    /**
     * Uloží kategorie do systému.
     * Pokud není nastaveno ID vloží novou kategorii, jinak provede editaci kategorie s daným ID.
     * @param string $categories kategorie
     */
    public function saveCategories(int $articleId, string $categories)
    {
        $array = Strings::split($categories, '~,\s*~');
        foreach($array as $categoryTitle) {
                
                // Existuje kategorie?
                $categoryId = $this->database->table(self::TABLE_NAME)->where(self::CATEGORY_TITLE, $categoryTitle)->fetch();
                if ($categoryId === null)
                {
                    // Pokud ne, vytvoří se nová.
                    $category = new \Nette\Utils\ArrayHash;
                    $category[self::CATEGORY_ID] = null;
                    $category[self::CATEGORY_TITLE] = $categoryTitle;
                    $categoryId = $this->database->table(self::TABLE_NAME)->insert($category);
                }
                
                // Existuje pro článek tato kategorie?
                if ($this->database->table(self::ARTICLE_CATEGORY_TABLE_NAME)->where(self::ARTICLE_ID, $articleId)->where(self::CATEGORY_ID, $categoryId)->fetch() === null)
                {
                    // Pokud ne, článek se ke kategorii přiřadí.
                    $articleCategory = new \Nette\Utils\ArrayHash;
                    $articleCategory[self::ARTICLE_CATEGORY_ID] = null;
                    $articleCategory[self::ARTICLE_ID] = $articleId;
                    $articleCategory[self::CATEGORY_ID] = $categoryId; 
                    $this->database->table(self::ARTICLE_CATEGORY_TABLE_NAME)->insert($articleCategory);
                }
        }
    }

    /**
     * Odstraní kategorii článku s daným id.
     * @param int $id id kategorie článku
     */
    public function removeCategory(int $id)
    {
        $this->database->table(self::TABLE_NAME)->where(self::CATEGORY_ID, $id)->delete();
    }
}