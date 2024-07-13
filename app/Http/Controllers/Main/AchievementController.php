<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\Achievement\PublicAchievementResource;
use App\Models\Achievement;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\UrlParam;

#[Group('Public Endpoints')]
#[Subgroup('Achievements', 'API for Achievements.')]
class AchievementController extends Controller
{

    #[Endpoint('Get all achievements.')]
    #[QueryParam('filter[content]', 'string', 'filter achievements by title.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $achievements = QueryBuilder::for(Achievement::class)
                                ->allowedFilters(Achievement::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return PublicAchievementResource::collection($achievements);
    }

    #[Endpoint('Get Achievement by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Achievement', true)]
    public function show(Achievement $achievement) {

        return PublicAchievementResource::make($achievement->load(Achievement::allowedIncludes()));
    }
}
