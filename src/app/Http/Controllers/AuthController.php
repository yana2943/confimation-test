<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(7);
        $contacts = Contact::with('category')->paginate(7);
        $categories = Category::all();

        return view('admin', compact('users', 'contacts', 'categories'));
    }

    public function search(Request $request)
    {
        $contacts = Contact::search($request->all())->paginate(7);
        $users = User::paginate(7);
        $categories = Category::all();

        return view('admin', compact('users', 'contacts', 'categories'));
    }

    public function export(Request $request): StreamedResponse
    {
        $contacts = Contact::with('category')
         ->when($request->keyword, function ($query, $keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                  ->orWhere('last_name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        })
        ->when($request->gender, fn($q, $gender) => $q->where('gender', $gender))
        ->when($request->category_id, fn($q, $categoryId) => $q->where('category_id', $categoryId))
        ->when($request->date, fn($q, $date) => $q->whereDate('created_at', $date))
        ->get();

        $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="contacts.csv"',
    ];

    $callback = function () use ($contacts) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['お名前', '性別', 'メールアドレス', 'お問い合わせの種類', 'お問い合わせ内容']);

        foreach ($contacts as $contact) {
            fputcsv($file, [
                $contact->last_name . ' ' . $contact->first_name,
                $contact->gender === 'male' ? '男性' : ($contact->gender === 'female' ? '女性' : 'その他'),
                $contact->email,
                $contact->category->content ?? '',
                $contact->content,
            ]);
        }

        fclose($file);
    };

    return Response::stream($callback, 200, $headers);


    }

    public function showLogin(Request $request)
    {
        return view('auth.login');
    }

    public function delete(Request $request): RedirectResponse
    {
        $contactId = $request->input('contact_id');

        if ($contactId) {
            Contact::find($contactId)?->delete();
        }

        return redirect('/admin');
    }
}
