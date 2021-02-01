<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\ArticleManager;
use App\Model\CategoryManager;
use App\Presenters\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Utils\ArrayHash;

/**
 * Presenter pro vykreslování článků.
 * @package App\Presenters
 */
class HomepagePresenter extends BasePresenter
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

    public function renderDefault()
    {
    }

    /** Načte a předá seznamy článků a kategorií do šablony. */
    public function renderList()
    {
        $this->template->articles = $this->articleManager->getArticles();
        $this->template->categories = $this->categoryManager->getCategories();
    }

    /**
     * Vykresluje formulář pro editaci článku podle zadaného id.
     * Pokud id není zadáno, nebo článek s daným id neexistuje, vytvoří se nový.
     * @param int|null $id id článku
     */
    public function actionEditor(int $id = null)
    {
        if ($id)
        {
            if (!($article = $this->articleManager->getArticle($id)))
            {
               $this->flashMessage('Článek nebyl nalezen.'); // Výpis chybové hlášky.
            }
            else
            {    
                $this['editorForm']->setDefaults($article); // Předání hodnot článku do editačního formuláře.
            }
        }
    }

    /**
     * Vytváří a vrací formulář pro editaci článků.
     * @return Form formulář pro editaci článků
     */
    protected function createComponentEditorForm()
    {
        // Vytvoření formuláře a definice jeho polí.
        $form = new Form;
        $form->addHidden('article_id');
        $form->addText('title', 'Titulek')->setRequired();
        $form->addTextArea('content', 'Obsah');
        $form->addHidden('date');
        $form->addTextArea('categories', 'Kategorie');
        $form->addSubmit('save', 'Uložit článek');
        $form->setHtmlAttribute('class', 'ajax');
        
        // Funkce se vykonaná při úspěšném odeslání formuláře a zpracuje zadané hodnoty.
        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            try {
                // vyplnění datumu
                $values['date'] = date("d.m.Y");
                
                // kategorie ukládáme zvlášť
                $categories = $values['categories'];
                unset($values['categories']);
                
                // uložení článku
                $article = $this->articleManager->saveArticle($values);
                
                // id článku
                $articleId = $article['article_id'];
                //$this->flashMessage('Článek byl úspěšně uložen.');
                
                // uložení kategorií a přiřazení kategoií k článku
                $this->categoryManager->saveCategories($articleId, $categories);
                
            } catch (UniqueConstraintViolationException $e) {
                $this->flashMessage('Článek s tímto id již existuje.');
            }
        };
        
        $form->onSuccess[] = [$this, 'processEditorForm'];

        return $form;
    }
    
    /**
     * Vymaže vložené hodnoty editačního formuláře a překreslí (pouze) formulář
     * @param Form
     */
    public function processEditorForm(Form $form)
    {
        $form->setValues([], TRUE);
        $this->redrawControl('form');
    }
}

/* během vytváření bylo částečně čerpáno z kurzu uvedeného na http://www.itnetwork.cz */
