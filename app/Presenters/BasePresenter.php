<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function beforeRender()
	{
		parent::beforeRender();
		$this->template->menuItems = [
			'Stránka 1' => 'Homepage:',
		 	'Stránka 2' => 'Page2:',
		];
	}
}
