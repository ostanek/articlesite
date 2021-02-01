<?php

use Latte\Runtime as LR;

/** source: D:\xampp\htdocs\articlesite\app\Presenters/templates/@layout.latte */
final class Template74a25777e1 extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['head' => 'blockHead', 'scripts' => 'blockScripts'],
	];


	public function main(): array
	{
		extract($this->params);
		echo '
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>';
		if ($this->hasBlock("title")) {
			$this->renderBlock($ʟ_nm = 'title', [], function ($s, $type) {
				$ʟ_fi = new LR\FilterInfo($type);
				return LR\Filters::convertTo($ʟ_fi, 'html', $this->filters->filterContent('striphtml', $ʟ_fi, $s));
			}) /* line 13 */;
			echo ' | ';
		}
		echo 'Nette Sandbox</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 17 */;
		echo '/css/style.css">
	';
		if ($this->getParentName()) {
			return get_defined_vars();
		}
		$this->renderBlock('head', get_defined_vars());
		echo '
</head>

<body>        
	<div class=container>
                <div class="content">
                        
                        <nav class="navbar navbar-default">
                                <div class="container-fluid">
                                        <div class="navbar-header">
                                                <a class="navbar-brand" href="#">Ondřej Staněk</a>
                                        </div>
                                        <ul class="nav navbar-nav navbar-right">
';
		$iterations = 0;
		foreach ($menuItems as $item => $link) {
			echo '                                                <li';
			echo ($ʟ_tmp = array_filter([$presenter->isLinkCurrent($link) ? 'active' : null])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "";
			echo '>
                                                    <a href="';
			echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link($link));
			echo '">';
			echo LR\Filters::escapeHtmlText($item) /* line 32 */;
			echo '</a>
                                                </li>
';
			$iterations++;
		}
		echo '                                        </ul>
                                </div>
                        </nav>

';
		$iterations = 0;
		foreach ($flashes as $flash) {
			echo '                        <div';
			echo ($ʟ_tmp = array_filter(['alert', 'alert-' . $flash->type])) ? ' class="' . LR\Filters::escapeHtmlAttr(implode(" ", array_unique($ʟ_tmp))) . '"' : "";
			echo '>';
			echo LR\Filters::escapeHtmlText($flash->message) /* line 38 */;
			echo '</div>
';
			$iterations++;
		}
		echo "\n";
		$this->renderBlock($ʟ_nm = 'content', [], 'html') /* line 40 */;
		echo '                </div>
                
                <div class="footer flex-container">
                        <div class="item">
                                <p>Správné</p>
                        </div>
                        <div class="item item-phone-shift-plus-2">
                                <p>telefonu</p>
                        </div>
                        <div class="item item-phone-shift-minus-1">
                                <p>pořadí</p>
                        </div>
                        <div class="item item-phone-shift-minus-1">
                                <p>pouze na</p>
                        </div>
                </div>
	</div>

';
		$this->renderBlock('scripts', get_defined_vars());
		echo '
</body>
</html>
';
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['item' => '30', 'link' => '30', 'flash' => '38'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		$this->createTemplate('components/form.latte', $this->params, "import")->render() /* line 6 */;
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block head} on line 18 */
	public function blockHead(array $ʟ_args): void
	{
		
	}


	/** {block scripts} on line 59 */
	public function blockScripts(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script src="https://nette.github.io/resources/js/3/netteForms.min.js"></script>
        <script src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 62 */;
		echo '/js/nette.ajax.js"></script> 
        <script src="';
		echo LR\Filters::escapeHtmlAttr(LR\Filters::safeUrl($basePath)) /* line 63 */;
		echo '/js/main.js"></script>
';
	}

}
