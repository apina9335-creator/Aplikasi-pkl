<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\InternshipApplication;
use Illuminate\Support\Facades\Auth;

class InternshipApplicationsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $updatesQueryString = ['search'];

    protected $listeners = ['refreshTable' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = InternshipApplication::with('company')
            ->where('user_id', Auth::id())
            ->when($this->search, function($q) {
                $q->where(function($sub) {
                    $sub->where('school', 'like', "%{$this->search}%")
                        ->orWhere('motivation', 'like', "%{$this->search}%")
                        ->orWhereHas('company', function($c) {
                            $c->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection);

        $applications = $query->paginate($this->perPage);

        return view('livewire.student.internship-applications-table', compact('applications'));
    }
}
