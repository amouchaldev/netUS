<?php
namespace App\Http\ViewComposers;

use App\Models\Community;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CommunitiesYouMightLike {
    public function compose(View $view) {
        if (Auth::check()) {
            $recommendedCommunities = Cache::remember('recommendedCommunities', now()->addWeek(), function () {
                return Community::whereDoesntHave('users')->limit(7)->get();
            });
            $view->with(['recommendedCommunities' => $recommendedCommunities]);
        }
        else {
            $recommendedCommunities = Cache::remember('recommendedCommunitiesNotAuth', now()->addWeek(), function () {
                return Community::limit(7)->get();
            });
            $view->with(['recommendedCommunities' => $recommendedCommunities]);
        }

    }
}


?>

