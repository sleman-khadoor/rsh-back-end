<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogCategory\PublicBlogCategoryResource;
use App\Models\BlogCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Header;




#[Group('Public Endpoints')]
#[Subgroup('Blog Categories', 'API for Blog Categories.')]
class BlogCategoryController extends Controller
{

    #[Endpoint('Get all Blog Categories.')]
    #[Header("lang", "ar")]
    public function __invoke()
    {
        $blogCategories = QueryBuilder::for(BlogCategory::class)
                                ->defaultSort('-id')
                                ->get();

        return PublicBlogCategoryResource::collection($blogCategories);
    }
}
