<?php

namespace App\Http\Controllers\Book;

use App\DTO\Book\AddImageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreBookImageRequest;
use App\Http\Resources\Book\BookImageResource;
use App\Services\BookService;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookImageController extends Controller
{

    public function __construct(
        protected BookService $service,
    ) {}

    public function store(StoreBookImageRequest $request): JsonResponse
    {
        return BookImageResource::make($this->service->addImage(
            AddImageDTO::fromValues(
                FileService::saveFile($request->file('image')),
//                $request->validated('status'),
                $request->validated('language'),
                $request->validated('book_id')
            )
        ))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(int $id): BookImageResource
    {
        return BookImageResource::make(
            $this->service->findImage($id)
        );
    }

    public function update(Request $request, int $id)
    {
        //
    }

    public function destroy(string $id): JsonResponse
    {
        return BookImageResource::make(
            $this->service->deleteImage($id)
        )->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
