<?php

namespace App\Http\Controllers;

use App\Models\Quota;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UserController extends Controller
{
    private const EXPORT_FLAG_COLUMNS = [
        'Important' => 'important',
        'Shot' => 'shot',
        'Questionnaire' => 'questionnaire',
        'Interviewed' => 'interviewed',
        'Eject' => 'eject',
        'NL' => 'nl',
        'FR' => 'fr',
        'REPRO' => 'repro',
        'DOUTE' => 'doute',
        'LGTB' => 'lgtb',
        'SENIOR' => 'senior',
        'RACISES' => 'racises',
    ];

    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('users.index');
    }

    public function show(User $user)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return view('users.show', [
            'user' => $user,
            'votes' => Vote::count(),
            'quotas' => Quota::orderBy('order')->get(),
        ]);
    }

    public function destroy(User $user)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $user->delete();

        return back();
    }

    public function export_users(): StreamedResponse
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            fputcsv($handle, [
                'Order',
                'ID',
                'Firstname',
                'Lastname',
                'Birthday',
                'Gender',
                'Email',
                'Phone',
                'Zip Code',
                'Video Consent',
                ...array_keys(self::EXPORT_FLAG_COLUMNS),
            ], ';');

            User::orderBy('order')->chunk(500, function ($users) use ($handle): void {
                foreach ($users as $row) {
                    $exportFlags = array_map(
                        fn (string $field): string => $this->sanitizeCsvCell($this->flagToCsvValue((bool) data_get($row, $field))),
                        array_values(self::EXPORT_FLAG_COLUMNS),
                    );

                    fputcsv($handle, [
                        $this->sanitizeCsvCell($row->order),
                        $this->sanitizeCsvCell($row->id),
                        $this->sanitizeCsvCell($row->name),
                        $this->sanitizeCsvCell($row->lastname),
                        $this->sanitizeCsvCell($row->birthday?->format('d-m-Y')),
                        $this->sanitizeCsvCell($row->sex),
                        $this->sanitizeCsvCell($row->email),
                        $this->sanitizeCsvCell($row->phone),
                        $this->sanitizeCsvCell($row->zip),
                        $this->sanitizeCsvCell($this->flagToCsvValue((bool) $row->video)),
                        ...$exportFlags,
                    ], ';');
                }
            });

            fclose($handle);
        }, 'participants.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function export(User $user): StreamedResponse
    {
        Gate::allowIf(fn (User $authUser) => $authUser->role === 2);

        $filenameBase = Str::slug($user->name.'-'.$user->lastname);
        $filename = ($filenameBase !== '' ? $filenameBase : 'user-'.$user->id).'.csv';

        return response()->streamDownload(function () use ($user): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            $answers = data_get($user, 'answers.answers', []);
            $boosters = data_get($answers, 'boosters', []);

            fputcsv($handle, [
                '#',
                'Category',
                'Question',
                'Answer',
                'Booster',
                ...array_keys(self::EXPORT_FLAG_COLUMNS),
            ], ';');

            Quota::orderBy('order')->chunk(500, function ($quotas) use ($handle, $answers, $boosters, $user): void {
                foreach ($quotas as $row) {
                    $exportFlags = array_map(
                        fn (string $field): string => $this->sanitizeCsvCell($this->flagToCsvValue((bool) data_get($user, $field))),
                        array_values(self::EXPORT_FLAG_COLUMNS),
                    );

                    fputcsv($handle, [
                        $this->sanitizeCsvCell($row->order),
                        $this->sanitizeCsvCell($row->category),
                        $this->sanitizeCsvCell($row->question_fr),
                        $this->sanitizeCsvCell(strtoupper((string) data_get($answers, $row->id, ''))),
                        $this->sanitizeCsvCell(in_array($row->id, $boosters, true) ? '1' : ''),
                        ...$exportFlags,
                    ], ';');
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function flagToCsvValue(bool $value): string
    {
        return $value ? '1' : '';
    }

    private function sanitizeCsvCell(mixed $value): string
    {
        $stringValue = (string) ($value ?? '');

        if ($stringValue !== '' && in_array($stringValue[0], ['=', '+', '-', '@'], true)) {
            return "'".$stringValue;
        }

        return $stringValue;
    }
}
