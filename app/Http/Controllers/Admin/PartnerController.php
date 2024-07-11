<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Uploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;
use App\Http\Resources\Partner\AdminPartnerResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Partner;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('Partner Management', 'APIs for managing Partners')]
class PartnerController extends Controller
{
    use Uploader;

    public function __construct()
    {
        $this->setResource(AdminPartnerResource::class);
    }

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

        return $this->collection($partners);
    }

    #[Endpoint('Get Partner by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the Partner', true)]
    public function show(Partner $partner) {

        return $this->resource($partner);
    }

    #[Endpoint('Store Partner.')]
    #[BodyParam('name', 'string', 'The name of the Partner.')]
    #[BodyParam('website_lonk', 'string', 'The website_lonk of the Partner.')]
    #[BodyParam('avatar', 'file', 'The avatar of the Partner.')]
    public function store(StorePartnerRequest $request) {

        $data = $request->validated();

        $partner = Partner::create($data);

        if($request->hasFile('avatar')) {
            $partner->avatar = $this->uploadAttachment($request->avatar, 'partner-avatars');
            $partner->save();
        }

        return $this->resource($partner, method:'POST');
    }

    #[Endpoint('Update Partner.')]
    #[BodyParam('name', 'string', 'The name of the Partner.')]
    #[BodyParam('website_lonk', 'string', 'The website_lonk of the Partner.')]
    #[BodyParam('avatar', 'file', 'The avatar of the Partner.')]
    public function update(UpdatePartnerRequest $request, Partner $partner) {

        $data = $request->validated();

        $partner->update($data);

        if($request->hasFile('avatar')) {
            $partner->avatar = $this->uploadAttachment($data['avatar'], 'partner-avatars');
            $partner->save();
        }

        return $this->resource($partner, method:'PUT');
    }

    #[Endpoint('Delete Partner.')]
    #[UrlParam('slug', 'string', 'The slug of the Partner', true)]
    public function destroy(Partner $partner) {
        $partner->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
