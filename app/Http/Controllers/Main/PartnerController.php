<?php

namespace App\Http\Controllers\Main;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\FilterPartnerByCategory;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Http\Resources\Partner\PublicPartnerResource;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Public Endpoints')]
#[Subgroup('Partners', 'APIs for Partners')]
class PartnerController extends Controller
{

    #[Endpoint('Get all Partners.')]
    #[QueryParam('filter[name]', 'string', 'filter Partners by name.', false)]
    #[QueryParam('filter[website_link]', 'string', 'filter Partners by website link.', false)]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $partners = QueryBuilder::for(Partner::class)
                            ->allowedFilters([
                                ...Partner::allowedFilters(),
                                ])
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return PublicPartnerResource::collection($partners);
    }

    #[Endpoint('Get Partner by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Partner', true)]
    public function show(Partner $partner) {

        return PublicPartnerResource::make($partner);
    }
}
