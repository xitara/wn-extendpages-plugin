<?php namespace Xitara\ExtendPages\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Theme;
use RainLab\Pages\Classes\Menu as PagesMenu;
use RainLab\Pages\Classes\Router;

class DisplayIntro extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'xitara.extendpages::component.displayintro.name',
            'description' => 'xitara.extendpages::component.displayintro.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'code' => [
                'title' => 'xitara.extendpages::component.code.title',
                'description' => 'xitara.extendpages::component.code.description',
                'type' => 'dropdown',
            ],
            'maxChars' => [
                'title' => 'xitara.extendpages::component.maxchars.title',
                'description' => 'xitara.extendpages::component.maxchars.description',
                'default' => 0,
                'type' => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'xitara.extendpages::component.maxchars.validationMessage',
            ],
        ];
    }

    public function onRender()
    {
        $introItems = $this->introItems();
        $this->page['introName'] = $introItems['name'];
        $this->page['introItems'] = $introItems['items'];
        $this->page['introMaxItems'] = $this->property('maxChars');
    }

    public function getCodeOptions()
    {
        $result = [];

        $theme = Theme::getEditTheme();
        $menus = PagesMenu::listInTheme($theme, true);

        foreach ($menus as $menu) {
            $result[$menu->code] = $menu->name;
        }

        return $result;
    }

    /**
     * gets placeholder "intro" from subpages and display them
     *
     * @return array menu-name and list with intro-texts
     */
    public function introItems()
    {
        if (!strlen($this->property('code'))) {
            return;
        }

        $theme = Theme::getActiveTheme();
        $menu = PagesMenu::loadCached($theme, $this->property('code'));
        $items = $menu->generateReferences($this->page);
        $menuName = $menu->name;

        if (class_exists('\\RainLab\\Translate\\Classes\\Translator')) {
            $translator = \RainLab\Translate\Classes\Translator::instance();
        }

        $router = new Router($theme);
        $introItems = [];
        foreach ($items as $item) {
            if (!strlen($item->url)) {
                $url = '/';
            } else {
                $url = $item->url;
            }

            if (isset($translator)) {
                $url = parse_url($item->url, PHP_URL_PATH);
                $url = preg_replace('#^/' . $translator->getLocale() . '/#', '/', $url);
                $url = preg_replace('#^/' . $translator->getDefaultLocale() . '/#', '/', $url);
            }

            $page = $router->findByUrl($url);

            if ($page === null) {
                continue;
            }

            $intro = $page->placeholders['intro'] ?? $page->parsedMarkup;
            if ($intro == '') {
                $intro = $page->parsedMarkup;
            }

            $introItems[str_slug($item->title)] = [
                'title' => $page->title,
                'url' => $item->url,
                'intro' => $intro,
                // 'intro' => $page->viewBag['intro'] ?? $page->parsedMarkup,
            ];
        }
        // exit;

        return ['name' => $menuName, 'items' => $introItems];
    }
}
