<?php

namespace CitadelKit\Garuda\Models;

use App\Models\Traits\ActivityLogged;
use App\Models\Traits\HasCreator;
use App\Models\Traits\ParentChildMaker;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class Menu extends Model
{
    use HasFactory;

    protected $table = "escm_menus";
    protected $guarded = ['id'];
    protected $hidden = [
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id');
    }

    public static function makerDefaultParentId() {
        return 0;
    }

    public function getIsActiveAttribute()
    {
        if (empty($this->url) || $this->url == "#") {
            return false;
        }
        $menu_url = str_replace("/", "\/", $this->url);
        $url = request()->path();
        $result = 0;
        $pattern = "/^" . $menu_url . "*/";
        preg_match($pattern, $url, $result);
        return !empty($result);
    }

    public function render()
    {
        return view('components.menu_list_item', [
            "menu" => $this
        ])->render();
    }

    public function renderChild()
    {
        $html = "";
        foreach ($this->children as $child) {
            $html .= $child->render();
        }
        return $html;
    }

    public static function getAdminSidebarMenuRender()

    {
        if (!Auth::check()) {
            return [];
        }
        $menus = Menu::where('parent_id', '0')
            // ->where('roles', 'LIKE', "%\"$role_id\"%")
            ->orderBy('sequence', 'asc')->with('children')->get();
        $result = '';
        foreach ($menus as $menu) {
            $result .= $menu->render();
        }
        return $result;
    }
}
