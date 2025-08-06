<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $contact = session('contact_input');

        return view('index', compact('categories', 'contact'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only(['last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail']);
        $category = \App\Models\Category::find($contact['category_id']);
        $categoryName = $category ? $category->content : '';

        session(['contact_input' => $contact]);

        return view('confirm', compact('contact', 'categoryName'));
    }

    public function store(Request $request)
    {
        $contact = $request->only(['last_name', 'first_name', 'gender', 'email', 'tel1', 'tel2', 'tel3', 'address', 'building', 'category_id', 'detail']);

        $contact['tel'] = $contact['tel1'] . '-' . $contact['tel2'] . '-' . $contact['tel3'];

        unset($contact['tel1'], $contact['tel2'], $contact['tel3']);
        Contact::create($contact);
        session()->forget('contact_input');

        return view('thanks');
    }
}
