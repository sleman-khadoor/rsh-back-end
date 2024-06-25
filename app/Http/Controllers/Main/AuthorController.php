<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\Author\PublicAuthorResource;
use App\Models\Author;
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
class AuthorController extends Controller
{

    #[Endpoint('Get all Authors.')]
    #[Header("lang", "ar")]
    #[QueryParam('filter[name]', 'string', 'filter Authors by name.', false)]
    #[QueryParam('include[]', 'array', 'include authors relations', false, example: 'include[] = books')]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $authors = QueryBuilder::for(Author::class)
                            ->allowedIncludes(['books'])
                            ->allowedFilters(['name'])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);


        return PublicAuthorResource::collection($authors);
    }

    #[Endpoint('Get Author by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Author', true)]
    public function show(Author $author) {

        return PublicAuthorResource::make($author->load($author->relations()));
    }
}
