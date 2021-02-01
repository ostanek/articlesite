<?php

use Latte\Runtime as LR;

/** source: D:\xampp\htdocs\articlesite\app\Presenters/templates/Homepage/default.latte */
final class Template5be9a0f71f extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		0 => ['title' => 'blockTitle', 'content' => 'blockContent', 'scripts' => 'blockScripts', 'head' => 'blockHead'],
		'snippet' => ['form' => 'blockForm'],
	];


	public function main(): array
	{
		extract($this->params);
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('title', get_defined_vars());
		echo "\n";
		$this->renderBlock('content', get_defined_vars());
		echo '

';
		$this->renderBlock('scripts', get_defined_vars());
		echo '

';
		$this->renderBlock('head', get_defined_vars());
		echo "\n";
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block title} on line 1 */
	public function blockTitle(array $ʟ_args): void
	{
		echo 'Stránka 1';
	}


	/** {block content} on line 2 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<div id="content">
        <div class="main">
                
                <div id="';
		echo htmlspecialchars($this->global->snippetDriver->getHtmlId('form'));
		echo '">';
		$this->renderBlock('form', [], null, 'snippet');
		echo '</div>
                <div class="img-container">
                        
                        <picture>
                                <img src="/images/winter-min.jpg" alt="Winter">
                        </picture>
                </div>
        </div>
</div>
';
	}


	/** {block scripts} on line 24 */
	public function blockScripts(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		$this->renderBlockParent($ʟ_nm = 'scripts', get_defined_vars()) /* line 25 */;
		
	}


	/** {block head} on line 28 */
	public function blockHead(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<style>
	html { overflow-y: scroll; }
	body { font: 14px/1.65 Verdana, "Geneva CE", lucida, sans-serif; background: #3484d2; color: #333; }
	.container { max-width: 940px; }

	h1, h2 { font: normal 150%/1.3 Georgia, "New York CE", utopia, serif; color: #1e5eb6; -webkit-text-stroke: 1px rgba(0,0,0,0); }
        label { font: normal 120%/1.3 Georgia, "New York CE", utopia, serif; color: #1e5eb6; -webkit-text-stroke: 1px rgba(0,0,0,0); }
        
	img { border: none; }

        .navbar { text-align: right; margin: 0; }
        
        @media (min-width: 600px) {
                .main {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        grid-template-rows: 1fr;
                        grid-template-areas: none;
                }
        }

        .img-container { min-height: 100%; display: flex; flex-direction: column; }
        .img-container img { width: 100%; height: 100%; object-fit: cover; flex: 1 1 auto; }
        
        #snippet--form { display: grid; justify-content: center; align-content: center; }
</style>
';
	}


	/** {snippet form} on line 6 */
	public function blockForm(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		$this->global->snippetDriver->enter("form", 'static');
		try {
			echo '                <div class="main-form">
                        
';
			/* line 10 */ $_tmp = $this->global->uiControl->getComponent("editorForm");
			if ($_tmp instanceof Nette\Application\UI\Renderable) $_tmp->redrawControl(null, false);
			$_tmp->render();
			echo '                </div>
';
		}
		finally {
			$this->global->snippetDriver->leave();
		}
		
	}

}
