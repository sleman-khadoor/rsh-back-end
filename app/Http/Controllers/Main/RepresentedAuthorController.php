<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepresentedAuthor\PublicRepresentedAuthorResource;
use App\Models\Author;
use App\Models\RepresentedAuthor;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\UrlParam;


#[Group('Public Endpoints')]
#[Subgroup('Authors', 'APIs for Authors')]
class RepresentedAuthorController extends Controller
{

    #[Endpoint('Get all Represented Authors.')]
    #[Header("lang", "ar")]
    #[QueryParam('filter[name]', 'string', 'filter Authors by name.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $authors = QueryBuilder::for(RepresentedAuthor::class)
                            ->allowedFilters(RepresentedAuthor::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);


        return PublicRepresentedAuthorResource::collection($authors);
    }

    #[Endpoint('Get Represented Author by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Author', true)]
    public function show(RepresentedAuthor $author) {

        return PublicRepresentedAuthorResource::make($author->load(RepresentedAuthor::allowedIncludes()));
    }
}
