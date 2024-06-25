<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookCategory\PublicBookCategoryResource;
use App\Models\BookCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;




#[Group('Public Endpoints')]
#[Subgroup('Book Categories', 'API for Book Categories.')]
class BookCategoryController extends Controller
{

    #[Endpoint('Get all Book Categories.')]
    #[Header("lang", "ar")]
    public function __invoke()
    {
        $bookCategories = QueryBuilder::for(BookCategory::class)
                                ->defaultSort('-id')
                                ->get();

        return PublicBookCategoryResource::collection($bookCategories);
    }
}
