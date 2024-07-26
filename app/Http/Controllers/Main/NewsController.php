<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\News\PublicNewsResource;
use App\Models\News;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\UrlParam;


#[Group('Public Endpoints')]
#[Subgroup('News', 'APIs for News')]
class NewsController extends Controller
{

    #[Endpoint('Get all News.')]
    #[Header("lang", "ar")]
    #[QueryParam('filter[title]', 'string', 'filter News by title.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $news = QueryBuilder::for(News::class)
                            ->allowedFilters(News::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return PublicNewsResource::collection($news);
    }

    #[Endpoint('Get News by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the News', true)]
    public function show(News $news) {

        return PublicNewsResource::make($news->load(News::allowedIncludes()));
    }
}
