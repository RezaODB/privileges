<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vote;
use App\Models\Quota;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);
        
        return view('users.index', [
            'users' => User::with('answers')->orderBy('order')->get(),
            'quotas' => Quota::count(),
            'votes' => Vote::count()
        ]);
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

    public function export_users()
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = User::orderBy('order')->get();

        $handle = fopen(storage_path('app/public/participants.csv'), 'w');

        fputcsv($handle, [
            "Order",
            "ID",
            "Firstname",
            "Lastname",
            "Birthday",
            "Gender",
            "Email",
            "Phone",
            "Zip Code",
            "Video Consent",
        ], ';');

        foreach ($data as $row) {
	        fputcsv($handle, [
                $row->order,
                $row->id,
                $row->name,
                $row->lastname,
                $row->birthday->format('d-m-Y'),
                $row->sex,
                $row->email,
                $row->phone,
                $row->zip,
                $row->video ? 'YES' : ''
            ], ';');
        }

        fclose($handle);

        return response()->download(storage_path('app/public/participants.csv'));
    }

    public function export(User $user)
    {
        Gate::allowIf(fn (User $user) => $user->role === 2);

        $data = Quota::orderBy('order')->get();

        $handle = fopen(storage_path('app/public/' . $user->name . '-' . $user->lastname . '.csv'), 'w');

        fputcsv($handle, [
            "#",
            "Category",
            "Question",
            "Answer",
            "Booster",
        ], ';');

        foreach ($data as $row) {
	        fputcsv($handle, [
                $row->order,
                $row->category,
                $row->question_fr,
                strtoupper(data_get($user->answers->answers, $row->id)),
                in_array($row->id, data_get($user->answers->answers, 'boosters', [])) ? 'YES' : '' 
            ], ';');
        }

        fclose($handle);

        return response()->download(storage_path('app/public/' . $user->name . '-' . $user->lastname . '.csv'));
    }
}
