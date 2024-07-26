<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Http\Resources\News\AdminNewsResource;
use App\Traits\Uploader;
use App\Models\News;
use App\Traits\HasChildRecords;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Subgroup;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\UrlParam;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\QueryParam;

#[Group('Admin Endpoints')]
#[Subgroup('News Management', 'APIs for managing News')]
class NewsController extends Controller
{

    use Uploader, HasChildRecords;

    public function __construct()
    {
        $this->setResource(AdminNewsResource::class);
    }

    #[Endpoint('Get all News.')]
    #[QueryParam('filter[title]', 'string', 'filter News by title.', false)]
    #[QueryParam('page', 'integer', 'The page number', example: 1)]
    #[QueryParam('perPage', 'integer', 'Number of items pre page', example: 3)]
    public function index(Request $request) {

        $news = QueryBuilder::for(News::class)
                            ->allowedFilters(News::allowedFilters())
                            ->defaultSort('-id')
                            ->paginate($request->perPage, ['*'], 'page', $request->page);

        return $this->collection($news);
    }

    #[Endpoint('Get News by slug.')]
    #[UrlParam('slug', 'string', 'The slug of the News', true)]
    public function show(News $news) {
        return $this->resource($news);
    }

    #[Endpoint('Store News.')]
    #[BodyParam('title', 'array', 'The title of the News.')]
    #[BodyParam('content', 'array', 'The content of the News.')]
    #[BodyParam('cover_image', 'file', 'The cover image of the News.')]
    public function store(StoreNewsRequest $request) {

        $news = News::create($request->validated());

        if($request->hasFile('cover_image')) {
            $news->cover_image = $this->uploadAttachment($request->file('cover_image'), 'news_covers');
            $news->save();
        }

        return $this->resource($news, method: 'POST');
    }

    #[Endpoint('Update News.')]
    #[UrlParam('slug', 'integer', 'The slug of the News', true)]
    #[BodyParam('title', 'array', 'The title of the News.')]
    #[BodyParam('content', 'array', 'The content of the News.')]
    #[BodyParam('cover_image', 'file', 'The cover_image of the News.')]
    public function update(UpdateNewsRequest $request, News $news) {

        $news->update($request->validated());

        if($request->hasFile('cover_image')) {
            $news->cover_image = $this->uploadAttachment($request->file('cover_image'), 'news_covers');
            $news->save();
        }

        return $this->resource($news, method:'PUT');
    }

    #[Endpoint('Delete News.')]
    #[UrlParam('slug', 'integer', 'The slug of the News.', true)]
    public function destroy(News $news) {

        $news->delete();
        
        return $this->success([], config('response-messages.crud.delete_success'), Response::HTTP_OK);
    }
}
