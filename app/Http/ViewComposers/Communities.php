<?php
namespace App\Http\ViewComposers;

use App\Models\Community;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class Communities {


    public function compose(View $view) {
        $communities = Cache::remember('communities', now()->addMonth(), function () {
            return Community::all();
        });
            // $communities = Community::all();
            $view->with(['communities' => $communities]);
    }

}

?>

