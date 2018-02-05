<?php

namespace App\Http\Controllers\Backend\Api;

use App\Exceptions\ResourceException;
use App\Http\Controllers\ApiController;
use App\Models\Attachment;
use App\Transformers\Backend\AttachmentTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Storage;

class AttachmentsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $attachments = Attachment::recent()->paginate($this->perPage());

        return $this->response()->collection($attachments, new AttachmentTransformer());
    }

    public function update()
    {
    }

    public function show(Attachment $attachment)
    {
        return $this->response()->item($attachment, new AttachmentTransformer());
    }

    // 上传附件
    public function store(Request $request)
    {
        $attachment = $request->file('attachment');
        if (!empty($attachment) && $attachment->isValid()) {
            $path = $attachment->storeAs('uploads\\attachment', $this->attachmentHashName($attachment));
            if ($path) {
                $attachmentModel = $this->createAttachment($attachment, $path);

                return ['attachment_id' => $attachmentModel->id];
            }
        }

        $error = $attachment ? $attachment->getErrorMessage() : '附件上传失败';

        throw new ResourceException($error, ['attachment' => $error]);
    }

    private function attachmentHashName(UploadedFile $attachment)
    {
        $hashName = $attachment->hashName();

        return substr($hashName, 0, 2).DIRECTORY_SEPARATOR.substr($hashName, 2, 0);
    }

    private function createAttachment(UploadedFile $attachment, $path)
    {
        return Attachment::create([
            'uploader_id' => auth()->id(),
            'title'       => $attachment->getClientOriginalName(),
            'mime'        => $attachment->getMimeType(),
            'file_size'   => $attachment->getSize(),
            'path'        => $path,
        ]);
    }

    public function destroy(Attachment $attachment)
    {
        Storage::delete($attachment->path);
        $attachment->delete();

        return $this->response()->noContent();
    }
}
