<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class Customers extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $credit_limit = 0;
    public $password;
    public $is_active = true;
    
    public $selected_id;
    public $search = '';

    protected function rules()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'credit_limit' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ];

        if (!$this->selected_id) {
            $rules['password'] = 'required|min:6';
        } else {
            $rules['password'] = 'nullable|min:6';
            $customer = Customer::find($this->selected_id);
            if ($customer && $customer->user) {
                $rules['email'] = 'required|email|unique:users,email,' . $customer->user_id;
            }
        }

        return $rules;
    }

    public function render()
    {
        $customers = Customer::with('user')
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('phone', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.customers', [
            'customers' => $customers,
        ])->layout('components.layouts.admin', ['header' => 'إدارة الزبائن']);
    }

    public function create()
    {
        $this->reset(['name', 'email', 'phone', 'address', 'credit_limit', 'password', 'is_active', 'selected_id']);
    }

    public function edit($id)
    {
        $record = Customer::with('user')->findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->email = $record->user ? $record->user->email : $record->email;
        $this->phone = $record->phone;
        $this->address = $record->address;
        $this->credit_limit = $record->credit_limit;
        $this->is_active = $record->is_active;
        $this->password = ''; 
    }

    public function save()
    {
        $this->validate();

        if ($this->selected_id) {
            $customer = Customer::find($this->selected_id);
            
            // Update User
            if ($customer->user) {
                $userData = [
                    'name' => $this->name,
                    'email' => $this->email,
                ];
                if ($this->password) {
                    $userData['password'] = Hash::make($this->password);
                }
                $customer->user->update($userData);
            }

            // Update Customer
            $customer->update([
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email, // Keep email in sync just in case
                'address' => $this->address,
                'credit_limit' => $this->credit_limit,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'تم تحديث بيانات الزبون بنجاح.');
        } else {
            // Create User
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);

            // Create Customer
            Customer::create([
                'user_id' => $user->id,
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'address' => $this->address,
                'credit_limit' => $this->credit_limit,
                'is_active' => $this->is_active,
            ]);

            session()->flash('message', 'تم إضافة الزبون بنجاح.');
        }

        $this->reset(['name', 'email', 'phone', 'address', 'credit_limit', 'password', 'is_active', 'selected_id']);
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            if ($customer->user) {
                $customer->user->delete();
            }
            $customer->delete();
            session()->flash('message', 'تم حذف الزبون بنجاح.');
        }
    }
}
