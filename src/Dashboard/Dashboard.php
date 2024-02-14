<?php

namespace CitadelKit\Garuda;

use CitadelKit\Garuda\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;

class Dashboard {
    private static $instance = null;

    public $title = "Dashboard";
    public $name = "escm_wika";
    public $prefix = "ESCM WIKA";

    protected $buttons = [];

    protected $table = false;
    protected $table_view = "template.index_page";

    protected $form = null;

    private static $escape_char = [';','/','\\', ''];

    protected function __construct() {}

    public static function getInstance() {
        if(!Dashboard::$instance) {
            Dashboard::$instance = new Dashboard();
        }
        return Dashboard::$instance;
    }

    public static function make($name, $title = "") {
        $obj = Dashboard::getInstance();
        $obj->name = Str::snake(str_replace(static::$escape_char, '_', $name));
        $obj->title = $title == "" ? $name : $title;
        return $obj;
    }

    public function prefix($prefix)
    {
        $this->prefix = $prefix;
        return $this;
    }

    public function view($view = null, $data = [], $mergeData = []) {
        $this->pageInfoShare();

        return view($view, $data, $mergeData);
    }

    public function pageInfoShare() {
        $user = auth()->check() ? auth()->user() : new (config('garuda.user_model'));
        $menu = Menu::getAdminSidebarMenuRender();
        $page_info = Dashboard::getInstance()->getPageInfo();
        View::share([
            'menu' => $menu,
            'page_info' => $page_info,
            'user' => $user,
        ]);
    }

    public function getPageInfo()
    {
        return [
            'name' => $this->name,
            'title' => $this->title,
            'prefix' => $this->prefix,
        ];
    }

    public function table(Table $table)
    {
        $this->table = $table;
        return $this;
    }

    public function form(Form $form) {
        $this->form = $form;
        return $this;
    }

    public function buttons($buttons = [])
    {
        $this->buttons = $buttons;
        return $this;
    }

    public function renderButtons()
    {
        $html = "";
        foreach($this->buttons as $b) {
            $html .= $b->render();
        }
        return $html;
    }

    public function render() {
        if($this->form) {
            $this->pageInfoShare();
            return $this->form->render();
        }
        if(request()->get('get_config') || request()->get('offset') || request()->get('limit')) {
            return $this->table->render();
        } else {
            if($this->table) {
                $this->pageInfoShare();
                return view('template.index_page', [
                    'control_action' => $this->renderButtons(),
                    'table_id' => "table_".($this->name),
                    'table_src' => url()->current(),
                ]);
            }
        }
    }
}
