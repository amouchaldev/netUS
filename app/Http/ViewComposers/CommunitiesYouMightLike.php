<?php
namespace App\Http\ViewComposers;

use App\Models\Community;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommunitiesYouMightLike {
    public function compose(View $view) {
        if (Auth::check()) {
            $recommendedCommunities = Community::whereDoesntHave('users')->limit(7)->get();
            $view->with(['recommendedCommunities' => $recommendedCommunities]);
        }
        else {
            $recommendedCommunities = Community::limit(7)->get();
            $view->with(['recommendedCommunities' => $recommendedCommunities]);
        }

    }
}


?>

