<?php

namespace App\Http\Controllers\Public\Book;

use App\Http\Controllers\Controller;
use App\Http\Resources\Book\BookCategory\PublicBookCategoryResource;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;




#[Group('Public Endpoints')]
#[Subgroup('Book Categories', 'API for detching Book Categories.')]
class BookCategoryController extends Controller
{

    #[Endpoint('Get all Book Categories.')]
    #[Header("lang", "ar")]
    public function __invoke(Request $request)
    {
        $bookCategories = QueryBuilder::for(BookCategory::class)
                                ->defaultSort('-id')
                                ->get();

        return PublicBookCategoryResource::collection($bookCategories);
    }
}
