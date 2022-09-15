<?php namespace Xitara\ExtendPages\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Theme;
use Winter\Pages\Classes\Menu as PagesMenu;
use Winter\Pages\Classes\Router;

class DisplayIntro extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'xitara.extendpages::component.displayintro.name',
            'description' => 'xitara.extendpages::component.displayintro.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'code'          => [
                'title'       => 'xitara.extendpages::component.code.title',
                'description' => 'xitara.extendpages::component.code.description',
                'type'        => 'dropdown',
            ],
            'maxChars'      => [
                'title'             => 'xitara.extendpages::component.maxchars.title',
                'description'       => 'xitara.extendpages::component.maxchars.description',
                'default'           => 0,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'xitara.extendpages::component.maxchars.validationMessage',
            ],
            'isHeading'     => [
                'title'       => 'xitara.extendpages::component.isHeading.title',
                'description' => 'xitara.extendpages::component.isHeading.description',
                'type'        => 'checkbox',
                'default'     => true,
            ],
            'isSubHeading'  => [
                'title'       => 'xitara.extendpages::component.isSubHeading.title',
                'description' => 'xitara.extendpages::component.isSubHeading.description',
                'type'        => 'checkbox',
                'default'     => true,
            ],
            'moreLinkTitle' => [
                'title'       => 'xitara.extendpages::component.moreLinkTitle.title',
                'description' => 'xitara.extendpages::component.moreLinkTitle.description',
                'type'        => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $introItems                  = $this->introItems();
        $this->page['name']          = $introItems['name'] ?? null;
        $this->page['items']         = $introItems['items'] ?? null;
        $this->page['maxItems']      = $this->property('maxChars');
        $this->page['isHeading']     = $this->property('isHeading');
        $this->page['isSubHeading']  = $this->property('isSubHeading');
        $this->page['moreLinkTitle'] = $this->property('moreLinkTitle');
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

        $theme    = Theme::getActiveTheme();
        $menu     = PagesMenu::loadCached($theme, $this->property('code'));
        $items    = $menu->generateReferences($this->page);
        $menuName = $menu->name;

        if (class_exists('\\Winter\\Translate\\Classes\\Translator')) {
            $translator = \Winter\Translate\Classes\Translator::instance();
        }

        $router     = new Router($theme);
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

            $intro = $page->intro ?? $page->placeholders['intro'] ?? $page->parsedMarkup;
            if ($intro == '') {
                $intro = $page->parsedMarkup;
            }

            $introItems[str_slug($item->title)] = [
                'title'    => $page->title,
                'filename' => $page->baseFileName,
                'url'      => $item->url,
                'intro'    => $intro,
                // 'intro' => $page->viewBag['intro'] ?? $page->parsedMarkup,
            ];
        }
        // exit;

        return ['name' => $menuName, 'items' => $introItems];
    }
}
