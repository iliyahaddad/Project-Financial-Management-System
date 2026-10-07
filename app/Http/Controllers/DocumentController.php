<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('view', $project);
        $documents = $project->documents;
        return view('documents.index', compact('project', 'documents'));
    }

    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $request->validate([
            'file' => 'required|file|max:' . config('mali.upload_max_size', 10240) . '|mimes:' . implode(',', config('mali.allowed_mimes', [])),
            'name' => 'required|string',
        ]);
        $file = $request->file('file');
        $path = $file->store('documents/' . $project->id);
        $project->documents()->create([
            'name' => $request->name,
            'document_type' => $request->input('document_type', 'other'),
            'file_path' => $path,
            'file_size' => $file->getSize(),
            'mime_type' => $file->getClientMimeType(),
            'uploaded_by' => auth()->id(),
        ]);
        return back()->with('message', 'سند با موفقیت آپلود شد');
    }

    public function download(Project $project, Document $document)
    {
        $this->authorize('view', $project);
        if (!Storage::exists($document->file_path)) {
            abort(404);
        }
        return Storage::download($document->file_path, $document->name);
    }

    public function destroy(Project $project, Document $document)
    {
        $this->authorize('update', $project);
        $document->delete();
        return back()->with('message', 'سند حذف شد');
    }
}
