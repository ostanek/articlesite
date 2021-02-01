<?php

use Latte\Runtime as LR;

/** source: D:\xampp\htdocs\articlesite\app\Presenters/templates/Page2/default.latte */
final class Templatef12244bf1b extends Latte\Runtime\Template
{
	protected const BLOCKS = [
		['title' => 'blockTitle', 'content' => 'blockContent', 'head' => 'blockHead'],
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
		$this->renderBlock('head', get_defined_vars());
		echo "\n";
		return get_defined_vars();
	}


	public function prepare(): void
	{
		extract($this->params);
		if (!$this->getReferringTemplate() || $this->getReferenceType() === "extends") {
			foreach (array_intersect_key(['articlecategory' => '10', 'article' => '6', 'categoriesarticlescount' => '23', 'category' => '20'], $this->params) as $ʟ_v => $ʟ_l) {
				trigger_error("Variable \$$ʟ_v overwritten in foreach on line $ʟ_l");
			}
		}
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	/** {block title} on line 1 */
	public function blockTitle(array $ʟ_args): void
	{
		echo 'Stránka 2';
	}


	/** {block content} on line 2 */
	public function blockContent(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<div id="content">
        <h2>Poslední články:</h2>
        <table>
';
		$iterations = 0;
		foreach ($articles as $article) {
			echo '                <tr>
                        <td>
                                <h3>';
			echo LR\Filters::escapeHtmlText($article->title) /* line 8 */;
			echo '</h3>
                                <p>Obsah: ';
			echo LR\Filters::escapeHtmlText($article->content) /* line 9 */;
			echo '</p>
                                <div>
';
			$iterations = 0;
			foreach ($articlescategories as $articlecategory) {
				if ($article->article_id === $articlecategory->article_id) {
					echo '                                    <p>Kategorie: ';
					echo LR\Filters::escapeHtmlText($articlecategory->categories) /* line 11 */;
					echo '</p>
';
				}
				$iterations++;
			}
			echo '                                </div>
                        </td>
                </tr>
';
			$iterations++;
		}
		echo '        </table>
        <hr>

        <h2>Počet článků v&nbsp;jednotlivých kategoriích:</h2>
        <table>
';
		$iterations = 0;
		foreach ($categories as $category) {
			echo '                <tr>
                        <td>
                                <h3>Název kategorie: ';
			echo LR\Filters::escapeHtmlText($category->title) /* line 22 */;
			echo '</h3>
                                <div>
';
			$iterations = 0;
			foreach ($categoriesarticlescounts as $categoriesarticlescount) {
				if ($category->category_id === $categoriesarticlescount->category_id) {
					echo '                                    <p>Počet článků v&nbsp;kategorii:&nbsp;';
					echo LR\Filters::escapeHtmlText($categoriesarticlescount->articles_count) /* line 24 */;
					echo '</p>
';
				}
				$iterations++;
			}
			echo '                                </div>
                        </td>
                </tr>
';
			$iterations++;
		}
		echo '        </table>
        <hr>

        <h2>Počet použitých kategorií:</h2>
        <p>';
		echo LR\Filters::escapeHtmlText($usedcategoriescounts) /* line 32 */;
		echo '&nbsp;kategorie</p>
</div>
';
	}


	/** {block head} on line 36 */
	public function blockHead(array $ʟ_args): void
	{
		extract($this->params);
		extract($ʟ_args);
		echo '<style>
	html { overflow-y: scroll; }
	body { font: 14px/1.65 Verdana, "Geneva CE", lucida, sans-serif; background: #3484d2; color: #333; }
	.container { max-width: 940px; }

	h1, h2 { font: normal 150%/1.3 Georgia, "New York CE", utopia, serif; color: #1e5eb6; -webkit-text-stroke: 1px rgba(0,0,0,0); }
        h3 { font: normal 120%/1.3 Georgia, "New York CE", utopia, serif; color: #1e5eb6; -webkit-text-stroke: 1px rgba(0,0,0,0); }

        .navbar { margin: 0; }

	#content { background: white; border: 1px solid #eff4f7; padding: 10px 4%; overflow: hidden; }
</style>
';
	}

}
