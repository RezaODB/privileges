<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Quota;
use App\Models\Section;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class ProController extends Controller
{
    public function index(): RedirectResponse
    {
        $section = Section::query()->published()->ordered()->firstOrFail();

        return redirect()->route('pro.show', $section);
    }

    public function show(Section $section): View
    {
        abort_unless($section->published, Response::HTTP_NOT_FOUND);

        return view('pro.show', [
            'section' => $section,
            'sections' => Section::query()->published()->ordered()->get(),
            'chapters' => $section->chapters()->forLocale(app()->getLocale())->ordered()->get(),
            'quotas' => $section->shows_quota
                ? Quota::query()->orderBy('order')->get()
                : collect(),
            'films' => $section->films()->ordered()->get(),
            'documents' => Document::query()->forLocale(app()->getLocale())->ordered()->get(),
            'header' => 'includes.pro-header',
        ]);
    }
}
