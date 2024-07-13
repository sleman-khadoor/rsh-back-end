<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Achievement\StoreAchievementRequest;
use App\Http\Requests\Achievement\UpdateAchievementRequest;
use App\Http\Resources\Achievement\AdminAchievementResource;
use App\Models\Achievement;
use App\Traits\HasChildRecords;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\QueryParam;
use Knuckles\Scribe\Attributes\Subgroup;
use Knuckles\Scribe\Attributes\UrlParam;
use Symfony\Component\HttpFoundation\Response;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Admin Endpoints')]
#[Subgroup('Achievement Management', 'APIs for managing Blog Categories')]
class AchievementController extends Controller
{

    use HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminAchievementResource::class);
    }

    #[Endpoint('Get all achievements.')]
    #[QueryParam('filter[content]', 'string', 'filter achievements by title.', false)]
    #[UrlParam('page', 'integer', 'The page number', example: 1)]
    #[UrlParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $achievements = QueryBuilder::for(Achievement::class)
                                ->allowedFilters(Achievement::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($achievements);
    }

    #[Endpoint('Get Achievement by id.')]
    #[UrlParam('id', 'integer', 'The ID of the Achievement', true)]
    public function show(Achievement $Achievement) {

        return $this->resource($Achievement);
    }

    #[Endpoint('Store Achievement.')]
    #[BodyParam('content', 'array', 'The title of the Achievement.')]
    public function store(StoreAchievementRequest $request) {

        $achievement = Achievement::create($request->validated());

        return $this->resource($achievement, method:'POST');
    }

    #[Endpoint('Update Achievement.')]
    #[UrlParam('id', 'integer', 'The ID of the Achievement', true)]
    #[BodyParam('title', 'array', 'The title of the Achievement.')]
    public function update(UpdateAchievementRequest $request, Achievement $achievement) {

        $achievement->update($request->validated());

        return $this->resource($achievement, method:'PUT');
    }

    #[Endpoint('Delete Achievement.')]
    #[UrlParam('id', 'integer', 'The ID of the Achievement', true)]
    public function destroy(Achievement $achievement) {

        $achievement->delete();

        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
