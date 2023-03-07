<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactController extends Controller
{
    public function __construct(protected CompanyRepository $company)
    //public function index()
    {
        /*
        $companies = [
            1 => ['name' => 'Company One', 'contacts' => 3],
            2 => ['name' => 'Company Two', 'contacts' => 5],
        ];
        $contacts = $this->getContacts();
        return view('contacts.index', compact('contacts', 'companies'));
        */
    }

    //public function index(CompanyRepository $company, Request $request)
    public function index()
    {
        //$companies = $company->pluck();
        $companies = $this->company->pluck();
        //$contacts = $this->getContacts();
        //$contacts = Contact::latest()->get();
        // $contacts = Contact::latest()->paginate(10);
        $contactsCollection = Contact::latest()->get();
        $perPage = 10;
        $currentPage = request()->query('page', 1);
        $items = $contactsCollection->slice(($currentPage * $perPage) - $perPage, $perPage);
        $total = $contactsCollection->count();
        $contacts = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query()
        ]);
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    //public function show(Request $request, $id)
    public function show($id)
    {
       /* $contacts = $this->getContacts();
        abort_unless(isset($contacts[$id]), 404);
        $contact = $contacts[$id];*/
        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact);
    }

    protected function getContacts()
    {
        return [
            1 => ['id' => 1, 'name' => 'Name 1', 'phone' => '1234567890'],
            2 => ['id' => 2, 'name' => 'Name 2', 'phone' => '2345678901'],
            3 => ['id' => 3, 'name' => 'Name 3', 'phone' => '3456789012'],
        ];
    }
}