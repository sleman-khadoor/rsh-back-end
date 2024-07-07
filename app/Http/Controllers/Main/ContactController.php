<?php

namespace App\Http\Controllers\Main;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\PublicContactResource;
use Spatie\QueryBuilder\QueryBuilder;

class ContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $contacts = QueryBuilder::for(Contact::class)
                                ->allowedIncludes(Contact::allowedIncludes())
                                ->allowedFilters(Contact::allowedFilters())
                                ->defaultSort('-id')
                                ->paginate($request->perPage, ['*'], 'page', $request->page);

        return PublicContactResource::collection($contacts);

    }
}
