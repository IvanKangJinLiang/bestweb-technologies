<?php

namespace App\Exports;

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping; 

class UsersExport implements FromCollection, WithHeadings, WithMapping 
{
    public function collection()
    {
        return User::all(); 
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->phone_number,
            $user->status,
            $user->created_at ? $user->created_at->format('d/m/Y') : '', 
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Phone', 'Status', 'Joined Date'];
    }
}