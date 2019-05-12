<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Spatie\Menu\Laravel\Menu;

class Base
{
    private $menu;

    /**
     * Create a controller instance.
     */
    public function __construct()
    {
        $this->menu = config('menu');
    }

    /**
     * Return the HTML for the bread crumbs.
     *
     * @return Menu
     */
    public function breadCrumbs()
    {
        $menu = Menu::new()
            ->addClass('m-subheader__breadcrumbs m-nav m-nav--inline')
            ->add(
                Link::toRoute('home', '<i class="m-nav__link-icon la la-home"></i>')
                    ->addClass('m-nav__link m-nav__link--icon')
                    ->addParentClass('m-nav__item m-nav__item--home')
            )
        ;

        foreach ($this->crumbs($this->sections()) as $item) {
            $menu
                ->add(
                    Html::raw('>')
                        ->addParentClass('m-nav__separator')
                )
                ->add(
                    Link::to($item['link'], '<span class="m-nav__link-text">'. $item['text'] . '</span>')
                        ->addClass('m-nav__link')
                        ->addParentClass('m-nav__item')
                )
            ;
        }

        return $menu;
    }

    /**
     * Return an array with the bread crumbs.
     *
     * @param array $options
     * @return array
     */
    private function crumbs(array $options)
    {
        foreach ($options as $option) {
            if (!isset($option['section'])) {
                if (!isset($option['submenu'])) {
                    $route = isset($option['route']) ? $option['route'] : $option['crud'] . '.index';
                    if (Route::currentRouteName() == $route) {
                        if ($route !== 'home') {
                            return [
                                [
                                    'link' => \route($route),
                                    'text' => __('app.titles.' . $option['crud']),
                                ]
                            ];
                        }
                    }
                } else {
                    $items = $this->crumbs($option['submenu']);

                    if (!empty($items)) {
                        array_unshift($items, [
                            'link' => '',
                            'text' => __('app.titles.' . $option['name']),
                        ]);

                        return $items;
                    }
                }
            }
        }

        return [];
    }

    /**
     * Return the HTML for the submenus.
     *
     * @param array $options
     * @return Menu
     */
    private function items(array $options)
    {
        return Menu::build($options['submenu'], function ($menu, $option) {
            if (!isset($option['submenu'])) {
                $menu->route(isset($option['route']) ? $option['route'] : $option['crud'] . '.index',
                    '<i class="m-menu__link-bullet m-menu__link-bullet--dot">' .
                    '<span></span>' .
                    '</i>' .
                    '<span class="m-menu__link-text">' . __('app.titles.' . $option['crud']) . '</span>'
                );
            } else {
                $menu->add(
                    Link::to('#',
                        '<i class="m-menu__link-bullet m-menu__link-bullet--dot">' .
                        '<span></span>' .
                        '</i>' .
                        '<span class="m-menu__link-text">' . __('app.titles.' . $option['name']) . '</span>' .
                        '<i class="m-menu__ver-arrow la la-angle-right"></i>'
                    )
                        ->addParentClass('m-menu__item m-menu__item--submenu')
                        ->addClass('m-menu__link m-menu__toggle')
                        ->append($this->items($option))
                        ->setParentAttributes(['aria-haspopup' =>'true', 'm-menu-submenu-toggle' => 'hover'])
                );
            }
        })
            ->setActive(url()->current())
            ->addClass('m-menu__subnav')
            ->append('</div>')
            ->each(function (Link $link) {
                $link->addClass('m-menu__link')
                    ->addParentClass('m-menu__item')
                    ->setParentAttribute('aria-haspopup', 'true')
                ;
            })
            ->prepend(
                '<div class="m-menu__submenu">' .
                '<span class="m-menu__arrow"></span>'
            )
            ->setActiveClass('m-menu__item--active')
            ;
    }

    /**
     * Return the HTML for the custom massive.
     *
     * @param array $options
     * @return Menu
     */
    public function massive(array $options)
    {
        return Menu::build($options, function ($menu, $option) {
            $menu->add(
                Link::to('#',
                    '<i class="m-nav__link-icon ' . $option['icon'] . '"></i>' .
                    '<span class="m-nav__link-text">' . $option['text'] . '</span>'
                )
                    ->addClass('m-nav__link')
                    ->addParentClass('m-nav__item')
                    ->setAttribute('onclick', 'openMassive(active, 1)')
            );
        })
            ->addClass('m-nav')
            ;
    }

    /**
     * Return the HTML for the menu.
     *
     * @return Menu
     */
    public function menu()
    {
        return Menu::build($this->sections(), function ($menu, $option) {
            if (isset($option['section'])) {
                $menu->html(
                    '<li class="m-menu__section ">' .
                    '<h4 class="m-menu__section-text">' . __('app.roles.' . $option['section']) . '</h4>' .
                    '<i class="m-menu__section-icon flaticon-more-v2"></i>' .
                    '</li>'
                );
            } else {
                if (!isset($option['submenu'])) {
                    $menu->route(isset($option['route']) ? $option['route'] : $option['crud'] . '.index',
                        '<i class="m-menu__link-icon ' . $option['icon'] . '"></i>' .
                        '<span class="m-menu__link-title">' .
                        '<span class="m-menu__link-wrap">' .
                        '<span class="m-menu__link-text">' . __('app.titles.' . $option['crud']) . '</span>' .
                        '</span>' .
                        '</span>'
                    );
                } else {
                    $menu->add(
                        Link::to('#',
                            '<i class="m-menu__link-icon ' . $option['icon'] . '"></i>' .
                            '<span class="m-menu__link-text">' . __('app.titles.' . $option['name']) . '</span>' .
                            '<i class="m-menu__ver-arrow la la-angle-right"></i>'

                        )
                            ->addParentClass('m-menu__item m-menu__item--submenu')
                            ->addClass('m-menu__toggle')
                            ->append($this->items($option))
                            ->setParentAttribute('m-menu-submenu-toggle', 'hover')
                    );
                }
            }
        })
            ->addClass('m-menu__nav m-menu__nav--dropdown-submenu-arrow')
            ->append('</div></div>')
            ->each(function (Link $link) {
                $link->addClass('m-menu__link')
                    ->addParentClass('m-menu__item')
                    ->setParentAttribute('aria-haspopup', 'true');
            })
            ->prepend(
                '<div id="m_aside_left" class="m-grid__item	m-aside-left m-aside-left--skin-dark">' .
                '<div id="m_ver_menu" class="m-aside-menu m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark" m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">'
            )
            ->setActive(url()->current())
            ->setActiveClass('m-menu__item--active')
        ;
    }

    /**
     * Dynamic instance of the models.
     *
     * @param string $model
     * @return Model
     */
    public static function dynamicModelInstance(string $model)
    {
        $model = '\\App\\' . str_replace('_', '', ucwords(str_replace('_id', '', $model), '_'));
        return  new $model;
    }

    /**
     * Dynamic instance of the requests.
     *
     * @param string $request
     * @return FormRequest
     */
    public static function dynamicRequestInstance(string $request)
    {
        $words = explode('_', $request);
        $requestName = '';

        foreach ($words as $word) $requestName .= ucwords(strtolower(str_singular($word)));

        $request = '\\App\\Http\\Requests\\' . $requestName . 'Request';

        return  new $request;
    }

    /**
     * Return data for the specified select.
     *
     * @param string $model
     * @param string $where
     * @param string $value
     * @return int
     */
    public static function findBy(string $model, string $where, $value)
    {
        $entity = Base::dynamicInstanceModel($model);
        $entity = $entity->where($where, $value)->first();
        return is_null($entity) ? -1 : $entity->id;
    }

    /**
     * Return data for the specified select.
     *
     * @param string $model
     * @return Response
     */
    public static function select(string $model)
    {
        return Base::dynamicModelInstance($model)->select();
    }

    /**
     * Return an array for the menu and bread crumbs.
     *
     * @return array
     */
    private function sections()
    {
        $menu = [];

        foreach (config('menu') as $section) {
            if (!isset($section['name'])) {
                $menu = array_merge($menu, $section['menu']);
            } else if (Auth::user()->hasRole($section['name'])) {
                array_push($menu, ['section' => $section['name']]);
                $menu = array_merge($menu, $section['menu']);
            }
        }

        return $menu;
    }
}