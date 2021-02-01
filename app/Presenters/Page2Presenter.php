<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\ArticleManager;
use App\Model\CategoryManager;

final class Page2Presenter extends BasePresenter
{
        /** @var ArticleManager Model pro správu článků. */
        private $articleManager;

        /** @var CategoryManager Model pro správu kategorií článků. */
        private $categoryManager;

        /**
         * Konstruktor s injektovaným modelem pro správu článků a kategorií.
         * @param ArticleManager $articleManager    automaticky injektovaný model pro správu článků
         * @param ArticleManager $categoryManager    automaticky injektovaný model pro správu kategorií
         */
        public function __construct(ArticleManager $articleManager, CategoryManager $categoryManager)
        {
            parent::__construct();
            $this->articleManager = $articleManager;
            $this->categoryManager = $categoryManager;
        }
    
	public function renderDefault(): void
	{
            $this->renderLastThreeArticlesList();
            $this->renderCategoryList();
	}
        
        /** Načte a předá seznam posledních tří článků a kategorie článků do šablony. */
        public function renderLastThreeArticlesList()
        {
            $this->template->articles = $this->articleManager->getLastThreeArticles();
            $this->template->articlescategories = $this->articleManager->getArticlesCategories($this->template->articles);
        }
        
        /** Načte a předá seznam kategorií, počty článků kategorií a počet použitých kategorií do šablony. */
        public function renderCategoryList()
        {
            $this->template->categories = $this->categoryManager->getCategories();
            $this->template->categoriesarticlescounts = $this->categoryManager->getCategoriesArticlesCounts($this->template->categories);
            $this->template->usedcategoriescounts = $this->categoryManager->getUsedCategoriesCount();
        }
}
